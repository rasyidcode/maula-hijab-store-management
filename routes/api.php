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

Route::group(['prefix' => '/jenis_bahan'], function() {
    Route::get('/', 'API\JenisBahanController@index');
    Route::get('/all/completed', 'API\JenisBahanController@getAllWithBahan');
    Route::get('/{kode}', 'API\JenisBahanController@get');
    Route::post('/', 'API\JenisBahanController@create');
    Route::post('/{kode}/edit', 'API\JenisBahanController@update');
    Route::post('/{kode}/delete', 'API\JenisBahanController@delete');
    Route::get('/{kode}/completed', 'API\JenisBahanController@getOneWithBahan');
    Route::get('/get/nama', 'API\JenisBahanController@getListNamaBahan');
    Route::get('/get/warna', 'API\JenisBahanController@getListWarnaBahan');
});

Route::get('/bahan', 'API\BahanController@get_all_bahan');
Route::post('/bahan/new', 'API\BahanController@getAllBahan');
Route::get('/bahan/{id}', 'API\BahanController@get_bahan');
Route::post('/bahan', 'API\BahanController@create_bahan');
Route::post('/bahan/{id}/edit', 'API\BahanController@update_bahan');
Route::post('/bahan/{id}/delete', 'API\BahanController@delete_bahan');
Route::post('/bahan/{id}/status', 'API\BahanController@ganti_status_potong');
Route::get('/bahan/get/yard', 'API\BahanController@getOnlyYard');
Route::get('/bahan/{id}/check/status_potong', 'API\BahanController@checkStatusPotong');
Route::get('/bahan/check/ready', 'API\BahanController@checkBahanReady');

Route::get('/induk', 'API\DashboardController@getAllInduk');
Route::get('/induk/{id}', 'API\DashboardController@get_induk');
Route::post('/induk', 'API\DashboardController@create_induk');
Route::post('/induk/{id}/edit', 'API\DashboardController@update_induk');
Route::post('/induk/{id}/delete', 'API\DashboardController@delete_induk');

Route::get('/barang', 'API\BarangController@get_all_barang');
Route::get('/barang/{id}', 'API\BarangController@get_barang');
Route::post('/barang', 'API\BarangController@create_barang');
Route::post('/barang/{id}/edit', 'API\BarangController@update_barang');
Route::post('/barang/{id}/delete', 'API\BarangController@delete_barang');
// Route::get('/barang/completed', 'API\BarangController@get_all_barang_detailed');
// Route::get('/barang/{id}/completed', 'API\BarangController@get_barang_detailed');
Route::get('/barang/with/on_progress', 'API\BarangController@getAllBarangWithOnProgress');

Route::get('/penjahit', 'API\DashboardController@getAllPenjahit');
Route::get('/penjahit/{nomor_hp}', 'API\DashboardController@getPenjahit');
Route::post('/penjahit', 'API\DashboardController@createPenjahit');
Route::post('/penjahit/{nomor_hp}/edit', 'API\DashboardController@updatePenjahit');
Route::post('/penjahit/{nomor_hp}/delete', 'API\DashboardController@deletePenjahit');
// Route::get('/penjahit/wos', 'API\DashboardController@getAllPenjahitWithWos');
// Route::get('/penjahit/{nomor_hp}/wos', 'API\DashboardController@getAllWosByPenjahit');

Route::get('/wos', 'API\WosController@getAllWos');
Route::get('/wos/completed', 'API\WosController@getAllWosCompleted');
Route::get('/wos/{id}', 'API\WosController@getWos');
Route::post('/wos', 'API\WosController@createWos');
Route::post('/wos/{id}/edit', 'API\WosController@updateWos');
Route::post('/wos/{id}/delete', 'API\WosController@deleteWos');
// untuk ambil 1 jahitan
Route::post('/wos/{id}/take', 'API\WosController@takeWos');
// untuk setor 1 jahitan
Route::post('/wos/{id}/setor', 'API\WosController@setorWos');
// untuk ambil beberapa jahitan
Route::post('/wos/take/multi', 'API\WosController@takeMultiWos');
// untuk setor beberapa jahitan
Route::post('/wos/setor/multi', 'API\WosController@setorMultiWos');
Route::get('/wos/{kode_barang}/on_progress', 'API\WosController@getOnProgress');
