<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class CommunityRepoServiceProvider extends ServiceProvider
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
            'App\Contracts\Community\CountryRepositoryInterface',
            'App\Repositories\Community\CountryRepository'
        );

        $this->app->bind(
            'App\Contracts\Community\RegionRepositoryInterface',
            'App\Repositories\Community\RegionRepository'
        );

        $this->app->bind(
            'App\Contracts\Community\CityRepositoryInterface',
            'App\Repositories\Community\CityRepository'
        );

        $this->app->bind(
            'App\Contracts\Community\CommunityRepositoryInterface',
            'App\Repositories\Community\CommunityRepository'
        );

        $this->app->bind(
            'App\Contracts\Community\CommunityTypeRepositoryInterface',
            'App\Repositories\Community\CommunityTypeRepository'
        );
    }
}
