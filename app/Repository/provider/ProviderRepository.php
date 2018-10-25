<?php
/**
 * User: ricardo
 * Date: 24/10/18
 * Time: 09:59 PM
 */

namespace App\Repository\provider;


use App\Models\LocationData;
use App\Models\PersonalData;
use App\Provider;
use App\Utils\Keys\common\StatusKeys;
use Illuminate\Support\Facades\DB;

class ProviderRepository implements ProviderInterface {
    private $provider;

    function __construct(Provider $provider) {
        $this->provider = $provider;
    }

    public function findAllProviders() {
        return DB::select('SELECT providers.id,personal_data.name,personal_data.last_name,personal_data.company_name,location_data.address,location_data.city as ciudad,
        location_data.phone,location_data.cell_phone,location_data.email
        FROM providers
        INNER JOIN location_data ON providers.location_data_id = location_data.id
        INNER JOIN personal_data ON providers.personal_data_id = personal_data.id
        WHERE providers.status_id = '.StatusKeys::STATUS_ACTIVE);
    }

    public function createProvider($providerValues) {
        $location_data = new LocationData();
        $location_data->address = $providerValues['address'];
        $location_data->city = $providerValues['ciudad'];
        $location_data->phone = $providerValues['phone'];
        $location_data->cell_phone = $providerValues['cell_phone'];
        $location_data->email = $providerValues['email'];

        $location_data->save();

        $personal_data = new PersonalData();

        $personal_data->company_name = $providerValues['company_name'];
        $personal_data->name = $providerValues['name'];
        $personal_data->last_name = $providerValues['last_name'];

        $personal_data->save();

        $provider = new Provider();
        $provider->status_id = StatusKeys::STATUS_ACTIVE;
        $provider->personal_data_id = $personal_data->id;
        $provider->location_data_id = $location_data->id;

        $provider->save();

        return $provider->id;
    }

    public function updateProvider($providerValues) {
        $provider = $this->provider->findProviderById($providerValues['id']);
        if (!$provider) {
            throw new \Exception("El proveedor no se encontro");
        }
        $provider->locationData->address = $providerValues['address'];
        $provider->locationData->city = $providerValues['ciudad'];
        $provider->locationData->phone = $providerValues['phone'];
        $provider->locationData->cell_phone = $providerValues['cell_phone'];
        $provider->locationData->email = $providerValues['email'];

        $provider->personalData->company_name = $providerValues['company_name'];
        $provider->personalData->name = $providerValues['name'];
        $provider->personalData->last_name = $providerValues['last_name'];

        $provider->push();
    }

    public function deleteProvider($id) {
        $provider = $this->provider->findProviderById($id);
        if (!$provider) {
            throw new \Exception("El Proveedor no se encontro");
        }
        $provider->status_id = StatusKeys::STATUS_INACTIVE;

        $provider->save();
    }

    public function findProviderById($providerId) {
        return $this->provider->findById($providerId);
    }
}