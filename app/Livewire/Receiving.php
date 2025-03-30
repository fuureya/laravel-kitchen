<?php

namespace App\Livewire;

use App\Models\Inventory;
use App\Models\Receiving as ModelsReceiving;
use App\Models\ReceivingDetail as ModelsReceivingDetail;
use App\Models\Suppliers;
use Carbon\Carbon;
use Livewire\Component;

class Receiving extends Component
{
    public $code, $receivingID, $date, $suppliers, $remarks, $inventory, $quantity = 0, $price = 0, $priceQuantity = 0;
    public $saveState = false;

    public function generateUniqueCode()
    {
        $year = Carbon::now()->format('y');
        $lastRecord = ModelsReceiving::where('receiving_id', 'like', "%" . "RCV{$year}" . "%")
            ->orderBy('id', 'desc')
            ->first();
        // jika masih kosong sama sekali
        if (is_null($lastRecord)) {
            $newNumber = '00001';
            return "RCV{$year}{$newNumber}";
        }
        // jika sudah pernah ada dalam db
        if ($lastRecord) {
            $lastNumber = (int)substr($lastRecord->receiving_id, -5);
            $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
            return "RCV{$year}{$newNumber}";
        }
    }

    public function closeDetail()
    {
        $this->inventory = '';
        $this->quantity = 0;
        $this->price = 0;
        $this->priceQuantity = 0;
    }

    public function closeReceiving()
    {
        return '';
        $this->date = '';
        $this->suppliers = '';
        $this->remarks = '';
    }

    public function enableSaving()
    {
        $this->saveState = true;
        $this->dispatch('modalAddDetail');
    }

    public function store()
    {
        $tempCode = $this->generateUniqueCode();
        $this->validate([
            'date' => 'required',
            'suppliers' => 'required',
            'remarks' => 'required',
            'inventory' => 'required',
            'quantity' => 'required',
            'price' => 'required',
        ]);

        ModelsReceiving::create([
            'date' => $this->date,
            'receiving_id' => $tempCode,
            'supplier_id' => $this->suppliers,
            'remark' => $this->remarks,
            'insert_by' => auth()->user()->name,
            'insert_date' => Carbon::now()
        ]);

        $getLastReceiving = ModelsReceiving::orderBy('id', 'desc')->select('id')->first();

        ModelsReceivingDetail::create([
            'receiving_id' => $getLastReceiving->id,
            'receiving_code' => $tempCode,
            'inventory_id' => $this->inventory,
            'qty' => $this->quantity,
            'price' => $this->price,
            'price_qty' => $this->priceQuantity,
            'insert_date' => Carbon::now(),
            'insert_by' => auth()->user()->name
        ]);
        $this->saveState = false;
        $this->reset(['code', 'date', 'suppliers', 'remarks', 'inventory', 'quantity', 'price', 'priceQuantity']);
        $this->dispatch('formSubmitted');
    }

    public function showDetail($id)
    {
        $data =  ModelsReceivingDetail::where('receiving_code', $id)->first();
        $this->quantity = $data->qty;
        $this->price = $data->price;
        $this->inventory = $data->inventory_id;
        $this->priceQuantity = $data->price_qty;
        $this->receivingID = $data->receiving_code;
    }

    public function edit($id)
    {
        dd('anjay');
    }

    public function delete($id)
    {
        ModelsReceiving::where('receiving_id', $id)->delete();
    }


    public function render()
    {
        // kalkulasi harga dan stok
        if ($this->quantity != null && $this->price != null) {
            $this->priceQuantity = $this->quantity * $this->price;
        }

        $suppliersDB = Suppliers::select('name', 'id')->get();
        $inventoryDB = Inventory::select('name', 'id')->get();
        $data = ModelsReceiving::all();
        return view('livewire.receiving', [
            "supp" => $suppliersDB,
            "invent" => $inventoryDB,
            "data" => $data
        ]);
    }
}
