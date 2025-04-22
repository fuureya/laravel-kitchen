<?php

namespace App\Livewire;

use App\Models\Inventory;
use App\Models\ReceivingDetail;
use Livewire\Component;


class ReceiveOut extends Component
{
    public function render()
    {
        $barang = Inventory::select('name')->get();
        return view('livewire.receive-out', [
            'barang' => $barang
        ]);
    }
}
