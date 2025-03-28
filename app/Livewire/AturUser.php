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
        $permission = Group::where('name', $this->group)->first();
        // dd($this->username);
        // dd(json_encode([$permission->permissions]));
        User::create([
            'name' => $this->name,
            'username' => $this->username,
            'password' => Hash::make($this->password),
            'group' => $this->group,
            'permissions' => json_encode([$permission->permissions])
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
        $this->group = json_decode($user->group)[0] ?? '';

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
        $user->update([
            'name' => $this->name,
            'password' => $this->password ? Hash::make($this->password) : $user->password,
            'group' => json_encode([$this->group])
        ]);

        session()->flash('message', 'User berhasil diperbarui.');
        $this->resetForm();
        $this->dispatch('closeModal');
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
        session()->flash('message', 'User berhasil dihapus.');
    }
}
