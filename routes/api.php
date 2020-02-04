<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/jenis/bahan', 'API\DashboardController@getAllJenisBahan');
Route::get('/jenis/bahan/{kode}', 'API\DashboardController@getJenisBahan');
Route::post('/jenis/bahan', 'API\DashboardController@createJenisBahan');
Route::post('/jenis/bahan/{kode}/edit', 'API\DashboardController@updateJenisBahan');
Route::post('/jenis/bahan/{kode}/delete', 'API\DashboardController@deleteJenisBahan');
Route::get('/jenis/bahan/{kode}/completed', 'API\DashboardController@getJenisBahanCompleted');

Route::get('/bahan', 'API\DashboardController@get_all_bahan');
Route::get('/bahan/{id}', 'API\DashboardController@get_bahan');
Route::post('/bahan', 'API\DashboardController@create_bahan');
Route::post('/bahan/{id}/edit', 'API\DashboardController@update_bahan');
Route::post('/bahan/{id}/hapus', 'API\DashboardController@delete_bahan');

Route::get('/induk', 'API\DashboardController@get_all_induk');
Route::get('/induk/{id}', 'API\DashboardController@get_induk');
Route::post('/induk', 'API\DashboardController@create_induk');
Route::post('/induk/{id}/edit', 'API\DashboardController@update_induk');
Route::post('/induk/{id}/hapus', 'API\DashboardController@delete_induk');

Route::get('/barang', 'API\DashboardController@get_all_barang');
Route::get('/barang/completed', 'API\DashboardController@get_all_barang_detailed');
Route::get('/barang/{id}', 'API\DashboardController@get_barang');
Route::get('/barang/{id}/completed', 'API\DashboardController@get_barang_detailed');
Route::post('/barang', 'API\DashboardController@create_barang');
Route::post('/barang/{id}/edit', 'API\DashboardController@update_barang');
Route::post('/barang/{id}/hapus', 'API\DashboardController@delete_barang');

Route::get('/penjahit', 'API\DashboardController@getAllPenjahit');
Route::get('/penjahit/wos', 'API\DashboardController@getAllPenjahitWithWos');
Route::get('/penjahit/{nomor_hp}', 'API\DashboardController@getPenjahit');
Route::get('/penjahit/{nomor_hp}/wos', 'API\DashboardController@getAllWosByPenjahit');
Route::post('/penjahit', 'API\DashboardController@createPenjahit');
Route::post('/penjahit/{nomor_hp}/edit', 'API\DashboardController@updatePenjahit');
Route::post('/penjahit/{nomor_hp}/hapus', 'API\DashboardController@deletePenjahit');