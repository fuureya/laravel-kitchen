<?php

namespace App\Livewire\Layouts;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Navbar extends Component
{

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/login')->with('success', 'Anda telah logout.');
    }
    public function render()
    {
        return view('livewire.layouts.navbar');
    }
}
