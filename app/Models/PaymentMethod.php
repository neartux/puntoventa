<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model {

    protected $table = 'payment_methods';

    public $timestamps = false;

    /**
     * Get the status record associated with the reason_withdrawal_caja.
     */
    public function status() {
        return $this->hasOne('App\Models\Status', 'id', 'status_id');
    }

    /**
     * The sales that belong to the paymentmethod.
     */
    public function sales() {
        return $this->belongsToMany('App\Models\Sale');
    }

}
