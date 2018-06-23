<?php
/**
 * User: ricardo
 * Date: 12/03/18
 * Time: 07:42 PM
 */

namespace App\Repository\Product;


use App\Models\Adjustment;
use App\Models\Client;
use App\Models\Deparment;
use App\Models\Product;
use App\Utils\Keys\common\ApplicationKeys;
use App\Utils\Keys\common\StatusKeys;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductInterface {

    private $deparments;
    private $product;
    private $client;



    function __construct(Deparment $deparment, Product $product, Client $client) {
        $this->deparments = $deparment;
        $this->product = $product;
        $this->client = $client;
    }

    public function findAllDeparments() {
        return $this->deparments->findAll();
    }

    public function findProductByCode($code) {
        $product = DB::table('products')->where([
            ['status_id', '=', StatusKeys::STATUS_ACTIVE],
            ['code', '=', $code],
        ])->first();

        return $product;
    }

    public function findProductByCodeOrDescription($re) {
        return DB::select('SELECT * FROM products WHERE status_id = '.StatusKeys::STATUS_ACTIVE.' AND (code LIKE \'%'.$re.'%\' OR description LIKE \'%'.$re.'%\')');
    }

    public function updateStockByIdProduct($productId, $quantity, $isAdd,$return = FALSE) {
        $product = $this->product->findById($productId);
        // Determina si es suma o resta
        if ($isAdd) {
            $product->current_stock = $product->current_stock + $quantity;
        } else {
            $product->current_stock = $product->current_stock - $quantity;
        }

        $product->save();

        if($return===TRUE){
            return $product->current_stock;
        }
    }

    public function createAdjustment($userId, $adjustmentReasonId, $productId, $saleId, $quantity, $comments) {
        $adjustment = new Adjustment();
        $adjustment->status_id = StatusKeys::STATUS_ACTIVE;
        $adjustment->user_id = $userId;
        $adjustment->adjustment_reason_id = $adjustmentReasonId;
        $adjustment->product_id = $productId;
        $adjustment->quantity = $quantity;
        $adjustment->created_at = Carbon::now();
        $adjustment->comments = $comments;
        // Si el ajuste es por una venta, guarda el id de la venta
        if ($adjustmentReasonId == ApplicationKeys::ADJUSTMENT_REASON_BY_SALE || $adjustmentReasonId == ApplicationKeys::ADJUSTMENT_REASON_BY_SALE_CANCELLATION) {
            $adjustment->sale_id = $saleId;
        }
        $adjustment->save();
    }

    public function findAllUnit(){
        return DB::select('SELECT * FROM unities WHERE status_id = '.StatusKeys::STATUS_ACTIVE);
    }

    public function findAllProducts() {
        return $this->product->findAll();
    }

    public function findProducts($length, $start, $search){
        $sql = 'SELECT products.*,deparments.description AS department,unities.description AS unit FROM products LEFT JOIN deparments ON products.deparment_id = deparments.id LEFT JOIN unities ON products.unit_id = unities.id WHERE products.status_id = '.StatusKeys::STATUS_ACTIVE;
        if(!is_null($search) && !empty($search)) {
            $sql.=' AND(upper(products.code) LIKE upper(\'%'.$search.'%\') OR upper(products.description) LIKE upper(\'%'.$search.'%\') OR products.sale_price LIKE \'%'.$search.'%\')';
        }
        $sql .=' ORDER BY products.description LIMIT '.$length.' OFFSET '.$start;
        return DB::select($sql);
    }

    public function countProducts($search) {
        $sql = 'SELECT count(*) AS length FROM products WHERE products.status_id = '.StatusKeys::STATUS_ACTIVE;
        if(!is_null($search) && !empty($search)) {
            $sql.=' AND(upper(code) LIKE upper(\'%'.$search.'%\') OR upper(description) LIKE upper(\'%'.$search.'%\') OR sale_price LIKE \'%'.$search.'%\')';
        }
        return DB::selectOne($sql)->length;
    }

    public function findAllAjusmentReasons(){
        return DB::select('SELECT * FROM adjustment_reasons WHERE status_id = '.StatusKeys::STATUS_ACTIVE.' AND id not in (1,2)');
    }

    public function findInversionStock() {
        return DB::selectOne('SELECT sum(current_stock) as productos,sum(products.purchase_price * products.current_stock) as total FROM products WHERE current_stock > 0');
    }
}