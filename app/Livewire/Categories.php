<?php

namespace App\Livewire;

use App\Models\Category;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Categories extends Component
{
    use WithPagination;

    public $name, $insert_by, $insert_time, $last_update_by, $last_update_time, $category_id;
    public $isModalOpen = false;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.categories', [
            'categories' => Category::orderBy('id', 'desc')->paginate(4)
        ]);
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->resetInputFields();
        $this->isModalOpen = false;
    }

    private function resetInputFields()
    {
        $this->reset(['name', 'insert_by', 'insert_time', 'last_update_by', 'last_update_time', 'category_id']);
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
        ]);

        Category::create([
            'name' => $this->name,
            'insert_by' => auth()->user()->name,
            'insert_time' => Carbon::now(),

        ]);

        $this->dispatch('formSubmitted');
        $this->resetInputFields();
        session()->flash('message', $this->category_id ? 'Record Updated Successfully.' : 'Record Added Successfully.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->category_id = $id;
        $this->name = $category->name;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
        ]);

        $category = Category::findOrFail($this->category_id);

        $category->update([
            'name' => $this->name,
            'last_update_by' => auth()->user()->name,
            'last_update_time' => Carbon::now()
        ]);

        $this->dispatch('editSubmitted');
        $this->resetInputFields();
        session()->flash('message', 'Record Updated Successfully.');
    }

    public function delete($id)
    {
        Category::find($id)->delete();
        session()->flash('message', 'Record Deleted Successfully.');
    }
}
