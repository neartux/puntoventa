<?php
/**
 * User: ricardo
 * Date: 17/03/18
 */

namespace App\Utils\product;


use App\To\datatable\RequestDataTable;
use Illuminate\Http\Request;

final class ProductUtils {

    public static function getRequestDataTable(Request $request) {
        $requestDT = new RequestDataTable();
        $requestDT->setDraw($request->get('draw'));
        $requestDT->setLength($request->get('length'));
        $requestDT->setStart($request->get('start'));
        $requestDT->setSearch($request->get('search'));
        return $requestDT;
    }

}