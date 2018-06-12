<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovementsCaja extends Model {

    protected $table = 'movements_caja';

    public $timestamps = false;

    /**
     * Get the status record associated with the movementsCaja.
     */
    public function status() {
        return $this->hasOne('App\Models\Status', 'id', 'status_id');
    }

    /**
     * Get the MovementType record associated with the movementsCaja.
     */
    public function movementType() {
        return $this->hasOne('App\Models\MovementType', 'id', 'movement_type_id');
    }

    /**
     * Get the ReasonWithdrawal record associated with the movementsCaja.
     */
    public function reasonWithdrawal() {
        return $this->hasOne('App\Models\ReasonWithdrawalCaja', 'id', 'movement_type_id');
    }

    /**
     * Get the Sale record associated with the movementsCaja.
     */
    public function sale() {
        return $this->hasOne('App\Models\Sale', 'id', 'sale_id');
    }

    /**
     * Get the Sale record associated with the movementsCaja.
     */
    public function caja() {
        return $this->hasOne('App\Models\Caja', 'id', 'caja_id');
    }


}
