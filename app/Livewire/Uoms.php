<?php

namespace App\Livewire;

use App\Models\Uoms as ModelsUoms;
use Livewire\Component;

class Uoms extends Component
{

    public $name, $insert_by, $insert_time, $last_update_by, $last_update_time, $uom_id;
    public $isModalOpen = false;
   public function render()
    {
        return view('livewire.uoms', [
            'uoms' => ModelsUoms::all()
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
        $this->name = '';
        $this->insert_by = '';
        $this->insert_time = '';
        $this->last_update_by = '';
        $this->last_update_time = '';
        $this->uom_id = null;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'insert_by' => 'required',
            'insert_time' => 'required',
        ]);

        ModelsUoms::insert([
            'name' => $this->name,
            'insert_by' => $this->insert_by,
            'insert_time' => $this->insert_time,
            'last_update_by' => $this->last_update_by,
            'last_update_time' => $this->last_update_time
        ]);

        $this->dispatch('formSubmitted');
        $this->resetInputFields();
        session()->flash('message', $this->uom_id ? 'Record Updated Successfully.' : 'Record Added Successfully.');

    }

    public function edit($id)
    {
        $uom = ModelsUoms::findOrFail($id);
        $this->uom_id = $id;
        $this->name = $uom->name;
        $this->insert_by = $uom->insert_by;
        $this->insert_time = $uom->insert_time;
        $this->last_update_by = $uom->last_update_by;
        $this->last_update_time = $uom->last_update_time;

        $this->openModal();
    }

    public function delete($id)
    {
        ModelsUoms::find($id)->delete();
        session()->flash('message', 'Record Deleted Successfully.');
    }
}
