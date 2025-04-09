<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Sales as ModelsSales;
use App\Models\SalesDetail;
use App\Models\Suppliers;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;


class Sales extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $date, $suppliersID, $remark, $productID, $quantity, $price, $void, $saveState = false, $insertBy, $insertDate, $total;

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
            'void',
            'insertBy',
            'insertDate',
            'saveState',
            'total'
        ]);
    }

    public function closeModal()
    {
        $this->resetForm();
    }

    public function showDetail($id)
    {
        $sales = ModelsSales::find($id);
        $this->date = $sales->date;
        $this->suppliersID = $sales->supplier->name;
        $this->remark = $sales->remark;
        $this->void = $sales->void_status;
        $this->insertBy = $sales->insert_by;
        $this->insertDate = $sales->insert_date;

        $salesDetail = SalesDetail::where('sales_id', $id)->first();
        $getProductName = Product::where('id', $salesDetail->sales_product_id)->select('product_name', 'price')->first();
        $this->productID = $getProductName->product_name;
        $this->price = $getProductName->price;
        $this->quantity = $salesDetail->qty;
        $this->total = $salesDetail->price;
        // $this->productID = $salesDetail->product->name;
    }




    public function store()
    {
        $this->validate([
            'date' => 'required',
            'suppliersID' => 'required',
            'remark' => 'required',
            'void' => 'required',
            'productID' => 'required',
            'quantity' => 'required'
        ]);

        $getProductPrice = Product::where('id', $this->productID)->select('price')->first();
        $localPrice = $getProductPrice->price * $this->quantity;

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
            'price' => $localPrice,
            'insert_by' => auth()->user()->name,
            'insert_date' => Carbon::now()
        ]);

        session()->flash('Message', 'Data berhasil disimpan');
        $this->resetForm();
        $this->dispatch('formSubmitted');
    }

    public function enableSave()
    {
        $this->saveState = true;
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
