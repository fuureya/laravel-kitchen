<?php

namespace App\Livewire;

use App\Models\Inventory as InvModel;
use App\Models\Category as CategoryModel;
use App\Models\Uoms as UomsModel;
use Livewire\Component;
use Livewire\WithPagination;

class Inventory extends Component
{
    use WithPagination;

    public $name, $category_id, $uom_code, $price, $stock_minimum, $insert_by;
    public $insert_date, $status = 'active', $last_update_by, $last_update_time, $inventory_id;
    public $isModalOpen = false;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.inventory', [
            'inventories' => InvModel::with(['category', 'uom'])
                ->orderBy('id', 'desc')
                ->paginate(4),
            'categories' => CategoryModel::all(),
            'uoms' => UomsModel::all()
        ]);
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->resetInputFields();
        $this->isModalOpen = false;
    }

    private function resetInputFields()
    {
        $this->reset([
            'name',
            'category_id',
            'uom_code',
            'price',
            'stock_minimum',
            'insert_by',
            'insert_date',
            'status',
            'last_update_by',
            'last_update_time',
            'inventory_id'
        ]);
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'uom_code' => 'required|exists:uoms,id',
            'price' => 'required|numeric|min:0',
            'stock_minimum' => 'required|integer|min:0',
            'insert_by' => 'required',
            'insert_date' => 'required|date',
            'status' => 'required|in:active,nonactive'
        ]);

        InvModel::create([
            'name' => $this->name,
            'category_id' => $this->category_id,
            'uom_code' => $this->uom_code,
            'price' => $this->price,
            'stock_minimum' => $this->stock_minimum,
            'insert_by' => $this->insert_by,
            'insert_date' => $this->insert_date,
            'status' => $this->status,
            'last_update_by' => $this->last_update_by,
            'last_update_time' => $this->last_update_time
        ]);

        $this->dispatch('formSubmitted');
        $this->resetInputFields();
        session()->flash('message', 'Inventory item added successfully.');
    }

    public function edit($id)
    {
        $inventory = InvModel::findOrFail($id);
        $this->inventory_id = $id;
        $this->name = $inventory->name;
        $this->category_id = $inventory->category_id;
        $this->uom_code = $inventory->uom_code;
        $this->price = $inventory->price;
        $this->stock_minimum = $inventory->stock_minimum;
        $this->insert_by = $inventory->insert_by;
        $this->insert_date = $inventory->insert_date->format('Y-m-d\TH:i');
        $this->status = $inventory->status;
        $this->last_update_by = $inventory->last_update_by;
        $this->last_update_time = $inventory->last_update_time?->format('Y-m-d\TH:i');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'uom_code' => 'required|exists:uoms,id',
            'price' => 'required|numeric|min:0',
            'stock_minimum' => 'required|integer|min:0',
            'insert_by' => 'required',
            'insert_date' => 'required|date',
            'status' => 'required|in:active,nonactive'
        ]);

        $inventory = InvModel::findOrFail($this->inventory_id);

        $inventory->update([
            'name' => $this->name,
            'category_id' => $this->category_id,
            'uom_code' => $this->uom_code,
            'price' => $this->price,
            'stock_minimum' => $this->stock_minimum,
            'insert_by' => $this->insert_by,
            'insert_date' => $this->insert_date,
            'status' => $this->status,
            'last_update_by' => $this->last_update_by ?? $this->insert_by,
            'last_update_time' => $this->last_update_time ?? now()
        ]);

        $this->dispatch('editSubmitted');
        $this->resetInputFields();
        session()->flash('message', 'Inventory item updated successfully.');
    }

    public function delete($id)
    {
        Inventory::find($id)->delete();
        session()->flash('message', 'Inventory item deleted successfully.');
    }
}
