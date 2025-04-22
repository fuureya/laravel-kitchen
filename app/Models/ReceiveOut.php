<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceiveOut extends Model
{
    protected $table = 'receiving_out';
    protected $guarded = ['id'];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }
}
