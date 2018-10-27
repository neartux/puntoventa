<?php
/**
 * User: ricardo
 * Date: 19/03/18
 */

namespace App\Repository\sale;


interface SaleInterface {

    public function findCajaOpened();

    public function openCaja($userId, $amount, $comments);

    public function closeCaja($userId);

    public function createSale($arraySale);

    public function findSalesCajaOpened();

    public function findDetailsByIdSale($saleId);

    public function cancelSale($saleId, $userId);

    public function applyWithdrawal($reasonId, $amount, $reference, $comments);

    public function findCajasByDate($startDate, $endDate);

    public function findSalesByCaja($cajaId);

    public function findTotalSalesInCaja($cajaId);

    public function findTotalAmountInCaja($cajaId);

    public function findSalesByDeparmentAndCaja($cajaId);

    public function findTotalAmountCancelledSales($cajaId);

    public function findSalesByDates($startDate, $endDate);

    public function findSalesByDatesAndUser($startDate, $endDate, $userId);

    public function findReasonWithDrawal();

    public function findEfectivoByCaja($cajaId);

    public function findEfectivoRetiradoByCaja($cajaId);

    public function findWithdrawalsByCaja($cajaId);
}