<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $table = 'sales';
    protected $guarded = ['id'];

    public function salesDetails()
    {
        return $this->hasMany(SalesDetail::class, 'sales_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Suppliers::class, 'suppliers_id');
    }
}
