<?php

namespace App\Models;

use App\Utils\Keys\common\StatusKeys;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Deparment extends Model {

    protected $table = 'deparments';

    protected $fillable = [
        'status_id', 'description'
    ];

    public $timestamps = false;

    /**
     * Get the status record associated with the department.
     */
    public function status() {
        return $this->hasOne('App\Models\Status', 'id', 'status_id');
    }

    public function findAll() {
        return DB::select('select * from deparments where status_id = ?', [StatusKeys::STATUS_ACTIVE]);
    }
}
