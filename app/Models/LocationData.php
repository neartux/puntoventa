<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationData extends Model {

    protected $table = 'location_data';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address', 'postal_code', 'city', 'phone', 'cell_phone', 'email',
    ];
}
