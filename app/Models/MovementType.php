<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovementType extends Model {

    protected $table = 'movement_types';

    public $timestamps = false;

    /**
     * Get the status record associated with the movementsCaja.
     */
    public function status() {
        return $this->hasOne('App\Models\Status', 'id', 'status_id');
    }
}
