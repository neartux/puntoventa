<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {

    protected $table = 'order';

    public $timestamps = false;

    /**
     * Get the status record associated with the order.
     */
    public function status() {
        return $this->hasOne('App\Models\Status', 'id', 'status_id');
    }

    /**
     * Get the user record associated with the order.
     */
    public function user() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    /**
     * Get the details for the order.
     */
    public function orderDetails() {
        return $this->hasMany('App\Models\OrderDetail');
    }

    public function findById($orderId) {
        return Order::findOrFail($orderId);
    }
}
