<?php

namespace App\Livewire;

use App\Models\Suppliers as SupplierModel;
use Carbon\Carbon;
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
            'email' => 'required',
            'ap_limit' => 'required|',

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
            'insert_by' => auth()->user()->name,
            'insert_date' => Carbon::now(),

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
            'email' => 'required',
            'ap_limit' => 'required',

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
            'last_update_by' => auth()->user()->name,
            'last_update_time' => Carbon::now()
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
