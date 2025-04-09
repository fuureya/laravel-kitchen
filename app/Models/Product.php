<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $guarded = ['id'];
    public function salesDetails()
    {
        return $this->hasMany(SalesDetail::class, 'sales_product_id');
    }
}
