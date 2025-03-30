<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceivingDetail extends Model
{
    protected $table = 'receiving_detail';
    protected $guarded = ['id'];

    public function receiving()
    {
        return $this->belongsTo(Receiving::class, 'receiving_id');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function uom()
    {
        return $this->belongsTo(Uoms::class, 'uom_code');
    }

    public function receivingDetails()
    {
        return $this->hasMany(ReceivingDetail::class, 'inventory_id');
    }
}
