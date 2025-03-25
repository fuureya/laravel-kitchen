<?php

use App\Livewire\Homepage;
use App\Livewire\Uoms as UomsRoute;
use App\Livewire\Categories as CategoryRoute;
use App\Livewire\Inventory as inventoryRoutes;
use App\Livewire\Suppliers as SupplierRoutes;
use Illuminate\Support\Facades\Route;


Route::get('/', Homepage::class);
Route::get('uoms', UomsRoute::class);
Route::get('category', CategoryRoute::class);
Route::get('inventory', inventoryRoutes::class);
Route::get('suppliers', SupplierRoutes::class);
