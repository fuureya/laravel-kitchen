<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Livewire\Livewire;
use App\Http\Livewire\Layouts\Table;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('dashboard-access', function (User $user) {
            return in_array('view-dashboard', $user->permissions);
        });
    }
}
