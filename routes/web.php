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

Route::get('/persediaan/barang', function() {
    return view('pages.persediaan.barang');
});

Route::get('/persediaan/induk', function() {
    return view('pages.persediaan.induk');
});

Route::get('/persediaan/bahan', function() {
    return view('pages.persediaan.bahan');
});

Route::get('/penjahit', function() {
    return view('pages.penjahit');
});

Route::get('/wos', function() {
    return view('pages.wos');
});