<?php
/**
 * User: jerry
 * Date: 14/04/18
 */

namespace App\Http\Controllers;


use App\Models\Product;
use App\Repository\Product\ProductInterface;
use App\Utils\Keys\common\NumberKeys;
use App\Utils\Keys\common\StatusKeys;
use App\Utils\Keys\common\ApplicationKeys;
use App\Utils\product\ProductUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller {
    private $product;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProductInterface $product) {
        $this->middleware('auth');
        $this->product = $product;
    }

    public function productList() {
        return view('/admin/product/productList');
    }

    public function stockList() {
        return view('/admin/product/stockList');
    }

    public function findAllProductStock(Request $request){
        // Convierte a objeto los parametros
        $requestDT = ProductUtils::getRequestDataTable($request);
        // Obtiene los elementos
        $products = $this->product->findProducts($requestDT->getLength(), $requestDT->getStart(), $requestDT->getSearch()['value']);
        // Obtiene la longitud de la consulta
        $length = $this->product->countProducts($requestDT->getSearch()['value']);
        // Devuelve el resultado esperado por el datatable
        return response()->json(array("draw" => $requestDT->getDraw(), "recordsFiltered" => $length, "recordsTotal" => $length, "data" => $products));
    }

    public function existProductByCode($id, $code) {
        return response()->json(array("exist" => $this->product->existProductByCode($id, $code)));
    }

    public function findAllUnit(){
        $unities = $this->product->findAllUnit();
        return response()->json($unities);
    }

    public function findAllDeparment(){
        $deparments = $this->product->findAllDeparments();
        return response()->json($deparments);
    }

    public function findAllProduct(){
        $products = $this->product->findAllProducts();
        return response()->json($products);
    }

    public function findInversionStock() {
        $inversion = $this->product->findInversionStock();
        return response()->json($inversion);
    }

    public function findAllAjusmentReasons(){
        $adjusmentReasons = $this->product->findAllAjusmentReasons();
        return response()->json($adjusmentReasons);
    }

    public function save(Request $request){

        try {
            $product_ = new Product();
            $product_->status_id = StatusKeys::STATUS_ACTIVE;
            $product_->description = $request->input('description');
            $product_->code= $request->input('code');
            $product_->deparment_id = $request->input('deparment_id');
            $product_->unit_id = $request->input('unit_id');
            $product_->purchase_price = $request->input('purchase_price');
            $product_->sale_price = $request->input('sale_price');
            $product_->wholesale_price = $request->input('wholesale_price');
            $product_->sale_price = $request->input('sale_price');
            $product_->created_at = date('Y-m-d H:i:s');
            $product_->current_stock = $request->input('current_stock');
            $product_->minimum_stock = $request->input('minimum_stock');

            $product_->save();
            return response()->json(array("error" => false, "id" => $product_->id, "message" => "El producto se ha creado"));
        } catch (\Exception $e) {
            return response()->json(array("error" => true, "id" => NumberKeys::NUMBER_ZERO, "message" => $e->getMessage()));
        }
    }

    public function update(Request $request) {
        try {
            $product_ = Product::findOrFail($request->input('id'));
            $product_->description = $request->input('description');
            $product_->code= $request->input('code');
            $product_->deparment_id = $request->input('deparment_id');
            $product_->unit_id = $request->input('unit_id');
            $product_->purchase_price = $request->input('purchase_price');
            $product_->sale_price = $request->input('sale_price');
            $product_->wholesale_price = $request->input('wholesale_price');
            $product_->sale_price = $request->input('sale_price');
            $product_->current_stock = $request->input('current_stock');
            $product_->minimum_stock = $request->input('minimum_stock');

            $product_->save();
            return response()->json(array("error" => false, "id" => $product_->id, "message" => "El producto se ha actualizado"));
        } catch (\Exception $e) {
            return response()->json(array("error" => true, "id" => NumberKeys::NUMBER_ZERO, "message" => $e->getMessage()));
        }
    }

    public function delete(Request $request){
        try {
            $product = Product::findOrFail($request->input('id'));
            $product->status_id = StatusKeys::STATUS_INACTIVE;
            $product->save();
            return response()->json(array("error" => false, "id" => $product->id, "message" => "Producto eliminado"));
        } catch (\Exception $e) {
            return response()->json(array("error" => true, "id" => NumberKeys::NUMBER_ZERO, "message" => $e->getMessage()));
        }
    }

    public function updateStockProduct(Request $request) {
        try{
            $productId = $request->input('productId');
            $quantity = $request->input('quantity');
            $adjusmentReasonId = $request->input('adjusmentReasonId');
            $userId = Auth::user()->id;
            // Crea el ajuste para mantener un historial
            $this->product->createAdjustment($userId, $adjusmentReasonId, $productId, null, $quantity, 'Ajuste de stock');
            // Ajusta el stock
            $this->product->updateStockProduct($productId, $quantity, $adjusmentReasonId);

            return response()->json(array("error" => false, "id", "message" => "El stock se ha actualizado"));

        }catch(\Exception $e){
            return response()->json(array("error" => true, "message" => $e->getMessage()));
        }
    }

    public function updateStock(Request $request) {
        try {
            $product_ = Product::findOrFail($request->input('id'));
            $current_stock = $request->input('current_stock');
            if($current_stock>0){
                $product_->current_stock = $product_->current_stock + $current_stock;
            }else if($current_stock<0){
                $product_->current_stock = $product_->current_stock + $current_stock;
            }
            $product_->save();
            return response()->json(array("error" => false, "id" => $product_->id, "message" => "El stock se ha actualizado","stock"=>$product_->current_stock));
        } catch (\Exception $e) {
            return response()->json(array("error" => true, "id" => NumberKeys::NUMBER_ZERO, "message" => $e->getMessage()));
        }
    }

    public function returnProductToStock(Request $request){
        try{
            // $product_ = Product::findOrFail($request->input('id'));
            // $current_stock = $request->input('current_stock');

            $idProduct = $request->input('id');
            $current_stock = $request->input('current_stock');
            $idAdjusmentReason = $request->input('adjusmentReason')['id'];

            $changeStock = false;
            switch ((int)$idAdjusmentReason) {
                case 3:
                        $changeStock = true;
                    break;
                case 4:
                        $changeStock = false;
                    break;
                case 5:
                        $changeStock = false;
                    break;
            }
            // $product_ = new Product();
            $userId = Auth::user()->id;;
            $this->product->createAdjustment($userId, $idAdjusmentReason, $idProduct, null, $current_stock, 'Ajuste de stock');
            // Ajusta el stock
            $current_stock_ = $this->product->updateStockByIdProduct($idProduct, $current_stock, $changeStock,true);

            return response()->json(array("error" => false, "id" => $idProduct, "message" => "El stock se ha actualizado","stock"=>$current_stock_ ));

        }catch(\Exception $e){
            return response()->json(array("error" => true, "id" => NumberKeys::NUMBER_ZERO, "message" => $e->getMessage()));
        }

    }
}