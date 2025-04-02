<?php

namespace App\Livewire;

use App\Models\Recipe as ModelsRecipe;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Recipe extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $name, $recipes;


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

    public function detail($id)
    {
        $data = ModelsRecipe::find($id);
        $this->name = $data->name;
        $this->recipes = $data->recipes;
    }

    public function closeModal()
    {
        $this->reset(['name', 'recipes']);
    }

    public function render()
    {
        $data = ModelsRecipe::paginate(10);
        return view('livewire.recipe', ["data" => $data]);
    }
}
