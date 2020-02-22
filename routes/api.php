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

Route::group(['prefix' => 'v1'], function() {
    
    /* kain */
    Route::group(['prefix' => 'kain'], function() {
        Route::get('/', 'API\KainController@index'); // worked
        Route::get('/{kode}', 'API\KainController@get'); // worked
        Route::post('/', 'API\KainController@create'); // worked
        Route::post('/{kode}/edit', 'API\KainController@edit'); // worked
        Route::post('/{kode}/remove', 'API\KainController@remove'); // worked
        Route::get('/with/relations', 'API\KainController@allWithRelations');  // worked
        Route::get('/{kode}/with/relations', 'API\KainController@oneWithRelations');  // worked
        Route::get('/get/nama', 'API\KainController@listNamaKain'); // worked
        Route::get('/get/warna', 'API\KainController@listWarnaKain'); // worked
    });
    
    /* transaksi_kain */
    Route::group(['prefix' => 'transaksi_kain'], function() {
        Route::get('/', 'API\TransaksiKainController@index'); // worked
        // Route::post('/new', 'API\BahanController@getAllBahan');
        Route::get('/{id}', 'API\TransaksiKainController@get'); // worked
        Route::post('/', 'API\TransaksiKainController@create'); // worked
        Route::post('/{id}/edit', 'API\TransaksiKainController@edit'); // worked
        Route::post('/{id}/remove', 'API\TransaksiKainController@remove'); // worked
        Route::post('/{id}/status', 'API\TransaksiKainController@setStatusPotong'); //worked
        Route::get('/get/yard', 'API\TransaksiKainController@getOnlyYard'); //worked
        Route::get('/{id}/check/status_potong', 'API\TransaksiKainController@checkStatusPotong'); //worked
        Route::get('/check/ready', 'API\TransaksiKainController@checkTransaksiKainReady'); //worked
    });

    /* induk */
    Route::group(['prefix' => 'induk'], function() {
        Route::get('/', 'API\IndukController@index'); // worked
        Route::get('/{id}', 'API\IndukController@get'); // worked
        Route::post('/', 'API\IndukController@create'); // worked
        Route::post('/{id}/edit', 'API\IndukController@edit'); // worked
        Route::post('/{id}/remove', 'API\IndukController@remove'); // worked
    });

    /* barang */
    Route::group(['prefix' => 'barang'], function() {
        Route::get('/', 'API\BarangController@index'); // worked
        Route::get('/{kode}', 'API\BarangController@get'); // worked
        Route::post('/', 'API\BarangController@create'); // worked
        Route::post('/{kode}/edit', 'API\BarangController@edit'); // worked
        Route::post('/{kode}/remove', 'API\BarangController@remove'); // worked
        Route::get('/with/relations', 'API\BarangController@allWithRelations'); // worked
        Route::get('/{kode}/with/relations', 'API\BarangController@oneWithRelations'); // worked
        Route::get('/with/ready_on_progress', 'API\BarangController@allWithReadyAndProgress'); // pending_check (need wos)
        Route::get('/{kode}/with/ready_on_progress', 'API\BarangController@oneWithReadyAndProgress'); // pending_check (need wos)
    });

    /* penjahit */
    Route::group(['prefix' => 'penjahit'], function() {
        Route::get('/', 'API\PenjahitController@index'); // worked
        Route::get('/{no_ktp}', 'API\PenjahitController@get'); // worked
        Route::post('/', 'API\PenjahitController@create'); // worked
        Route::post('/{no_ktp}/edit', 'API\PenjahitController@edit'); // worked
        Route::post('/{no_ktp}/remove', 'API\PenjahitController@remove'); // worked
        Route::get('/with/wos', 'API\PenjahitController@allWithWos'); // pending_check (need wos)
        Route::get('/{no_ktp}/wos', 'API\PenjahitController@oneWithWos'); // pending_check (need wos)
    });

    /* wos */
    Route::group(['prefix' => 'wos'], function() {
        Route::get('/', 'API\WosController@all'); // worked
        Route::get('/{id}', 'API\WosController@get'); // worked
        Route::post('/', 'API\WosController@create'); // worked
        Route::post('/{id}/edit', 'API\WosController@edit'); // worked
        Route::post('/{id}/remove', 'API\WosController@remove'); // done_check
        Route::post('/{id}/take', 'API\WosController@take'); // worked
        Route::post('/{id}/return', 'API\WosController@return'); // worked
        Route::get('/with/relations', 'API\WosController@allWithRelations'); // worked
        Route::get('/{id}/with/relations', 'API\WosController@oneWithRelations'); // worked
        Route::post('/wos/take/multi', 'API\WosController@takeMulti'); // `belum dipake`
        Route::post('/setor/multi', 'API\WosController@setorMulti'); // `belum dipake`
        Route::get('/{kode_barang}/on_progress', 'API\WosController@getOnProgress'); // `belum dipake`
        Route::get('/payment/list', 'API\WosController@wosPayment'); // worked
        Route::post('/{id}/payment', 'API\WosController@pay'); // worked
    });

    /* penjualan */
    Route::group(['prefix' => 'penjualan'], function() {
        Route::post('/test', 'API\PenjualanController@test');
    });
});
