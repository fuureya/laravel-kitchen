<?php

use App\Livewire\Homepage;
use App\Livewire\Uoms as UomsRoute;
use Illuminate\Support\Facades\Route;


Route::get('/', Homepage::class);
Route::get('uoms', UomsRoute::class);