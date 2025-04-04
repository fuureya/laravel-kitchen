<?php

namespace App\Livewire;

use App\Models\Recipe as ModelsRecipe;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Recipe extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $name, $recipes, $token;


    public function store()
    {
        $this->validate([
            'name' => 'required',
            'recipes' => 'required'
        ]);

        ModelsRecipe::create([
            'name' => $this->name,
            'recipes' => $this->recipes,
            'insert_by' => auth()->user()->name,
            'insert_time' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $this->reset(['name', 'recipes']);
        session()->flash('message', 'Recipes item added successfully.');
        $this->dispatch('formSubmitted');
    }

    public function delete($id)
    {
        ModelsRecipe::find($id)->delete();
        session()->flash('message', 'Record Deleted Successfully.');
    }

    public function detail($id)
    {
        $data = ModelsRecipe::find($id);
        $this->name = $data->name;
        $this->recipes = $data->recipes;
    }

    public function edit($id)
    {
        $data = ModelsRecipe::find($id);
        $this->token = $data->id;
        $this->name = $data->name;
        $this->recipes = $data->recipes;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'recipes' => 'required'
        ]);

        $data = ModelsRecipe::find($this->token);
        $data->update([
            'name' => $this->name,
            'recipes' => $this->recipes,
            'update_by' => Carbon::now(),
            'last_update_time' => Carbon::now()
        ]);

        $this->reset(['name', 'recipes', 'token']);
        session()->flash('message', 'Record Updated Successfully.');
        $this->dispatch('formSubmitted');
    }

    public function closeModal()
    {
        $this->reset(['name', 'recipes', 'token']);
    }

    public function print($id)
    {
        $data = ModelsRecipe::where('id', $id)->first();
        $pdfData = [
            'recipes' => $data->recipes
        ];

        // Generate PDF
        $pdf = Pdf::loadView('resep', $pdfData);

        // Return the PDF as a downloadable response
        return response()->streamDownload(
            fn() => print($pdf->output()),
            "resep_{$data->name}.pdf"
        );
    }

    public function render()
    {
        $data = ModelsRecipe::paginate(10);
        return view('livewire.recipe', ["data" => $data]);
    }
}
