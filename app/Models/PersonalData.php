<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalData extends Model {

    protected $table = 'personal_data';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_name',
    ];
}
