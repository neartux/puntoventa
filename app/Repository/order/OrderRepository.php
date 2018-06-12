<?php
/**
 * User: ricardo
 * Date: 28/04/18
 * Time: 07:40 AM
 */

namespace App\Repository\order;


use App\Models\Order;
use App\Models\OrderDetail;
use App\Utils\Keys\common\ApplicationKeys;
use App\Utils\Keys\common\NumberKeys;
use App\Utils\Keys\common\StatusKeys;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderInterface {

    private $order;
    private $orderDetail;

    function __construct(Order $order, OrderDetail $orderDetail) {
        $this->order = $order;
        $this->orderDetail = $orderDetail;
    }

    public function addProductToOrder($idProduct, $userId) {
        $id = $this->findOrderIdOpenOrder();
        $order = new Order();
        // Si existe orden abierta la busca por el id
        if($id > NumberKeys::NUMBER_ZERO) {
            $order = $this->order->findById($id);
        }
        // si no existe la crea agregando la informacin necesaria
        else {
            $order->created_at = Carbon::now();
            $order->status_id = StatusKeys::STATUS_OPEN;
            $order->user_id = $userId;
            $order->save();
        }
        // Crea o modifica el detalle de producto en la orden
        $this->createOrderDetail($order->id, $idProduct);

    }

    public function closeOrder($orderId) {
        $order = $this->order->findById($orderId);
        if(! $order) {
            throw new \Exception("No se encontro pedido a cerrar");
        }
        $order->status_id = StatusKeys::STATUS_CLOSED;
        $order->save();
    }

    public function updateQuantityProduct($orderDetailId, $quantity) {
        $orderDetail = $this->orderDetail->findById($orderDetailId);
        if( ! $orderDetail) {
            throw new \Exception("No se encontro el producto");
        }
        $orderDetail->quantity = floatval($quantity);
        $orderDetail->save();
    }

    private function createOrderDetail($orderId, $productId) {
        $orderDetailId = $this->findIdOrderDetailByProductAndOrder($orderId, $productId);
        // Si el detalle del producto existe solo aumenta la cantidad
        if($orderDetailId > NumberKeys::NUMBER_ZERO) {
            $orderDetail = $this->orderDetail->findById($orderDetailId);
            $orderDetail->quantity = floatval($orderDetail->quantity) + NumberKeys::NUMBER_ONE;
            $orderDetail->save();
        }
        // Crea el detalle con el producto si no existe
        else {
            $orderDetail = new OrderDetail();
            $orderDetail->status_id = StatusKeys::STATUS_ACTIVE;
            $orderDetail->order_id = $orderId;
            $orderDetail->product_id = $productId;
            $orderDetail->quantity = NumberKeys::NUMBER_ONE;
            $orderDetail->save();
        }
    }

    private function findIdOrderDetailByProductAndOrder($orderId, $productId) {
        $result =  DB::selectOne("SELECT id FROM order_detail WHERE order_id = ".$orderId." AND product_id = ".$productId." AND status_id = ".StatusKeys::STATUS_ACTIVE);
        return is_null($result) ? NumberKeys::NUMBER_ZERO : $result->id;
    }

    private function findOrderIdOpenOrder() {
        $result =  DB::selectOne("SELECT id FROM `order` WHERE status_id = ".StatusKeys::STATUS_OPEN);
        return is_null($result) ? NumberKeys::NUMBER_ZERO : $result->id;
    }

    public function findOrdersByDate($startDate, $endDate) {
        return DB::select("SELECT `order`.id, DATE_FORMAT(`order`.created_at, '".ApplicationKeys::PATTERN_FORMAT_DATE."') AS created_at,`order`.status_id,users.user_name
        FROM `order`
        INNER JOIN users ON `order`.user_id = users.id
        WHERE DATE(`order`.created_at) BETWEEN '".$startDate."' AND '".$endDate."'
        ORDER BY `order`.created_at DESC");
    }

    public function findOrderDetailsByOrderId($orderId) {
        return DB::select("SELECT order_detail.id,order_detail.quantity,products.code,products.description,products.current_stock,products.sale_price,products.purchase_price
        FROM order_detail
        INNER JOIN products ON order_detail.product_id = products.id
        WHERE order_detail.order_id = ".$orderId."
        AND order_detail.status_id = ".StatusKeys::STATUS_ACTIVE);
    }

}