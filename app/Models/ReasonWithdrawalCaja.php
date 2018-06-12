<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReasonWithdrawalCaja extends Model {

    protected $table = 'reason_withdrawal_caja';

    public $timestamps = false;

    /**
     * Get the status record associated with the reason_withdrawal_caja.
     */
    public function status() {
        return $this->hasOne('App\Models\Status', 'id', 'status_id');
    }
}
