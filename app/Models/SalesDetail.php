<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesDetail extends Model
{
    protected $table = 'sales_details';
    protected $guarded = ['id'];

    public function sale()
    {
        return $this->belongsTo(Sales::class, 'sales_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'sales_product_id');
    }
}
