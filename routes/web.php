<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/adminlte', function() {
    return view('pages.sample');
});

Route::get('/login', function() {
    return view('login');
})->name('login');

Route::group(['prefix' => 'inventory'], function() {
    Route::get('/kain', 'UI\DashboardController@kain')->name("kain");
    Route::get('/transaksi_kain', 'UI\DashboardController@transaksiKain')->name("transaksi_kain");
    Route::get('/induk', 'UI\DashboardController@induk')->name('induk');
    Route::get('/barang', 'UI\DashboardController@barang')->name('barang');
});

Route::group(['prefix' => 'produksi'], function() {
    Route::get('/wos', 'UI\DashboardController@wos')->name('wos');
    Route::get('/penjahit', 'UI\DashboardController@penjahit')->name('penjahit');
    Route::get('/pembayaran', 'UI\DashboardController@pembayaran')->name('pembayaran');
});

Route::group(['prefix' => 'penjualan'], function() {
    Route::get('/pemesanan', 'UI\DashboardController@pemesanan')->name('pemesanan');
    Route::get('/produk', 'UI\DashboardController@produk')->name('produk');
});