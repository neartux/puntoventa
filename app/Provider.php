<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Provider extends Model {
    protected $table = 'providers';

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

    public function findProviderById($id) {
        return Provider::findOrFail($id);
    }

    public function findById($id) {

        return DB::table('providers')->select('providers.id', 'personal_data.name', 'personal_data.last_name')
            ->join('personal_data', function ($join) use ($id) {
                $join->on('providers.personal_data_id', '=', 'personal_data.id')
                    ->where('providers.id', '=', $id);
            })
            ->first();
    }
}
