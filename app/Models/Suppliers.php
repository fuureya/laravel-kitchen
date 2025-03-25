<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    use HasFactory;

    protected $table = 'suppliers';
    protected $fillable = [
        'name',
        'pic',
        'phone',
        'street',
        'city',
        'country',
        'email',
        'ap_limit',
        'insert_by',
        'insert_date',
        'last_update_by',
        'last_update_time'
    ];

    protected $casts = [
        'ap_limit' => 'decimal:2',
        'insert_date' => 'datetime',
        'last_update_time' => 'datetime'
    ];
}
