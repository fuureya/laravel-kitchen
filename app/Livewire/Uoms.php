<?php

namespace App\Livewire;

use App\Models\Uoms as ModelsUoms;
use Livewire\Component;
use Livewire\WithPagination;

class Uoms extends Component
{
    use WithPagination;
    public $name, $insert_by, $insert_time, $last_update_by, $last_update_time, $uom_id;
    public $isModalOpen = false;
    protected $paginationTheme = 'bootstrap';

   public function render()
    {
        return view('livewire.uoms', [
            'uoms' => ModelsUoms::orderBy('id', 'desc')->paginate(4)
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
    }
    
  public function update()
{
    $this->validate([
        'name' => 'required',
        'insert_by' => 'required',
        'insert_time' => 'required',
    ]);

    $uom = ModelsUoms::findOrFail($this->uom_id);
    
    $uom->update([
        'name' => $this->name,
        'insert_by' => $this->insert_by,
        'insert_time' => $this->insert_time,
        'last_update_by' => $this->last_update_by ?? $this->insert_by, 
        'last_update_time' => $this->last_update_time ?? now() 
    ]);

    $this->dispatch('editSubmitted');
    $this->resetInputFields();
    session()->flash('message', 'Record Updated Successfully.');
}

    public function delete($id)
    {
        ModelsUoms::find($id)->delete();
        session()->flash('message', 'Record Deleted Successfully.');
    }
}
