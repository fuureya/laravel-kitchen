<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Group;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class AturUser extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $name, $username, $password, $group, $userId;
    public $isEditMode = false;

    protected $rules = [
        'name' => 'required|min:3',
        'username' => 'required|unique:users,username',
        'password' => 'nullable|min:6',
        'group' => 'required'
    ];

    public function render()
    {
        return view('livewire.atur-user', [
            'users' => User::paginate(10),
            'groups' => Group::all()
        ]);
    }

    public function resetForm()
    {
        $this->name = '';
        $this->username = '';
        $this->password = '';
        $this->group = '';
        $this->userId = null;
        $this->isEditMode = false;
    }

    public function store()
    {
        $this->validate();
        // $permission = Group::where('name', $this->group)->first();
        // $permissions = is_array($permission->permissions) ? $permission->permissions : json_decode($permission->permissions, true);
        // // dd($permission);


        // Ambil data group berdasarkan nama
        $group = Group::where('name', $this->group)->first();

        if (!$group) {
            session()->flash('error', 'Group tidak ditemukan.');
            return;
        }

        // Pastikan permissions adalah array satu tingkat sebelum menyimpan
        $permissions = json_decode($group->permissions, true); // Decode ke array jika masih dalam JSON string
        if (is_array($permissions) && count($permissions) === 1 && is_array($permissions[0])) {
            $permissions = $permissions[0]; // Hilangkan nested array jika ada
        }

        User::create([
            'name' => $this->name,
            'username' => $this->username,
            'password' => Hash::make($this->password),
            'group' => $this->group,
            'permissions' => json_encode($permissions)
        ]);

        session()->flash('message', 'User berhasil ditambahkan.');
        $this->resetForm();
        $this->dispatch('closeModal');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $id;
        $this->name = $user->name;
        $this->username = $user->username;
        // $this->permissions = json_decode($user->permissions)[0] ?? '';

        $this->isEditMode = true;
        $this->dispatch('openModalEdit');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|min:3',
            'password' => 'nullable|min:6',
            'group' => 'required'
        ]);

        $user = User::findOrFail($this->userId);

        // Ambil data group berdasarkan nama
        $group = Group::where('name', $this->group)->first();

        if (!$group) {
            session()->flash('error', 'Group tidak ditemukan.');
            return;
        }

        $permissions = json_decode($group->permissions, true);
        if (is_array($permissions) && count($permissions) === 1 && is_array($permissions[0])) {
            $permissions = $permissions[0];
        }

        $user->update([
            'name' => $this->name,
            'password' => $this->password ? Hash::make($this->password) : $user->password,
            'group' => $this->group,
            'permissions' => json_encode($permissions)
        ]);

        $this->dispatch('editSubmitted');
        session()->flash('message', 'User berhasil diperbarui.');
        $this->resetForm();
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
        session()->flash('message', 'User berhasil dihapus.');
    }
}
