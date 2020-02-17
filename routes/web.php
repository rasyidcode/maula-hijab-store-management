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

Route::group(['prefix' => 'inventory'], function() {
    Route::get('/jenis/bahan', 'UI\DashboardController@listJenisBahan')->name("list_jenis_bahan");
    Route::get('/bahan', 'UI\DashboardController@listBahan')->name("list_bahan");
    Route::get('/induk', 'UI\DashboardController@induk')->name('induk');
    Route::get('/barang', 'UI\DashboardController@barang')->name('barang');
});

Route::group(['prefix' => 'produksi'], function() {
    Route::get('/wos', 'UI\DashboardController@wos')->name('wos');
    Route::get('/penjahit', 'UI\DashboardController@penjahit')->name('penjahit');
    Route::get('/pembayaran', 'UI\DashboardController@pembayaran')->name('pembayaran');
});