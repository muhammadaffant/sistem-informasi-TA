<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Pembelian;
use App\Models\Slider;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;

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

     public function boot()
     {
         View::composer('auth.login', function ($view) {
             $view->with('title', 'Login');
         });
     }
}
