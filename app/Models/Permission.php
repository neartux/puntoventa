<?php

/**
 * User: ricardo
 * Date: 21/02/18
 */
namespace App;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'display_name', 'description',
    ];
}