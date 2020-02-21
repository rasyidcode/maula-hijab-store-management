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
    public function register() {
        $this->app->bind(
            'App\Repositories\Trash\TrashRepositoryInterface',
            'App\Repositories\Trash\TrashRepository'
        );
        $this->app->bind(
            'App\Repositories\JenisBahan\JenisBahanRepositoryInterface',
            'App\Repositories\JenisBahan\JenisBahanRepository'
        );
        $this->app->bind(
            'App\Repositories\Bahan\BahanRepositoryInterface',
            'App\Repositories\Bahan\BahanRepository'
        );
        $this->app->bind(
            'App\Repositories\Induk\IndukRepositoryInterface',
            'App\Repositories\Induk\IndukRepository'
        );
        $this->app->bind(
            'App\Repositories\Barang\BarangRepositoryInterface',
            'App\Repositories\Barang\BarangRepository'
        );
        $this->app->bind(
            'App\Repositories\Penjahit\PenjahitRepositoryInterface',
            'App\Repositories\Penjahit\PenjahitRepository'
        );
        $this->app->bind(
            'App\Repositories\Wos\WosRepositoryInterface',
            'App\Repositories\Wos\WosRepository'
        );
        // $this->app->bind(
        //     'App\Repositories\LoggerCrud\LoggerCrudRepositoryInterface',
        //     'App\Repositories\LoggerCrud\LoggerCrudRepository'
        // );
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
