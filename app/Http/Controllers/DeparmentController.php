<?php
/**
 * User: ricardo
 * Date: 12/03/18
 */

namespace App\Http\Controllers;


use App\Models\Deparment;
use App\Repository\Product\ProductInterface;
use App\Utils\Keys\common\NumberKeys;
use App\Utils\Keys\common\StatusKeys;
use Illuminate\Http\Request;

class DeparmentController extends Controller {

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

    public function deparmentList() {
        return view('/admin/deparment/deparmentList');
    }

    public function findAllDepartments() {
        $deparments = $this->product->findAllDeparments();
        return response()->json($deparments);
    }

    public function save(Request $request) {
        try {
            $deparment = new Deparment();
            $deparment->status_id = StatusKeys::STATUS_ACTIVE;
            $deparment->description = $request->input('description');
            $deparment->save();
            return response()->json(array("error" => false, "id" => $deparment->id, "message" => "El departamento se ha creado"));
        } catch (\Exception $e) {
            return response()->json(array("error" => true, "id" => NumberKeys::NUMBER_ZERO, "message" => $e->getMessage()));
        }
    }

    public function update(Request $request) {
        try {
            $deparment = Deparment::findOrFail($request->input('id'));
            $deparment->description = $request->input('description');
            $deparment->save();
            return response()->json(array("error" => false, "id" => $deparment->id, "message" => "El departamento se ha actualizado"));
        } catch (\Exception $e) {
            return response()->json(array("error" => true, "id" => NumberKeys::NUMBER_ZERO, "message" => $e->getMessage()));
        }
    }

    public function delete(Request $request) {
        try {
            $deparment = Deparment::findOrFail($request->input('id'));
            $deparment->status_id = StatusKeys::STATUS_INACTIVE;
            $deparment->save();
            return response()->json(array("error" => false, "id" => $deparment->id, "message" => "Departamento eliminado"));
        } catch (\Exception $e) {
            return response()->json(array("error" => true, "id" => NumberKeys::NUMBER_ZERO, "message" => $e->getMessage()));
        }
    }

}