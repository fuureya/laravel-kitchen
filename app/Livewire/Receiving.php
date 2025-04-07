<?php

namespace App\Livewire;

use App\Models\Inventory;
use App\Models\Receiving as ModelsReceiving;
use App\Models\ReceivingDetail as ModelsReceivingDetail;
use App\Models\ReceivingPurchase;
use App\Models\Payment as PaymentModel;
use App\Models\Suppliers;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Barryvdh\DomPDF\Facade\Pdf;


class Receiving extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $code, $receivingID, $date, $payment, $uoms, $namaInventory, $suppliers, $remarks, $inventory, $quantity, $price, $priceQuantity, $paid, $status, $purchase, $insertTime, $insertBy;
    public $saveState = false;

    public $getAllInventory;

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

    #[On('inventory-updated')]
    public function getUoms()
    {
        if (!empty($this->inventory)) {
            $data = Inventory::with('uom')->find($this->inventory);

            if ($data && $data->uom) {

                $this->uoms = $data->uom->name; // Store as an array for easy select use
            }
        } else {
            $this->uoms = '';
        }
    }

    public function updatedInventory()
    {
        $this->dispatch('inventory-updated');
    }

    public function closeDetail()
    {
        $this->inventory = '';
        $this->quantity = 0;
        $this->price = 0;
        $this->priceQuantity = 0;
        $this->receivingID = '';
        $this->reset(['code', 'receivingID', 'date', 'uoms', 'namaInventory', 'suppliers', 'remarks', 'inventory', 'quantity', 'price', 'priceQuantity', 'paid', 'status', 'purchase', 'insertTime', 'insertBy']);
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
        $data = Inventory::where('id', $this->inventory)->first();
        if ($data != null) {
            $this->saveState = true;
            $this->namaInventory = $data->name;
            $this->dispatch('modalAddDetail');
        } else {
            session()->flash('error', 'Masih Kosong!!!');
        }
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
            'payment_name' => $this->payment,
            'price_qty' => $this->priceQuantity,
            'insert_date' => Carbon::now(),
            'insert_by' => auth()->user()->name
        ]);
        $this->saveState = false;
        $this->reset(['code', 'date', 'suppliers', 'remarks', 'inventory', 'quantity', 'price', 'priceQuantity', 'payment']);
        session()->flash('message', 'Receiving item added successfully.');
        return redirect('/receiving');
    }

    public function showDetail($id)
    {
        $data =  ModelsReceivingDetail::where('receiving_code', $id)->first();

        if ($id) {
            $detailPurchase = ReceivingPurchase::where('receiving_code', $id)->get();
            $this->getAllInventory = $detailPurchase;
        }
        $this->quantity = $data->qty;
        $this->price = $data->price;

        $this->inventory = $data->inventory_id;
        $this->priceQuantity = $this->quantity * $this->price;
        $this->receivingID = $data->receiving_code;
        $this->getUoms();
    }

    public function edit($id)
    {
        $data =  ModelsReceivingDetail::where('receiving_code', $id)->first();
        $this->quantity = $data->qty;
        $this->price = $data->price;
        $this->inventory = $data->inventory_id;
        $this->priceQuantity = $data->price_qty;
        $this->receivingID = $data->receiving_code;
        $this->getUoms();
    }

    public function update()
    {


        $this->validate([
            'inventory' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'paid' => 'required',
            'payment' => 'required'
        ]);



        ModelsReceivingDetail::where('receiving_code', $this->receivingID)->update([
            'inventory_id' => $this->inventory,
            'qty' => $this->quantity,
            'price' => $this->price,
            'price_qty' => $this->priceQuantity,
            'last_update_by' => auth()->user()->name,
            'last_update_time' => Carbon::now()
        ]);


        ModelsReceiving::where('receiving_id', $this->receivingID)->update([
            'last_update_by' => auth()->user()->name,
            'last_update_time' => Carbon::now()
        ]);

        if ($this->status && $this->paid && $this->purchase) {
            // get receiving id
            $getID = ModelsReceiving::where('receiving_id', $this->receivingID)->first();
            $getNameInventory = ModelsReceivingDetail::where('inventory_id', $this->inventory)->first();
            // dd($getNameInventory->inventory->name);

            ReceivingPurchase::create([
                'receiving_id' => $getID->id,
                'receiving_code' => $this->receivingID,
                'name' => $getNameInventory->inventory->name,
                'total' => $this->paid,
                'payment_name' => $this->payment,
                'purchase' => $this->purchase,
                'status' => $this->status,
                'insert_by' => auth()->user()->name,
                'insert_time' => Carbon::now()
            ]);
        }

        $this->reset(['code', 'receivingID', 'date', 'suppliers', 'remarks', 'inventory', 'quantity', 'price', 'priceQuantity', 'paid', 'purchase', 'status', 'payment']);
        $this->dispatch('formEditSubmitted');
        session()->flash('message', 'Receiving item updated successfully.');
    }



    public function delete($id)
    {
        ModelsReceiving::where('receiving_id', $id)->delete();
    }

    public function printing($token)
    {

        $path = public_path('logobk.png'); // Path to your image
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $data = ModelsReceiving::where('receiving.id', $token)
            ->join('receiving_detail', 'receiving_detail.receiving_id', '=', 'receiving.id')
            ->first();

        $inventory = Inventory::where('id', $data->inventory_id)->first();


        if (!$data) {
            session()->flash('error', 'Data not found for printing.');
            return;
        }

        $pdfData = [
            'receivingID' => $data->receiving_code,
            'quantity' => $data->qty,
            'price' => $data->price,
            'inventory' => $inventory->name,
            'total' => $data->qty * $data->price,
            'date' => Carbon::now('Y', 'm', 'd'),
            'price_qty' => $data->price_qty,
            'create_by' => auth()->user()->name,
            'remark' => $data->remark,
            'image' => $base64

        ];

        // Generate PDF
        $pdf = Pdf::loadView('pdf', $pdfData);

        // Return the PDF as a downloadable response
        return response()->streamDownload(
            fn() => print($pdf->output()),
            "Receiving_{$data->receiving_code}.pdf"
        );
    }


    public function render()
    {
        // kalkulasi harga dan stok
        if ($this->quantity != null && $this->price != null) {
            $this->priceQuantity = $this->quantity * $this->price;
        }

        $paymentData =  PaymentModel::select('payment_name')->get();

        $suppliersDB = Suppliers::select('name', 'id')->get();
        $inventoryDB = Inventory::select('name', 'id')->get();
        $data = ModelsReceiving::paginate(10);
        return view('livewire.receiving', [
            "supp" => $suppliersDB,
            "invent" => $inventoryDB,
            "data" => $data,
            'paymentData' => $paymentData
        ]);
    }
}
