<?php

namespace App\Providers;

use App\Models\pemain;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('developer_game', function (pemain $user) { //untuk developer 2
        return $user->role_id == 2;
        });
        Gate::define('pemain_game', function (pemain $user) { //untuk pemain 3
        return $user->role_id == 3;
        });
        Gate::define('administrator', function (pemain $user) { //untuk pemain 3
        return $user->role_id == 1;
        });


        JsonResource::withoutWrapping();//untuk membuat response di resource tanpa "data"
    }
}
