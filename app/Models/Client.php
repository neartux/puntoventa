<?php

namespace App\Models;

use App\Utils\Keys\common\NumberKeys;
use App\Utils\Keys\common\StatusKeys;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Client extends Model {

    protected $table = 'clients';

    public $timestamps = false;

    /**
     * Get the status record associated with the client.
     */
    public function status() {
        return $this->hasOne('App\Models\Status', 'id', 'status_id');
    }

    /**
     * Get the personalData record associated with the client.
     */
    public function personalData() {
        return $this->hasOne('App\Models\PersonalData', 'id', 'personal_data_id');
    }

    /**
     * Get the locationData record associated with the client.
     */
    public function locationData() {
        return $this->hasOne('App\Models\LocationData', 'id', 'location_data_id');
    }

    public function findClientById($id) {
        return Client::findOrFail($id);
    }

    public function findById($id) {

        return DB::table('clients')->select('clients.id', 'personal_data.name', 'personal_data.last_name')
            ->join('personal_data', function ($join) use ($id) {
                $join->on('clients.personal_data_id', '=', 'personal_data.id')
                    ->where('clients.id', '=', $id);
            })
            ->first();
    }

    public function existClientById($clientId) {
        $num = DB::table('clients')->where([
            ['id', '=', $clientId],
            ['status_id', '=', StatusKeys::STATUS_ACTIVE]
        ])->count();
        return $num == NumberKeys::NUMBER_ONE;
    }
}
