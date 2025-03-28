<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    protected $table = 'users';
    protected $guarded = ['id'];

    protected $casts = [
        'permissions' => 'array',
    ];
}
