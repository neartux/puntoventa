<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model {

    protected $table = 'store';

    public $timestamps = false;

    /**
     * Get the status record associated with the store.
     */
    public function status() {
        return $this->hasOne('App\Models\Status', 'id', 'status_id');
    }

    /**
     * Get the personalData record associated with the store.
     */
    public function personalData() {
        return $this->hasOne('App\Models\PersonalData', 'id', 'personal_data_id');
    }

    /**
     * Get the locationData record associated with the store.
     */
    public function locationData() {
        return $this->hasOne('App\Models\LocationData', 'id', 'location_data_id');
    }
}
