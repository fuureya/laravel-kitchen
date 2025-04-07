<?php

use App\Livewire\AturGrup;
use App\Livewire\AturHakAkses;
use App\Livewire\AturUser;
use App\Livewire\Homepage;
use App\Livewire\Uoms as UomsRoute;
use App\Livewire\Categories as CategoryRoute;
use App\Livewire\Inventory as inventoryRoutes;
use App\Livewire\Login;
use App\Livewire\Payment;
use App\Livewire\Product;
use App\Livewire\Receiving;
use App\Livewire\Recipe;
use App\Livewire\Suppliers as SupplierRoutes;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

Route::get('/dashboard', Homepage::class)->middleware('permission:view-dashboard');
Route::get('uoms', UomsRoute::class)->middleware('permission:view-uoms');
Route::get('category', CategoryRoute::class)->middleware('permission:view-category');
Route::get('items', inventoryRoutes::class)->middleware('permission:view-inventory');
Route::get('suppliers', SupplierRoutes::class)->middleware('permission:view-suppliers');
Route::get('atur-hak-akses', AturHakAkses::class)->middleware('permission:view-hak-akses');
Route::get('atur-grup', AturGrup::class)->middleware('permission:view-atur-grup');
Route::get('atur-user', AturUser::class)->middleware('permission:view-atur-user');
Route::get('receiving', Receiving::class)->middleware('permission:view-receiving');
Route::get('recipe', Recipe::class)->middleware('permission:view-recipe');
Route::get('payment', Payment::class)->middleware('permission:view-recipe');
Route::get('products', Product::class)->middleware('permission:view-recipe');

Route::get('login', Login::class)->middleware('guest');
