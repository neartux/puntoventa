<?php

/**
 * User: ricardo
 * Date: 19/03/18
 */

namespace App\Repository\sale;


use App\Models\Caja;
use App\Models\Client;
use App\Models\MovementsCaja;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Repository\Product\ProductInterface;
use App\Utils\Keys\common\ApplicationKeys;
use App\Utils\Keys\common\NumberKeys;
use App\Utils\Keys\common\StatusKeys;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleRepository implements SaleInterface {

    private $client;
    private $productRepository;
    private $caja;
    private $sale;

    function __construct(Client $client, ProductInterface $product, Caja $caja, Sale $sale) {
        $this->client = $client;
        $this->productRepository = $product;
        $this->caja = $caja;
        $this->sale = $sale;
    }

    public function findCajaOpened() {
        return $this->caja->findCajaOpen();
    }

    public function openCaja($userId, $amount, $comments) {
        $caja = $this->caja->findCajaOpen();
        // Valida que no exista caja abierta
        if ($caja) {
            throw new \Exception("Ya existe una caja abierta");
        }
        $caja = new Caja();
        $caja->status_id = StatusKeys::STATUS_OPEN;
        $caja->user_opening_id = $userId;
        $caja->opening_date = Carbon::now();
        $caja->opening_amount = floatval($amount);
        $caja->total_earnings = NumberKeys::NUMBER_ZERO;
        $caja->total_withdrawals = NumberKeys::NUMBER_ZERO;
        $caja->total_amount = floatval($amount);
        $caja->comments = $comments;

        $caja->save();

        // Crea movimiento de caja de apertura
        $this->createMovementCaja(ApplicationKeys::MOVEMENT_TYPE_ENTRADA, null, null,
            floatval($amount), 'Abriendo Caja', '');

        return $caja;
    }

    public function closeCaja($userId) {
        $caja = $this->caja->findCajaOpen();
        // Valida que no exista caja abierta
        if (! $caja) {
            throw new \Exception("No hay caja abierta");
        }
        $caja->user_close_id = $userId;
        $caja->close_date = Carbon::now();
        $caja->status_id = StatusKeys::STATUS_CLOSED;

        $caja->save();
    }


    public function createSale($arraySale) {
        //print_r($arraySale);
        $sale = new Sale();
        $sale->status_id = StatusKeys::STATUS_ACTIVE;
        $sale->user_id = Auth::user()->id;
        $clientId = $arraySale['client']['id'];
        // Termina el proceso si el cliente no existe
        if (!$this->client->existClientById($clientId)) {
            throw new \Exception("El cliente es invalido");
        }
        $sale->client_id = $clientId;
        $sale->created_at = Carbon::now();
        $total = $this->getTotalSaleByProducts($arraySale['products']);
        $taxes = floatval($total * ApplicationKeys::PORCENT_TAXES_MEXICO);
        $sale->total = $total;
        $sale->taxes = $taxes;
        $sale->subtotal = floatval($total - $taxes);
        $sale->comments = $arraySale['comments'];
        $sale->total_discount = $arraySale['total_discount'];
        $sale->amount_pay = $arraySale['amount_pay'];

        $sale->save();

        // Guarda las formas de pago
        $this->savePaymentMethods($sale, $arraySale['paymentMethods']);

        // Crea los detalles de la venta
        $this->createSaleDetails($sale->id, $arraySale);

        // Actualiza el stock por producto
        $this->updateProductStock($sale->id, $arraySale, Auth::user()->id);

        // Genera movimiento de caja
        $this->createMovementCaja(ApplicationKeys::MOVEMENT_TYPE_ENTRADA, null, $sale->id,
            $sale->total, 'Sale', $sale->comments);

        // Actualiza los totales de la caja
        $this->addEarningToCaja($sale->total);

        return $sale->id;
    }

    private function getTotalSaleByProducts($products) {
        $total = NumberKeys::NUMBER_ZERO;
        foreach ($products as $product) {
            $total += (floatval($product['quantity']) * floatval($product['price']));
        }
        return $total;
    }

    private function savePaymentMethods($sale, $paymentMethods) {
        foreach ($paymentMethods as $paymentMethod) {
            $this->sale->find($sale->id)->paymentMethods()->save($sale, ['sale_id' => $sale->id, 'payment_method_id' => $paymentMethod['idPaymentMethod'], 'amount' => $paymentMethod['amount']]);
        }
    }

    private function createSaleDetails($saleId, $arraySale) {
        foreach ($arraySale['products'] as $product) {
            $saleDetail = new SaleDetail();
            $saleDetail->status_id = StatusKeys::STATUS_ACTIVE;
            $saleDetail->sale_id = $saleId;
            $saleDetail->product_id = $product['id'];
            $saleDetail->quantity = $product['quantity'];
            $saleDetail->product_price = $product['price'];
            $saleDetail->apply_wholesale = $product['apply_wholesale'] == "true" ? NumberKeys::NUMBER_ONE : NumberKeys::NUMBER_ZERO;
            $saleDetail->promotion_id = null;
            $saleDetail->discount = $product['percent_discount'];

            $saleDetail->save();
        }
    }

    private function updateProductStock($saleId, $arraySale, $userId) {
        foreach ($arraySale['products'] as $product) {
            // Crea una ajuste del producto
            $this->productRepository->createAdjustment($userId, ApplicationKeys::ADJUSTMENT_REASON_BY_SALE,
                $product['id'], $saleId, $product['quantity'], $arraySale['comments']);
            // Ajusta el stock
            $this->productRepository->updateStockByIdProduct($product['id'], $product['quantity'], false);
        }
    }

    private function createMovementCaja($movementType, $reasonWithdrawal, $saleId, $amount, $reference, $comments) {
        // Busca la caja abierta
        $caja = $this->caja->findCajaOpen();
        // Valida que exista caja abierta
        if (! $caja) {
            throw new \Exception("No hay caja abierta");
        }
        // Crea el movimiento
        $movement = new MovementsCaja();
        $movement->status_id = StatusKeys::STATUS_ACTIVE;
        $movement->movement_type_id = $movementType;
        $movement->reason_withdrawal_caja_id = $reasonWithdrawal;
        $movement->sale_id = $saleId;
        $movement->caja_id = $caja->id;
        $movement->amount = $amount;
        $movement->reference = $reference;
        $movement->created_at = Carbon::now();
        $movement->comments = $comments;

        $movement->save();
    }

    private function addEarningToCaja ($amount) {
        // Busca la caja abierta
        $caja = $this->caja->findCajaOpen();
        // Valida que exista caja abierta
        if (! $caja) {
            throw new \Exception("No hay caja abierta");
        }
        $caja->total_earnings = floatval($caja->total_earnings + $amount);
        $caja->total_amount = floatval($caja->total_amount + $amount);

        $caja->save();
    }

    public function findSalesCajaOpened() {
        // Busca la caja abierta
        $caja = $this->caja->findCajaOpen();
        $cajaId = NumberKeys::NUMBER_ZERO;
        // Valida que exista caja abierta
        if ($caja) {
            $cajaId = $caja->id;
        }
        return $this->findSalesByCaja($cajaId);
    }

    public function findDetailsByIdSale($saleId) {
        return DB::select('SELECT sale_details.id,products.code,products.description,sale_details.quantity,sale_details.product_price
                  FROM sale_details
                  INNER JOIN products ON sale_details.product_id = products.id
                  WHERE sale_details.sale_id = '.$saleId.'
                  AND sale_details.status_id = '.StatusKeys::STATUS_ACTIVE);
    }

    public function cancelSale($saleId, $userId) {
        $sale = $this->sale->findOrFail($saleId);
        // Validar que la venta este activa
        if ($sale->status_id != StatusKeys::STATUS_ACTIVE) {
            throw new \Exception('No se puede cancelar la venta, verifique el estatus');
        }

        $sale->status_id = StatusKeys::STATUS_CANCELLED;
        $sale->save();

        // Genera el movimiento de caja
        $this->createMovementCaja(ApplicationKeys::MOVEMENT_TYPE_SALIDA, ApplicationKeys::REASON_WITHDRAWAL_SALE_CANCELLATION, $sale->id,
            $sale->total, 'Sale Cancelled', '');
        // Resta el monto a la caja
        try {
            $this->subtractAmountToCaja($sale->total);
        } catch (\Exception $e) {
            throw new $e;
        }
        // Regresa el producto al inventario
        $this->returnProductToStock($sale, $userId);
    }

    private function returnProductToStock($sale, $userId) {
        // Por cada producto realiza ajuste
        foreach ($sale->saleDetails as $detail) {
            // Crea una ajuste del producto
            $this->productRepository->createAdjustment($userId, ApplicationKeys::ADJUSTMENT_REASON_BY_SALE_CANCELLATION,
                $detail->product->id, $sale->id, $detail->quantity, 'Cancellation');
            // Ajusta el stock
            $this->productRepository->updateStockByIdProduct($detail->product->id, $detail->quantity, true);
        }
    }

    private function subtractAmountToCaja($amount) {
        // Busca la caja abierta
        $caja = $this->caja->findCajaOpen();
        // Valida que exista caja abierta
        if (! $caja) {
            throw new \Exception("No hay caja abierta");
        }
        $caja->total_withdrawals = floatval($caja->total_withdrawals + $amount);
        $caja->total_amount = floatval($caja->total_amount - $amount);

        $caja->save();
    }

    public function applyWithdrawal($reasonId, $amount, $reference, $comments) {
        // Busca la caja abierta
        $caja = $this->caja->findCajaOpen();
        // Valida que exista caja abierta
        if (! $caja) {
            throw new \Exception("No hay caja abierta");
        }
        // Busca el efectivo en caja
        $cash = $this->findEfectivoByCaja($caja->id);
        // Busca lo retirado de caja
        $withdrawal = $this->findEfectivoRetiradoByCaja($caja->id);
        // Calcula el disponible
        $saldo = $cash - $withdrawal;
        // Valida que alla disponible
        if($saldo <= NumberKeys::NUMBER_ZERO) {
            throw new \Exception("No hay efectivo disponible en caja");
        }
        try {
            // Crea el movimiento de caja
            $this->createMovementCaja(ApplicationKeys::MOVEMENT_TYPE_SALIDA, $reasonId, null, $amount, $reference, $comments);
            // Aplica retiro a la caja
            $this->subtractAmountToCaja($amount);
        } catch (\Exception $e) {
            throw new $e;
        }
    }

    public function findCajasByDate($startDate, $endDate) {
        return DB::select("SELECT caja.id,DATE_FORMAT(opening_date, '".ApplicationKeys::PATTERN_FORMAT_DATE_WITH_HOUR."') AS opening_date,
                DATE_FORMAT(close_date, '".ApplicationKeys::PATTERN_FORMAT_DATE_WITH_HOUR."') AS close_date,opening_amount,total_earnings,total_withdrawals,total_amount,comments,
                uo.user_name AS user_open,uc.user_name AS user_close
                FROM caja
                INNER JOIN users uo ON caja.user_opening_id = uo.id
                INNER JOIN users uc ON caja.user_close_id = uc.id
                WHERE caja.status_id = ".StatusKeys::STATUS_CLOSED."
                AND caja.close_date BETWEEN '".$startDate."' AND '".$endDate."'");
    }

    public function findSalesByCaja($cajaId) {
        return DB::select("SELECT sales.*,DATE_FORMAT(sales.created_at, '".ApplicationKeys::PATTERN_FORMAT_DATE_WITH_HOUR."') AS created_at,personal_data.name AS client_name,personal_data.last_name AS client_last_name,
                pdu.name AS name_user,pdu.last_name AS last_name_user
                FROM movements_caja,sales,clients,personal_data,users,personal_data AS pdu
                WHERE movements_caja.status_id = ".StatusKeys::STATUS_ACTIVE."
                AND movements_caja.caja_id = ".$cajaId."
                AND movements_caja.movement_type_id = ".ApplicationKeys::MOVEMENT_TYPE_ENTRADA."
                AND movements_caja.sale_id = sales.id
                AND sales.client_id = clients.id
                AND clients.personal_data_id = personal_data.id
                AND sales.user_id = users.id
                AND users.personal_data_id = pdu.id
                ORDER BY sales.id DESC");
    }

    public function findTotalSalesInCaja($cajaId) {
        return DB::selectOne('SELECT count(sales.id) AS numsales
                FROM movements_caja,sales
                WHERE movements_caja.status_id = '.StatusKeys::STATUS_ACTIVE.'
                AND movements_caja.caja_id = '.$cajaId.'
                AND movements_caja.movement_type_id = '.ApplicationKeys::MOVEMENT_TYPE_ENTRADA.'
                AND movements_caja.sale_id = sales.id');
    }

    public function findTotalAmountInCaja($cajaId) {
        return DB::selectOne('SELECT sum(sales.total) AS total
      FROM movements_caja,sales
      WHERE movements_caja.status_id = '.StatusKeys::STATUS_ACTIVE.'
      AND movements_caja.caja_id = '.$cajaId.'
      AND movements_caja.movement_type_id = '.ApplicationKeys::MOVEMENT_TYPE_ENTRADA.'
      AND movements_caja.sale_id = sales.id');
    }

    public function findTotalAmountCancelledSales($cajaId) {
        return DB::selectOne('SELECT sum(sales.total) AS total
      FROM movements_caja,sales
      WHERE movements_caja.status_id = '.StatusKeys::STATUS_ACTIVE.'
      AND movements_caja.caja_id = '.$cajaId.'
      AND movements_caja.movement_type_id = '.ApplicationKeys::MOVEMENT_TYPE_SALIDA.'
      AND movements_caja.sale_id = sales.id AND sales.status_id = '.StatusKeys::STATUS_CANCELLED);
    }

    public function findSalesByDeparmentAndCaja($cajaId) {
        return DB::select('SELECT deparments.description,sum(sale_details.quantity * sale_details.product_price) AS total
          FROM sale_details
          INNER JOIN sales ON sale_details.sale_id = sales.id AND sale_details.status_id = '.StatusKeys::STATUS_ACTIVE.'
          INNER JOIN movements_caja ON sales.id = movements_caja.sale_id AND movement_type_id != '.ApplicationKeys::MOVEMENT_TYPE_SALIDA.'
          INNER JOIN products ON sale_details.product_id = products.id
          INNER JOIN deparments ON products.deparment_id = deparments.id
          WHERE movements_caja.caja_id = '.$cajaId.'
          GROUP BY deparments.description,deparments.id
          ORDER BY deparments.description');
    }

    public function findSalesByDates($startDate, $endDate) {
        return DB::select("SELECT sales.*,DATE_FORMAT(sales.created_at, '".ApplicationKeys::PATTERN_FORMAT_DATE_WITH_HOUR."') AS created_at,personal_data.name AS client_name,personal_data.last_name AS client_last_name,
          pdu.name AS name_user,pdu.last_name AS last_name_user
          FROM sales,clients,personal_data,users,personal_data AS pdu
          WHERE sales.client_id = clients.id
          AND date(sales.created_at) BETWEEN '".$startDate."' AND '".$endDate."'
          AND clients.personal_data_id = personal_data.id
          AND sales.user_id = users.id
          AND users.personal_data_id = pdu.id
          ORDER BY sales.id DESC");
    }

    public function findSalesByDatesAndUser($startDate, $endDate, $userId) {
        return DB::select("SELECT sales.*,DATE_FORMAT(sales.created_at, '".ApplicationKeys::PATTERN_FORMAT_DATE_WITH_HOUR."') AS created_at,personal_data.name AS client_name,personal_data.last_name AS client_last_name,
          pdu.name AS name_user,pdu.last_name AS last_name_user
          FROM sales,clients,personal_data,users,personal_data AS pdu
          WHERE sales.client_id = clients.id
          AND date(sales.created_at) BETWEEN '".$startDate."' AND '".$endDate."'
          AND sales.user_id = ".$userId."
          AND clients.personal_data_id = personal_data.id
          AND sales.user_id = users.id
          AND users.personal_data_id = pdu.id
          ORDER BY sales.id DESC");
    }

    public function findReasonWithDrawal() {
        return DB::select('SELECT * FROM reason_withdrawal_caja WHERE id NOT IN ('.ApplicationKeys::REASON_WITHDRAWAL_SALE_CANCELLATION.');');
    }

    public function findEfectivoByCaja($cajaId) {
        return DB::selectOne('SELECT sum(sale_payment_methods.amount) AS efectivo
        FROM sales
        INNER JOIN movements_caja ON sales.id = movements_caja.sale_id
        INNER JOIN caja ON movements_caja.caja_id = caja.id
        LEFT JOIN sale_payment_methods ON sales.id = sale_payment_methods.sale_id
        LEFT JOIN payment_methods ON sale_payment_methods.payment_method_id = payment_methods.id
        WHERE caja.id = '.$cajaId.'
        AND sales.status_id = '.StatusKeys::STATUS_ACTIVE.'
        AND payment_methods.id = '.ApplicationKeys::PAYMENT_METHOD_CASH)->efectivo;
    }

    public function findEfectivoRetiradoByCaja($cajaId) {
        return DB::selectOne('SELECT sum(movements_caja.amount) AS retirado
        FROM movements_caja
        INNER JOIN caja ON movements_caja.caja_id = caja.id
        WHERE caja.id = '.$cajaId.'
        AND movements_caja.reason_withdrawal_caja_id IN ('.ApplicationKeys::REASON_WITHDRAWAL_PAYMENT_PROVIDER.','.ApplicationKeys::REASON_WITHDRAWAL_PAYMENT_NOTE.','.ApplicationKeys::REASON_WITHDRAWAL_OTHER.')')->retirado;
    }

    public function findWithdrawalsByCaja($cajaId) {
        return DB::select("SELECT movements_caja.amount,movements_caja.reference,movements_caja.created_at,movements_caja.comments,
        reason_withdrawal_caja.description
        FROM movements_caja
        INNER JOIN reason_withdrawal_caja ON movements_caja.reason_withdrawal_caja_id = reason_withdrawal_caja.id
        WHERE movements_caja.caja_id = ".$cajaId."
        AND movements_caja.status_id = ".StatusKeys::STATUS_ACTIVE."
        AND movements_caja.movement_type_id = ".ApplicationKeys::MOVEMENT_TYPE_SALIDA."
        AND movements_caja.reason_withdrawal_caja_id IS NOT NULL");
    }
}