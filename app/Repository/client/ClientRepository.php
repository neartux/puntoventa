<?php
/**
 * User: ricardo
 * Date: 28/04/18
 * Time: 11:04 AM
 */

namespace App\Repository\client;


use App\Models\Client;
use App\Models\LocationData;
use App\Models\PersonalData;
use App\Utils\Keys\common\ApplicationKeys;
use App\Utils\Keys\common\StatusKeys;
use Illuminate\Support\Facades\DB;

class ClientRepository implements ClientInterface {

    private $client;

    function __construct(Client $client) {
        $this->client = $client;
    }

    public function findAllClients() {
        return DB::select('SELECT clients.id,personal_data.name,personal_data.last_name,location_data.address,location_data.city as ciudad,
        location_data.phone,location_data.cell_phone,location_data.email
        FROM clients
        INNER JOIN location_data ON clients.location_data_id = location_data.id
        INNER JOIN personal_data ON clients.personal_data_id = personal_data.id
        WHERE clients.id != '.ApplicationKeys::CLIENT_GENERAL_PUBLIC.' 
        AND clients.status_id = '.StatusKeys::STATUS_ACTIVE);
    }

    public function createClient($clientValues) {
        $location_data = new LocationData();
        $location_data->address = $clientValues['address'];
        $location_data->city = $clientValues['ciudad'];
        $location_data->phone = $clientValues['phone'];
        $location_data->cell_phone = $clientValues['cell_phone'];
        $location_data->email = $clientValues['email'];

        $location_data->save();

        $personal_data = new PersonalData();

        $personal_data->name = $clientValues['name'];
        $personal_data->last_name = $clientValues['last_name'];

        $personal_data->save();

        $client = new Client();
        $client->status_id = StatusKeys::STATUS_ACTIVE;
        $client->personal_data_id = $personal_data->id;
        $client->location_data_id = $location_data->id;

        $client->save();

        return $client->id;
    }

    public function updateClient($clientValues) {
        $client = $this->client->findClientById($clientValues['id']);
        if (!$client) {
            throw new \Exception("El cliente no se encontro");
        }
        $client->locationData->address = $clientValues['address'];
        $client->locationData->city = $clientValues['ciudad'];
        $client->locationData->phone = $clientValues['phone'];
        $client->locationData->cell_phone = $clientValues['cell_phone'];
        $client->locationData->email = $clientValues['email'];

        $client->personalData->name = $clientValues['name'];
        $client->personalData->last_name = $clientValues['last_name'];

        $client->push();
    }

    public function deleteClient($id) {
        $client = $this->client->findClientById($id);
        if (!$client) {
            throw new \Exception("El cliente no se encontro");
        }
        $client->status_id = StatusKeys::STATUS_INACTIVE;

        $client->save();
    }

    public function findClientById($clientId) {
        return $this->client->findById($clientId);
    }

    public function findClientByNameOrLastName($re) {
        return DB::select('
        SELECT clients.id,personal_data.name,personal_data.last_name
        FROM clients
        INNER JOIN personal_data ON clients.personal_data_id = personal_data.id
        WHERE clients.status_id = '.StatusKeys::STATUS_ACTIVE.'
        AND clients.id != '.ApplicationKeys::CLIENT_GENERAL_PUBLIC.'
        AND (name LIKE \'%'.$re.'%\' OR last_name LIKE \'%'.$re.'%\')');
    }

}