<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Users\UserFilter as UserFilter;
use App\Services\Users\RoleUserFilter as RoleUserFilter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
       //
    }
}
