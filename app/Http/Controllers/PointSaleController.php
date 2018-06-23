<?php
/**
 * User: ricardo
 * Date: 17/03/18
 */

namespace App\Http\Controllers;


use App\Repository\client\ClientInterface;
use App\Repository\Product\ProductInterface;
use App\Repository\sale\SaleInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PointSaleController extends Controller {

    private $product;
    private $sale;
    private $client;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProductInterface $product, SaleInterface $sale, ClientInterface $client) {
        $this->middleware('auth');
        $this->product = $product;
        $this->sale = $sale;
        $this->client = $client;
    }

    public function display() {
        return view('/admin/pointsale/pointSale');
    }

    public function findCajaOpened() {
        return response()->json($this->sale->findCajaOpened());
    }

    public function openingCaja(Request $request) {
        try {
            $caja = $this->sale->openCaja(Auth::user()->id, $request->input('amount'), $request->input('comments'));
            return response()->json(array("error" => false, "caja" => $caja, "message" => "Se ha abierto la caja"));
        } catch (\Exception $e) {
            return response()->json(array("error" => true, "caja" => null, "message" => $e->getMessage()));
        }
    }
    
    public function findProductByCode($code) {
        return response()->json($this->product->findProductByCode($code));
    }

    public function findClientById($clientId) {
        return response()->json($this->client->findClientById($clientId));
    }

    public function findProductsByCodeOrName(Request $request) {
        return response()->json($this->product->findProductByCodeOrDescription($request->input('q')));
    }

    public function findClientByNameOrLastName(Request $request) {
        return response()->json($this->client->findClientByNameOrLastName($request->input('q')));
    }

    public function createSale(Request $request) {
        DB::beginTransaction();
        try{
            $idSale = $this->sale->createSale($request->all());
            DB::commit();
            return response()->json(array("error" => false, "saleId" => $idSale, "message" => "Se ha emitido la venta"));
        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(array("error" => true, "message" => $e->getMessage()));
        }

    }

    public function cancelSale(Request $request) {
        DB::beginTransaction();
        try{
            $this->sale->cancelSale($request->input('saleId'), Auth::user()->id);
            DB::commit();
            return response()->json(array("error" => false, "message" => "Se ha cancelado la venta con folio #".$request->input('saleId')));
        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(array("error" => true, "message" => $e->getMessage()));
        }
    }

    public function findPreviewCloseCaja() {
        try {
            // Busca la caja abierta
            $caja = $this->sale->findCajaOpened();
            // Obtiene el numero de ventas realizadas en la caja abierta
            $totalSales = $this->sale->findTotalSalesInCaja($caja->id)->numsales;
            // Obtiene el monto total de las ventas hechas en la caja
            $totalAmountSales = $this->sale->findTotalAmountInCaja($caja->id)->total;
            // Obtiene el total de las ventas canceladas
            $amountCancelledSales = $this->sale->findTotalAmountCancelledSales($caja->id)->total;
            // Obtiene las ventas por cada departamento
            $salesByDeparment = $this->sale->findSalesByDeparmentAndCaja($caja->id);
            // Envia el resultado
            $data = array("totalSales" => $totalSales, "totalAmountSales" => $totalAmountSales, "caja" => $caja,
                "salesByDeparment" => $salesByDeparment, "amountCancelledSales" => $amountCancelledSales);
            return response()->json(array("error" => false, "cajaPreview" => $data));
        } catch (\Exception $e) {
            return response()->json(array("error" => true, "message" => $e->getMessage()));
        }
    }

    public function closeCaja() {
        DB::beginTransaction();
        try{
            $this->sale->closeCaja(Auth::user()->id);
            DB::commit();
            return response()->json(array("error" => false, "message" => "Se ha cerrado la caja correctamente"));
        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(array("error" => true, "message" => $e->getMessage()));
        }
    }

}