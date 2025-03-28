<?php

namespace App\Livewire\Layouts;

use Livewire\Component;

class Sidebar extends Component
{
    public $activeMenu;

    protected $listeners = ['menuUpdated' => 'updateActiveMenu'];

    public function updateActiveMenu($menu)
    {
        $this->activeMenu = $menu;
    }
    public function render()
    {
        return view('livewire.layouts.sidebar');
    }
}
