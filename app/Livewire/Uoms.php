<?php

namespace App\Livewire;

use App\Models\Uoms as ModelsUoms;
use Carbon\Carbon;
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
        $this->uom_id = null;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required'
        ]);

        ModelsUoms::insert([
            'name' => $this->name,
            'insert_by' => auth()->user()->name,
            'insert_time' => Carbon::now(),
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
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
        ]);

        $uom = ModelsUoms::findOrFail($this->uom_id);

        $uom->update([
            'name' => $this->name,
            'last_update_by' => auth()->user()->name,
            'last_update_time' => Carbon::now()
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
