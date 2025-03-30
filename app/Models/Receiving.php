<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receiving extends Model
{
    protected $table = 'receiving';
    protected $guarded = ['id'];

    public function supplier()
    {
        return $this->belongsTo(Suppliers::class, 'supplier_id');
    }

    public function details()
    {
        return $this->hasMany(ReceivingDetail::class, 'receiving_id');
    }
}
