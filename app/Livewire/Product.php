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

    public function closeModal()
    {
        $this->resetSubmit();
    }

    public function edit($id)
    {
        $data = ModelsProduct::find($id);
        $this->name = $data->product_name;
        $this->price = $data->price;
        $this->token = $id;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'price' => 'required',
        ]);
        ModelsProduct::where('id', $this->token)->update([
            'product_name' => $this->name,
            'price' => $this->price,
            'last_update_by' => auth()->user()->name,
            'last_update_time' => now(),
        ]);
        $this->dispatch('editSubmitted');
        $this->resetSubmit();
        session()->flash('message', 'Product updated successfully');
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
        session()->flash('message', 'Product added successfully');
    }

    public function delete($id)
    {
        $data = ModelsProduct::find($id);
        $data->delete();
        session()->flash('message', 'Product deleted successfully');
    }
    public function render()
    {
        $data = ModelsProduct::paginate(10);
        return view('livewire.product', ['data' => $data]);
    }
}
