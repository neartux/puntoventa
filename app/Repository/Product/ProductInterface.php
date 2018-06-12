<?php

/**
 * User: ricardo
 * Date: 12/03/18
 */

namespace App\Repository\Product;


interface ProductInterface {
    
    public function findAllDeparments();

    public function findProductByCode($code);

    public function findProductByCodeOrDescription($re);

    public function findClientById($clientId);

    public function findClientByNameOrLastName($re);

    public function updateStockByIdProduct($productId, $quantity, $isAdd);

    public function createAdjustment($userId, $adjustmentReasonId, $productId, $saleId, $quantity, $comments);

    public function findAllUnit();

    public function findAllProducts();
    
    public function findAllAjusmentReasons();

    public function findInversionStock();

}