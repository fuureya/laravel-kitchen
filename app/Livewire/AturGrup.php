<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\HakAkses;
use App\Models\Group as Grup; // Tambahkan model Grup
use Illuminate\Support\Facades\Validator;

class AturGrup extends Component
{
    public $name, $permissions = [], $grupId;
    public $isEditMode = false;

    protected $rules = [
        'name' => 'required|min:3',
    ];

    public function render()
    {
        return view('livewire.atur-grup', [
            'grupList' => Grup::latest()->get(),
            'hakAksesList' => HakAkses::all()
        ]);
    }

    public function resetForm()
    {
        $this->name = '';
        $this->permissions = [];
        $this->grupId = null;
        $this->isEditMode = false;
    }

    public function store()
    {

        $this->validate();

        Grup::create([
            'name' => $this->name,
            'permissions' => json_encode($this->permissions)
        ]);

        session()->flash('message', 'Grup berhasil ditambahkan.');
        $this->resetForm();
        $this->dispatch('formSubmitted');
    }

    public function edit($id)
    {
        $grup = Grup::findOrFail($id);
        $this->grupId = $id;
        $this->name = $grup->name;
        $this->permissions = json_decode($grup->permissions, true) ?? [];
        $this->isEditMode = true;

        $this->dispatch('openModalEdit');
    }

    public function update()
    {
        $this->validate();
        $grup = Grup::findOrFail($this->grupId);
        $grup->update([
            'name' => $this->name,
            'permissions' => json_encode($this->permissions)
        ]);

        session()->flash('message', 'Grup berhasil diperbarui.');
        $this->resetForm();
        $this->dispatch('editSubmitted');
    }

    public function delete($id)
    {
        Grup::findOrFail($id)->delete();
        session()->flash('message', 'Grup berhasil dihapus.');
    }
}
