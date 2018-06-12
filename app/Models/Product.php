<?php

namespace App\Models;

use App\Utils\Keys\common\StatusKeys;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model {

    protected $table = 'products';

    public $timestamps = false;

    /**
     * Get the status record associated with the product.
     */
    public function status() {
        return $this->hasOne('App\Models\Status', 'id', 'status_id');
    }

    /**
     * Get the unit record associated with the product.
     */
    public function unit() {
        return $this->hasOne('App\Models\Unity', 'id', 'unit_id');
    }

    /**
     * Get the deparment record associated with the product.
     */
    public function deparment() {
        return $this->hasOne('App\Models\Deparment', 'id', 'deparment_id');
    }

    public function findById($productId) {
        return Product::findOrFail($productId);
    }

    public function findAll(){
        return DB::select('SELECT * FROM products WHERE status_id = ?',[StatusKeys::STATUS_ACTIVE]);
    }
}
