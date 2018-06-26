<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdjustmentReason extends Model {

    protected $table = 'adjustment_reasons';

    public $timestamps = false;

    /**
     * Get the status record associated with the adjustmentReason.
     */
    public function status() {
        return $this->hasOne('App\Models\Status', 'id', 'status_id');
    }

    public function findById($id) {
        return AdjustmentReason::findOrFail($id);
    }
}
