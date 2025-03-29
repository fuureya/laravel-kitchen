<?php

namespace App\Livewire;

use App\Models\Inventory;
use App\Models\Suppliers;
use Livewire\Component;

class Receiving extends Component
{
    public $receivingID, $date, $suppliers, $remarks, $inventory, $quantity, $price, $priceQuantity;

    public function closeDetail()
    {
        $this->inventory = '';
        $this->quantity = 0;
        $this->price = 0;
        $this->priceQuantity = 0;
    }

    public function closeReceiving()
    {
        $this->receivingID = '';
        $this->date = '';
        $this->suppliers = '';
        $this->remarks = '';
    }
    public function render()
    {
        $this->priceQuantity = $this->quantity * $this->price;
        $suppliersDB = Suppliers::select('name', 'id')->get();
        $inventoryDB = Inventory::select('name', 'id')->get();


        return view('livewire.receiving', [
            "supp" => $suppliersDB,
            "invent" => $inventoryDB
        ]);
    }
}
