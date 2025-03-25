<?php

namespace App\Livewire;

use App\Models\Suppliers as SupplierModel;
use Livewire\Component;
use Livewire\WithPagination;

class Suppliers extends Component
{
    use WithPagination;

    public $name, $pic, $phone, $street, $city, $country, $email, $ap_limit;
    public $insert_by, $insert_date, $last_update_by, $last_update_time, $supplier_id;
    public $isModalOpen = false;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.suppliers', [
            'suppliers' => SupplierModel::orderBy('id', 'desc')->paginate(4)
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
            'pic',
            'phone',
            'street',
            'city',
            'country',
            'email',
            'ap_limit',
            'insert_by',
            'insert_date',
            'last_update_by',
            'last_update_time',
            'supplier_id'
        ]);
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'pic' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'email' => 'required|email|unique:suppliers,email',
            'ap_limit' => 'required|numeric|min:0',
            'insert_by' => 'required|string|max:255',
            'insert_date' => 'required|date',
        ]);

        SupplierModel::create([
            'name' => $this->name,
            'pic' => $this->pic,
            'phone' => $this->phone,
            'street' => $this->street,
            'city' => $this->city,
            'country' => $this->country,
            'email' => $this->email,
            'ap_limit' => $this->ap_limit,
            'insert_by' => $this->insert_by,
            'insert_date' => $this->insert_date,
            'last_update_by' => $this->last_update_by,
            'last_update_time' => $this->last_update_time
        ]);

        $this->dispatch('formSubmitted');
        $this->resetInputFields();
        session()->flash('message', 'Supplier added successfully.');
    }

    public function edit($id)
    {
        $supplier = SupplierModel::findOrFail($id);
        $this->supplier_id = $id;
        $this->name = $supplier->name;
        $this->pic = $supplier->pic;
        $this->phone = $supplier->phone;
        $this->street = $supplier->street;
        $this->city = $supplier->city;
        $this->country = $supplier->country;
        $this->email = $supplier->email;
        $this->ap_limit = $supplier->ap_limit;
        $this->insert_by = $supplier->insert_by;
        $this->insert_date = $supplier->insert_date->format('Y-m-d\TH:i');
        $this->last_update_by = $supplier->last_update_by;
        $this->last_update_time = $supplier->last_update_time?->format('Y-m-d\TH:i');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'pic' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'email' => 'required|email|unique:suppliers,email,' . $this->supplier_id,
            'ap_limit' => 'required|numeric|min:0',
            'insert_by' => 'required|string|max:255',
            'insert_date' => 'required|date',
        ]);

        $supplier = SupplierModel::findOrFail($this->supplier_id);

        $supplier->update([
            'name' => $this->name,
            'pic' => $this->pic,
            'phone' => $this->phone,
            'street' => $this->street,
            'city' => $this->city,
            'country' => $this->country,
            'email' => $this->email,
            'ap_limit' => $this->ap_limit,
            'insert_by' => $this->insert_by,
            'insert_date' => $this->insert_date,
            'last_update_by' => $this->last_update_by ?? $this->insert_by,
            'last_update_time' => $this->last_update_time ?? now()
        ]);

        $this->dispatch('editSubmitted');
        $this->resetInputFields();
        session()->flash('message', 'Supplier updated successfully.');
    }

    public function delete($id)
    {
        SupplierModel::find($id)->delete();
        session()->flash('message', 'Supplier deleted successfully.');
    }
}
