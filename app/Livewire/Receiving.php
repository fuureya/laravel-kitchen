<?php

namespace App\Livewire;

use App\Models\Suppliers;
use App\Models\User;
use Illuminate\Support\Facades\DB as FacadesDB;
use Livewire\Component;

class Receiving extends Component
{
    public function render()
    {
        $suppliers = Suppliers::select('name', 'id')->get();
        return view('livewire.receiving', ["suppliers" => $suppliers]);
    }
}
