<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Uoms extends Model
{
    protected $table = 'uoms';
    protected $guarded = ['id'];

    protected $casts = [
        'insert_time' => 'datetime',
        'last_update_time' => 'datetime'
    ];

    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class, 'uom_code');
    }
}
