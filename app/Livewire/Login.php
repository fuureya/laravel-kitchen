<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $username, $password;
    public function login()
    {
        $credential = $this->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credential)) {
            session()->regenerate();
            return redirect()->intended('/');
        } else {
            session()->flash('error', 'Username atau Password salah.');
        }
    }
    public function render()
    {
        return view('livewire.login')->layout('components.layouts.auth');
    }
}
