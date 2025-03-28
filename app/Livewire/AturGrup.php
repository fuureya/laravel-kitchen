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
        $this->permissions = '';
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
        $this->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'array|required' // Pastikan permissions adalah array dan tidak kosong
        ]);

        $grup = Grup::findOrFail($this->grupId);

        // Hapus data permissions lama sebelum menyimpan yang baru
        $grup->permissions = null;
        $grup->save();

        // Simpan permissions baru, pastikan tidak ada data lama yang tersisa
        $grup->update([
            'name' => $this->name,
            'permissions' => json_encode(array_values($this->permissions)) // Simpan hanya data baru
        ]);

        session()->flash('message', 'Grup berhasil diperbarui dengan data baru.');
        $this->resetForm();
        $this->dispatch('editSubmitted');
    }

    public function resetPermissions()
    {
        $grup = Grup::findOrFail($this->grupId);
        $grup->update([
            'permissions' => null
        ]);

        session()->flash('message', 'Permissions berhasil direset.');
        $this->dispatch('permissionsReset');
    }




    public function delete($id)
    {
        Grup::findOrFail($id)->delete();
        session()->flash('message', 'Grup berhasil dihapus.');
    }
}
