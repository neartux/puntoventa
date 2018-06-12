<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unity extends Model {

    /**
     * Get the status record associated with the unity.
     */
    public function status() {
        return $this->hasOne('App\Models\Status', 'id', 'status_id');
    }
}
