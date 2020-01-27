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
Route::get('/barang/{id}', 'API\DashboardController@get_barang');
Route::post('/barang', 'API\DashboardController@create_barang');
Route::post('/barang/{id}/edit', 'API\DashboardController@update_barang');
Route::post('/barang/{id}/hapus', 'API\DashboardController@delete_barang');