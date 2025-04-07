<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Suppliers;
use Livewire\Component;

class Sales extends Component
{
    public function render()
    {
        $suppliers = Suppliers::select('name', 'id')->get();
        $products = Product::select('product_name', 'id')->get();
        return view('livewire.sales', ["suppliers" => $suppliers, "products" => $products]);
    }
}
