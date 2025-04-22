<?php

namespace App\Livewire;

use App\Models\Inventory;
use App\Models\ReceiveOut as ModelsReceiveOut;
use App\Models\ReceivingDetail;
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

    public function closeButton()
    {
        $this->resetState();
    }

    public function generateUniqueCode()
    {
        $year = Carbon::now()->format('y');
        $lastRecord = ModelsReceiveOut::where('receiving_out_id', 'like', "%" . "OUT{$year}" . "%")
            ->orderBy('id', 'desc')
            ->first();
        // jika masih kosong sama sekali
        if (is_null($lastRecord)) {
            $newNumber = '00001';
            return "OUT{$year}{$newNumber}";
        }
        // jika sudah pernah ada dalam db
        if ($lastRecord) {
            $lastNumber = (int)substr($lastRecord->receiving_out_id, -5);
            $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
            return "OUT{$year}{$newNumber}";
        }
    }
    public function store()
    {
        $this->validate([
            'date' => 'required',
            'inven' => 'required',
            'quantity' => 'required',
            'remarks' => 'required',
        ]);


        // check is stock full
        $stock = ReceivingDetail::where('inventory_id', $this->inven)->sum('qty');
        if ($stock < $this->quantity) {
            session()->flash('error', 'Stock is not enough');
            $this->resetState();
            $this->dispatch('formSubmitted');
        } else {
            ModelsReceiveOut::create([
                'date' => $this->date,
                'receiving_out_id' => $this->generateUniqueCode(),
                'inventory_id' => $this->inven,
                'quantity' => $this->quantity,
                'price' => $this->price,
                'remark' => $this->remarks,
                'insert_by' => auth()->user()->name,
                'insert_date' => Carbon::now()
            ]);

            $this->resetState();
            $this->dispatch('formSubmitted');
            session()->flash('message', 'Record Added Successfully.');
        }
    }

    public function edit($id)
    {
        $data = ModelsReceiveOut::find($id);
        $this->date = $data->date;
        $this->inven = $data->inventory_id;
        $this->quantity = $data->quantity;
        $this->remarks = $data->remark;
        $this->code = $data->id;
    }

    public function update()
    {
        $this->validate([
            'date' => 'required',
            'inven' => 'required',
            'quantity' => 'required',
            'remarks' => 'required',
        ]);

        $stock = ReceivingDetail::where('inventory_id', $this->inven)->sum('qty');
        if ($stock < $this->quantity) {
            session()->flash('error', 'Stock is not enough');
            $this->resetState();
            $this->dispatch('formEditSubmitted');
        } else {
            ModelsReceiveOut::find($this->code)->update([
                'date' => $this->date,
                'inventory_id' => $this->inven,
                'quantity' => $this->quantity,
                'remark' => $this->remarks,
                'last_update_by' => auth()->user()->name,
                'last_update_time' => Carbon::now()
            ]);

            $this->resetState();
            $this->dispatch('formEditSubmitted');
            session()->flash('message', 'Record Updated Successfully.');
        }
    }

    public function delete($id)
    {
        ModelsReceiveOut::find($id)->delete();
        session()->flash('message', 'Record Deleted Successfully.');
    }
    public function render()
    {
        $barang = Inventory::select('name', 'id')->get();
        $data = ModelsReceiveOut::paginate(10);
        return view('livewire.receive-out', [
            'data' => $data,
            'barang' => $barang
        ]);
    }
}
