<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class APIServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\JenisBahan\JenisBahanRepositoryInterface',
            'App\Repositories\JenisBahan\JenisBahanRepository'
        );
        // $this->app->bind(
        //     'App\Repositories\LoggerCrud\LoggerCrudRepositoryInterface',
        //     'App\Repositories\LoggerCrud\LoggerCrudRepository'
        // );
        $this->app->bind(
            'App\Repositories\Trash\TrashRepositoryInterface',
            'App\Repositories\Trash\TrashRepository'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
