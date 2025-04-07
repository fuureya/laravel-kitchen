<?php

namespace App\Livewire;

use App\Models\Payment as ModelsPayment;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Payment as PaymentModel;

class Payment extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $name, $token;

    private function resetInputFields()
    {
        $this->reset(['name', 'token']);
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
        ]);

        PaymentModel::create([
            'payment_name' => $this->name,
            'insert_by' => auth()->user()->name,
            'insert_time' => Carbon::now(),

        ]);

        $this->dispatch('formSubmitted');
        $this->resetInputFields();
        session()->flash('message', 'Record Added Successfully.');
    }

    public function edit($id)
    {
        $data = PaymentModel::findOrFail($id);
        $this->token = $id;
        $this->name = $data->payment_name;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
        ]);

        $data = PaymentModel::findOrFail($this->token);

        $data->update([
            'payment_name' => $this->name,
        ]);

        $this->dispatch('editSubmitted');
        $this->resetInputFields();
        session()->flash('message', 'Record Updated Successfully.');
    }

    public function delete($id)
    {
        PaymentModel::find($id)->delete();
        session()->flash('message', 'Record Deleted Successfully.');
    }

    public function render()
    {
        $data = ModelsPayment::paginate(10);

        return view('livewire.payment', ["data" => $data]);
    }
}
