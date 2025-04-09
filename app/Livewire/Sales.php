<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Sales as ModelsSales;
use App\Models\SalesDetail;
use App\Models\Suppliers;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Sales extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $date, $suppliersID, $remark, $productID = 1, $quantity, $price, $void, $saveState = false;

    public function mount()
    {
        $this->enableSave();
    }
    public function resetForm()
    {
        $this->reset([
            'date',
            'suppliersID',
            'remark',
            'productID',
            'quantity',
            'price',
            'void'
        ]);
    }

    public function enableSave()
    {
        if ($this->productID) {
            dd($this->productID);
        }
    }

    public function store()
    {
        $this->validate([
            'date' => 'required',
            'suppliersID' => 'required',
            'remark' => 'required',
            'void' => 'required'
        ]);



        ModelsSales::create([
            'date' => $this->date,
            'suppliers_id' => $this->suppliersID,
            'remark' => $this->remark,
            'void_status' => $this->void,
            'insert_by' => auth()->user()->name,
            'insert_date' => Carbon::now()
        ]);

        SalesDetail::create([
            'sales_id' => ModelsSales::latest()->first()->id,
            'sales_product_id' => $this->productID,
            'qty' => $this->quantity,
            'price' => $this->price,
            'insert_by' => auth()->user()->name,
            'insert_date' => Carbon::now()
        ]);

        session()->flash('Message', 'Data berhasil disimpan');
        $this->resetForm();
        $this->dispatch('formSubmitted');
    }

    public function delete($id)
    {
        ModelsSales::find($id)->delete();
        session()->flash('message', 'Data berhasil dihapus');
    }

    public function render()
    {
        $suppliers = Suppliers::select('name', 'id')->get();
        $products = Product::select('product_name', 'id')->get();
        $data = ModelsSales::paginate(10);
        return view('livewire.sales', ["suppliers" => $suppliers, "products" => $products, "data" => $data]);
    }
}
