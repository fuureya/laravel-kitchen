<?php

namespace App\Livewire;

use App\Models\Category;
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
            'insert_by' => 'required',
            'insert_time' => 'required',
        ]);

        Category::create([
            'name' => $this->name,
            'insert_by' => $this->insert_by,
            'insert_time' => $this->insert_time,
            'last_update_by' => $this->last_update_by,
            'last_update_time' => $this->last_update_time
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
        $this->insert_by = $category->insert_by;
        $this->insert_time = $category->insert_time;
        $this->last_update_by = $category->last_update_by;
        $this->last_update_time = $category->last_update_time;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'insert_by' => 'required',
            'insert_time' => 'required',
        ]);

        $category = Category::findOrFail($this->category_id);

        $category->update([
            'name' => $this->name,
            'insert_by' => $this->insert_by,
            'insert_time' => $this->insert_time,
            'last_update_by' => $this->last_update_by ?? $this->insert_by,
            'last_update_time' => $this->last_update_time ?? now()
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
