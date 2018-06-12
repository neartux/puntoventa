<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralParameters extends Model {

    protected $table = 'general_parameters';

    /**
     * Get the status record associated with the generalparameter.
     */
    public function status() {
        return $this->hasOne('App\Models\Status', 'id', 'status_id');
    }
}
