<?php
/**
 * User: ricardo
 * Date: 28/04/18
 * Time: 11:07 AM
 */

namespace App\Http\Controllers;


use App\Repository\client\ClientInterface;
use Illuminate\Http\Request;

class ClientController extends Controller {

    private $client;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ClientInterface $client) {
        $this->middleware('auth');
        $this->client = $client;
    }

    public function clientList() {
        return view('/admin/client/clientlist');
    }

    public function findAllClients() {
        return response()->json($this->client->findAllClients());
    }

    public function createClient(Request $request) {
        try {
            $id = $this->client->createClient($request->all());
            return response()->json(array("error" => false, "message" => "se ha creado el cliente correctamente", "id" => $id));
        } catch (\Exception $e) {
            return response()->json(array("error" => true, "message" => $e->getMessage()));
        }
    }

    public function updateClient(Request $request) {
        try {

            $this->client->updateClient($request->all());
            return response()->json(array("error" => false, "message" => "se ha actualizado el cliente correctamente"));
        } catch (\Exception $e) {
            return response()->json(array("error" => true, "message" => $e->getMessage()));
        }
    }

    public function deleteClient($id) {
        try {

            $this->client->deleteClient($id);
            return response()->json(array("error" => false, "message" => "se ha eliminado al cliente"));
        } catch (\Exception $e) {
            return response()->json(array("error" => true, "message" => $e->getMessage()));
        }
    }

}