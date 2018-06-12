<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model {

    protected $table = 'promotions';

    public $timestamps = false;

    /**
     * Get the status record associated with the promotion.
     */
    public function status() {
        return $this->hasOne('App\Models\Status', 'id', 'status_id');
    }
}
