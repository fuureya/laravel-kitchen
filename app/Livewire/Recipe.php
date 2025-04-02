<?php

namespace App\Livewire;

use Livewire\Component;

class Recipe extends Component
{
    public $name, $recipes;


    public function render()
    {
        return view('livewire.recipe');
    }
}
