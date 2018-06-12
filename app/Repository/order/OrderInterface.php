<?php
/**
 * User: ricardo
 * Date: 28/04/18
 * Time: 07:40 AM
 */

namespace App\Repository\order;


interface OrderInterface {

    public function addProductToOrder($idProduct, $userId);

    public function closeOrder($orderId);

    public function findOrdersByDate($startDate, $endDate);

    public function findOrderDetailsByOrderId($orderId);

    public function updateQuantityProduct($orderDetailId, $quantity);
}