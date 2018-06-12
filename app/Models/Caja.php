<?php

namespace App\Models;

use App\Utils\Keys\common\StatusKeys;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model {

    protected $table = 'caja';

    public $timestamps = false;

    /**
     * Get the status record associated with the caja.
     */
    public function status() {
        return $this->hasOne('App\Models\Status', 'id', 'status_id');
    }

    /**
     * Get the user opening record associated with the caja.
     */
    public function userOpening() {
        return $this->hasOne('App\User', 'id', 'user_opening_id');
    }

    /**
     * Get the user close record associated with the caja.
     */
    public function userClose() {
        return $this->hasOne('App\User', 'id', 'user_close_id');
    }

    public function findCajaOpen() {
        return static::where('status_id', StatusKeys::STATUS_OPEN)->first();
    }
}
