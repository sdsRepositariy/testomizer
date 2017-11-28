<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class UserRepoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Contracts\Users\UserRepositoryInterface',
            'App\Repositories\Users\UserRepository'
        );
    }
}
