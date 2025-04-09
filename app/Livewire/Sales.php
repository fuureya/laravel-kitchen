<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Sales as ModelsSales;
use App\Models\Suppliers;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Sales extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $date, $suppliersID, $remark, $productID, $quantity, $price, $void;
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

        session()->flash('Message', 'Data berhasil disimpan');
        $this->resetForm();
        $this->dispatch('formSubmitted');
    }

    public function render()
    {
        $suppliers = Suppliers::select('name', 'id')->get();
        $products = Product::select('product_name', 'id')->get();
        $data = ModelsSales::paginate(10);
        return view('livewire.sales', ["suppliers" => $suppliers, "products" => $products, "data" => $data]);
    }
}
