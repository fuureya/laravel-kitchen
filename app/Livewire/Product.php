<?php

namespace App\Livewire;

use App\Models\Product as ModelsProduct;
use Livewire\Component;
use Livewire\WithPagination;

class Product extends Component
{
    use WithPagination;
    public $name, $price, $token;
    protected $paginationTheme = 'bootstrap';

    public function resetSubmit()
    {
        $this->reset(['name', 'price', 'token']);
    }
    public function store()
    {
        $this->validate([
            'name' => 'required',
            'price' => 'required',
        ]);
        ModelsProduct::create([
            'product_name' => $this->name,
            'price' => $this->price,
            'insert_by' => auth()->user()->name,
            'insert_date' => now(),
        ]);
        $this->dispatch('formSubmitted');
        $this->resetSubmit();
        session()->flash('success', 'Product added successfully');
    }
    public function render()
    {
        $data = ModelsProduct::paginate(10);
        return view('livewire.product', ['data' => $data]);
    }
}
