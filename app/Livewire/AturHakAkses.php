<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\HakAkses;

class AturHakAkses extends Component
{
    public $name, $hakAksesId;
    public $isEditMode = false;

    protected $rules = [
        'name' => 'required|min:3'
    ];

    public function render()
    {
        return view('livewire.atur-hak-akses', [
            'hakAksesList' => HakAkses::latest()->get()
        ]);
    }

    public function resetForm()
    {
        $this->name = '';
        $this->hakAksesId = null;
        $this->isEditMode = false;
    }

    public function store()
    {
        $this->validate();
        HakAkses::create(['name' => $this->name]);

        session()->flash('message', 'Hak akses berhasil ditambahkan.');
        $this->resetForm();
        $this->dispatch('closeModal');
    }

    public function edit($id)
    {
        $hakAkses = HakAkses::findOrFail($id);
        $this->hakAksesId = $id;
        $this->name = $hakAkses->name;
        $this->isEditMode = true;

        $this->dispatch('openModalEdit');
    }

    public function update()
    {
        $this->validate();
        $hakAkses = HakAkses::findOrFail($this->hakAksesId);
        $hakAkses->update(['name' => $this->name]);

        session()->flash('message', 'Hak akses berhasil diperbarui.');
        $this->resetForm();
        $this->dispatch('closeModal');
    }

    public function delete($id)
    {
        HakAkses::findOrFail($id)->delete();
        session()->flash('message', 'Hak akses berhasil dihapus.');
    }
}
