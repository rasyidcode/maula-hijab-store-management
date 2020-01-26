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