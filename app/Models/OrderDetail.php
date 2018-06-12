<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model {

    protected $table = 'order_detail';

    public $timestamps = false;

    /**
     * Get the status record associated with the sale detail.
     */
    public function status() {
        return $this->hasOne('App\Models\Status', 'id', 'status_id');
    }

    /**
     * Get the sale record associated with the sale detail.
     */
    public function sale() {
        return $this->hasOne('App\Models\Order', 'id', 'order_id');
    }

    /**
     * Get the product record associated with the sale detail.
     */
    public function product() {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }

    public function findById($orderDetailId) {
        return OrderDetail::findOrFail($orderDetailId);
    }
}
