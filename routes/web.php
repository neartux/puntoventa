<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::group(['prefix' => 'admin',  'middleware' => 'auth'], function()  {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/deparment/list', 'DeparmentController@deparmentList')->name('admin_deparment_list');

    Route::get('/deparment/findAllDepartments', 'DeparmentController@findAllDepartments');

    Route::post('/deparment/save', 'DeparmentController@save');

    Route::post('/deparment/update', 'DeparmentController@update');

    Route::post('/deparment/delete', 'DeparmentController@delete');

    Route::get('/pointsale/view', 'PointSaleController@display')->name('point_sale_view');

    Route::get('/pointsale/findCajaOpened', 'PointSaleController@findCajaOpened');

    Route::post('/pointsale/openingCaja', 'PointSaleController@openingCaja');

    Route::get('/pointsale/findProductByCode/{code}', 'PointSaleController@findProductByCode');

    Route::get('/pointsale/findClientById/{clientId}', 'PointSaleController@findClientById');

    Route::post('/pointsale/createSale', 'PointSaleController@createSale');

    Route::get('/pointsale/findProductsByCodeOrName', 'PointSaleController@findProductsByCodeOrName');

    Route::get('/pointsale/findClientByNameOrLastName', 'PointSaleController@findClientByNameOrLastName');

    Route::post('/pointsale/cancelSale', 'PointSaleController@cancelSale');

    Route::get('/pointsale/findPreviewCloseCaja', 'PointSaleController@findPreviewCloseCaja');

    Route::get('/pointsale/findReasonWithdrawal', 'PointSaleController@findReasonWithdrawal');

    Route::get('/pointsale/findPreviewWithdrawalCaja', 'PointSaleController@findPreviewWithdrawal');

    Route::post('/pointsale/closeCaja', 'PointSaleController@closeCaja');

    Route::post('/pointsale/applyWithdrawal', 'PointSaleController@applyWithdrawal');

    Route::get('/reportsales/findCajaOpened', 'ReportsController@findCajaOpened')->name('sales_caja_opened');

    Route::get('/reportsales/findSalesCajaOpened', 'ReportsController@findSalesCajaOpened');

    Route::get('/reportsales/findDetailsBySale/{saleId}', 'ReportsController@findDetailsBySale');

    Route::get('/reportsales/cajasByDate', 'ReportsController@cajasByDate')->name('cajas_closed');

    Route::post('/reportsales/findCajasByDate', 'ReportsController@findCajasByDate');

    Route::get('/reportsales/findSalesByCaja/{cajaId}', 'ReportsController@findSalesByCaja');

    Route::get('/reportsales/displaySalesByDates', 'ReportsController@displaySalesByDates')->name('sales_by_dates');

    Route::post('/reportsales/findSalesByDates', 'ReportsController@findSalesByDates');

    Route::get('/reportsales/displaySalesByDatesAndUser', 'ReportsController@displaySalesByDatesAndUser')->name('sales_by_dates_and_user');

    Route::get('/reportsales/findAllUsers', 'ReportsController@findAllUsers');

    Route::post('/reportsales/findSalesByDatesAndUser', 'ReportsController@findSalesByDatesAndUser');

    Route::get('/configuration/configurationticket', 'ConfigurationController@configurationTicket')->name('configuration_ticket');

    Route::get('/configuration/findStore', 'ConfigurationController@findStore');

    Route::get('/configuration/findPrintingTicketById/{formatId}', 'ConfigurationController@findPrintingTicketById');

    Route::post('/configuration/saveConfiguration', 'ConfigurationController@saveConfiguration');

    Route::get('/configuration/viewChangePassword', 'ConfigurationController@viewChangePassword')->name('change_password');

    Route::post('/configuration/changePassword', 'ConfigurationController@changePassword');

    Route::get('/product/list','ProductController@productList')->name('admin_product_list');

    Route::get('/product/findAllProducts','ProductController@findAllProduct');

    Route::get('/product/findInversionStock','ProductController@findInversionStock');

    Route::get('/product/findAllUnit','ProductController@findAllUnit');

    Route::get('/product/findAllDeparment','ProductController@findAllDeparment');
    
    Route::get('/product/findAllAjusmentReasons','ProductController@findAllAjusmentReasons');

    Route::get('/product/existProductByCode/{id}/{code}', 'ProductController@existProductByCode');

    Route::post('/product/save','ProductController@save');

    Route::post('/product/update','ProductController@update');

    Route::post('/product/delete','ProductController@delete');

    Route::post('/product/updateStockProduct','ProductController@updateStockProduct');

    Route::post('/product/updateStock','ProductController@returnProductToStock');

    Route::get('/stock/list', 'ProductController@stockList')->name('admin_stock_list');

    Route::post('/stock/findAllProductStock', 'ProductController@findAllProductStock');

    Route::get('/configuration/downloadBackupDataBase', 'ConfigurationController@downloadBackupDataBase')->name('download_bakcup_database');

    Route::get('/order/addProductToOrder/{productId}', 'OrderController@addProductToOrder');

    Route::get('/order/orderList', 'OrderController@display')->name('order_list_view');

    Route::post('/order/findOrdersByDate', 'OrderController@findOrdersByDate');

    Route::get('/order/findOrderDetailsByOrderId/{orderId}', 'OrderController@findOrderDetailsByOrderId');

    Route::post('/order/updateQuantityProduct', 'OrderController@updateQuantityProduct');

    Route::get('/order/closeOrder/{id}', 'OrderController@closeOrder');

    Route::get('/client/list', 'ClientController@clientList')->name('admin_client_list');

    Route::get('/client/findAllClients', 'ClientController@findAllClients');

    Route::post('/client/createClient', 'ClientController@createClient');

    Route::post('/client/updateClient', 'ClientController@updateClient');

    Route::get('/client/delete/{id}', 'ClientController@deleteClient');

});
