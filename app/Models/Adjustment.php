<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adjustment extends Model {

    protected $table = 'adjustments';

    public $timestamps = false;

    /**
     * Get the status record associated with the adjustment.
     */
    public function status() {
        return $this->hasOne('App\Models\Status', 'id', 'status_id');
    }

    /**
     * Get the user record associated with the adjustment.
     */
    public function user() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    /**
     * Get the adjustmentReason record associated with the adjustment.
     */
    public function adjustmentReason() {
        return $this->hasOne('App\Models\AdjustmentReason', 'id', 'adjustment_reason_id');
    }

    /**
     * Get the product record associated with the adjustment.
     */
    public function product() {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }

    /**
     * Get the sale record associated with the adjustment.
     */
    public function sale() {
        return $this->hasOne('App\Models\Sale', 'id', 'sale_id');
    }
}
