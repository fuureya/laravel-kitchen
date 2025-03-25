<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Inventory as inv;

class Category extends Model
{
    protected $table = 'categories';
    protected $guarded = ['id'];

    protected $casts = [
        'insert_time' => 'datetime',
        'last_update_time' => 'datetime'
    ];

    public function inventories(): HasMany
    {
        return $this->hasMany(inv::class, 'category_id');
    }
}
