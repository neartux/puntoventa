<?php
/**
 * User: ricardo
 * Date: 22/03/18
 */

namespace App\Http\Controllers;


use App\Repository\sale\SaleInterface;
use App\Repository\user\UserInterface;
use Illuminate\Http\Request;

class ReportsController extends Controller {

    private $sale;
    private $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SaleInterface $sale, UserInterface $user) {
        $this->middleware('auth');
        $this->sale = $sale;
        $this->user = $user;
    }

    public function findCajaOpened() {
        return view('admin.pointsale.reports.salesOpenedCaja');
    }

    public function findSalesCajaOpened() {
        return response()->json($this->sale->findSalesCajaOpened());
    }

    public function findDetailsBySale($saleId) {
        return response()->json($this->sale->findDetailsByIdSale($saleId));
    }

    public function cajasByDate() {
        return view('admin.pointsale.reports.cajasByDate');
    }

    public function findCajasByDate(Request $request) {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        return response()->json($this->sale->findCajasByDate($startDate, $endDate));
    }

    public function findSalesByCaja($cajaId) {
        return response()->json($this->sale->findSalesByCaja($cajaId));
    }

    public function displaySalesByDates() {
        return view('admin.pointsale.reports.salesByDates');
    }

    public function findSalesByDates(Request $request) {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        return response()->json($this->sale->findSalesByDates($startDate, $endDate));
    }

    public function displaySalesByDatesAndUser() {
        return view('admin.pointsale.reports.salesByDatesAndUser');
    }

    public function findAllUsers() {
        return response()->json($this->user->findAllUsers());
    }

    public function findSalesByDatesAndUser(Request $request) {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $userId = $request->input('userId');
        return response()->json($this->sale->findSalesByDatesAndUser($startDate, $endDate, $userId));
    }

}