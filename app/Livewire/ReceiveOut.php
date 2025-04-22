<?php

namespace App\Livewire;

use App\Models\Inventory;
use App\Models\ReceiveOut as ModelsReceiveOut;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class ReceiveOut extends Component
{

    public $date, $inven, $quantity, $price = 0, $remarks, $code;

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function resetState()
    {
        $this->reset(['date', 'inven', 'quantity', 'price', 'remarks', 'code']);
    }
    public function store()
    {
        $this->validate([
            'date' => 'required',
            'inven' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'remarks' => 'required',
        ]);

        ModelsReceiveOut::create([
            'date' => $this->date,
            'inventory_id' => $this->inventory,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'remarks' => $this->remarks,
            'insert_by' => auth()->user()->name,
            'insert_date' => Carbon::now()
        ]);

        $this->resetState();
        session()->flash('message', 'Record Added Successfully.');
    }
    public function render()
    {
        $barang = Inventory::select('name')->get();
        $data = ModelsReceiveOut::paginate(10);
        return view('livewire.receive-out', [
            'data' => $data,
            'barang' => $barang
        ]);
    }
}
