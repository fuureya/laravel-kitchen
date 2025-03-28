<?php

namespace App\Livewire;

use Livewire\Component;

class Homepage extends Component
{
    public function render()
    {
        // dd(auth()->user());
        return view('livewire.homepage');
    }
}
