<?php
/**
 * User: ricardo
 * Date: 24/10/18
 * Time: 10:09 PM
 */

namespace App\Http\Controllers;


use App\Repository\provider\ProviderInterface;
use Illuminate\Http\Request;

class ProviderController extends Controller{

    private $provider;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProviderInterface $provider) {
        $this->middleware('auth');
        $this->provider = $provider;
    }

    public function providerList() {
        return view('/admin/provider/providerlist');
    }

    public function findAllProviders() {
        return response()->json($this->provider->findAllProviders());
    }

    public function createProvider(Request $request) {
        try {
            $id = $this->provider->createProvider($request->all());
            return response()->json(array("error" => false, "message" => "se ha creado el proveedor correctamente", "id" => $id));
        } catch (\Exception $e) {
            return response()->json(array("error" => true, "message" => $e->getMessage()));
        }
    }

    public function updateProvider(Request $request) {
        try {

            $this->provider->updateProvider($request->all());
            return response()->json(array("error" => false, "message" => "se ha actualizado el proveedor correctamente"));
        } catch (\Exception $e) {
            return response()->json(array("error" => true, "message" => $e->getMessage()));
        }
    }

    public function deleteProvider($id) {
        try {

            $this->provider->deleteProvider($id);
            return response()->json(array("error" => false, "message" => "se ha eliminado al proveedor"));
        } catch (\Exception $e) {
            return response()->json(array("error" => true, "message" => $e->getMessage()));
        }
    }
}