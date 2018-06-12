<?php
/**
 * User: ricardo
 * Date: 28/04/18
 * Time: 08:22 AM
 */

namespace App\Http\Controllers;


use App\Repository\order\OrderInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller {

    private $order;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(OrderInterface $order) {
        $this->middleware('auth');
        $this->order = $order;
    }

    public function display() {
        return view('/admin/order/orderList');
    }

    public function findOrdersByDate(Request $request) {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        return response()->json($this->order->findOrdersByDate($startDate, $endDate));
    }

    public function findOrderDetailsByOrderId($orderId){
        return response()->json($this->order->findOrderDetailsByOrderId($orderId));
    }

    public function addProductToOrder($productId) {
        try{
            $this->order->addProductToOrder($productId, Auth::user()->id);
            return response()->json(array("error" => false, "message" => "Se ha agregado el producto al pedido"));
        } catch (\Exception $e) {
            return response()->json(array("error" => true, "message" => $e->getMessage()));
        }
    }

    public function updateQuantityProduct(Request $request) {
        $id = $request->input('orderDetailId');
        $quantity = $request->input('quantity');
        try{
            $this->order->updateQuantityProduct($id, $quantity);
            return response()->json(array("error" => false, "message" => "Se ha actualizado la cantidad"));
        } catch (\Exception $e) {
            return response()->json(array("error" => true, "message" => $e->getMessage()));
        }
    }

    public function closeOrder($id) {
        try{
            $this->order->closeOrder($id);
            return response()->json(array("error" => false, "message" => "Pedido cerrado"));
        } catch (\Exception $e) {
            return response()->json(array("error" => true, "message" => $e->getMessage()));
        }
    }

}