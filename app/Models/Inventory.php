<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Uoms;

class Inventory extends Model
{
    protected $table = 'barang_inventory';
    protected $guarded = ['id'];

    protected $casts = [
        'price' => 'decimal:2',
        'insert_date' => 'datetime',
        'last_update_time' => 'datetime'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function uom(): BelongsTo
    {
        return $this->belongsTo(Uoms::class, 'uom_code');
    }
}
