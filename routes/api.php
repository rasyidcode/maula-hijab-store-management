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
    
    /* jenis_bahan */
    Route::group(['prefix' => 'jenis_bahan'], function() {
        Route::get('/', 'API\JenisBahanController@index'); // done_check
        Route::get('/all/completed', 'API\JenisBahanController@getAllWithBahan'); // done_check
        Route::get('/{kode}', 'API\JenisBahanController@get'); // done_check
        Route::post('/', 'API\JenisBahanController@create'); // done_check
        Route::post('/{kode}/edit', 'API\JenisBahanController@edit'); // done_check
        Route::post('/{kode}/delete', 'API\JenisBahanController@remove'); // done_check
        Route::get('/{kode}/completed', 'API\JenisBahanController@getOneWithBahan'); // done_check
        Route::get('/get/nama', 'API\JenisBahanController@getListNamaBahan'); // done_check
        Route::get('/get/warna', 'API\JenisBahanController@getListWarnaBahan'); // done_check
    });
    
    /* bahan */
    Route::group(['prefix' => 'bahan'], function() {
        Route::get('/', 'API\BahanController@index'); // done_check
        // Route::post('/new', 'API\BahanController@getAllBahan');
        Route::get('/{id}', 'API\BahanController@get'); // done_check
        Route::post('/', 'API\BahanController@create'); // done_check
        Route::post('/{id}/edit', 'API\BahanController@edit'); // done_check
        Route::post('/{id}/remove', 'API\BahanController@remove');
        Route::post('/{id}/status', 'API\BahanController@setStatusPotong');
        Route::get('/get/yard', 'API\BahanController@getOnlyYard');
        Route::get('/{id}/check/status_potong', 'API\BahanController@checkStatusPotong');
        Route::get('/check/ready', 'API\BahanController@checkBahanReady');
    });

    /* induk */
    Route::group(['prefix' => 'induk'], function() {
        Route::get('/', 'API\DashboardController@getAllInduk');
        Route::get('/{id}', 'API\DashboardController@get_induk');
        Route::post('/', 'API\DashboardController@create_induk');
        Route::post('/{id}/edit', 'API\DashboardController@update_induk');
        Route::post('/{id}/delete', 'API\DashboardController@delete_induk');
    });

    /* barang */
    Route::group(['prefix' => 'barang'], function() {
        Route::get('/', 'API\BarangController@get_all_barang');
        Route::get('/{id}', 'API\BarangController@get_barang');
        Route::post('/', 'API\BarangController@create_barang');
        Route::post('/{id}/edit', 'API\BarangController@update_barang');
        Route::post('/{id}/delete', 'API\BarangController@delete_barang');
        // Route::get('/barang/completed', 'API\BarangController@get_all_barang_detailed');
        // Route::get('/barang/{id}/completed', 'API\BarangController@get_barang_detailed');
        Route::get('/with/on_progress', 'API\BarangController@getAllBarangWithOnProgress');
    });

    /* penjahit */
    Route::group(['prefix' => 'penjahit'], function() {
        Route::get('/', 'API\PenjahitController@getAllPenjahit');
        Route::get('/{nomor_hp}', 'API\PenjahitController@getPenjahit');
        Route::post('/', 'API\PenjahitController@createPenjahit');
        Route::post('/{nomor_hp}/edit', 'API\PenjahitController@updatePenjahit');
        Route::post('/{nomor_hp}/delete', 'API\PenjahitController@deletePenjahit');
        // Route::get('/penjahit/wos', 'API\DashboardController@getAllPenjahitWithWos');
        // Route::get('/penjahit/{nomor_hp}/wos', 'API\DashboardController@getAllWosByPenjahit');
    });

    /* wos */
    Route::group(['prefix' => 'wos'], function() {
        Route::get('/', 'API\WosController@getAllWos');
        Route::get('/completed', 'API\WosController@getAllWosCompleted');
        Route::get('/{id}', 'API\WosController@getWos');
        Route::post('/', 'API\WosController@createWos');
        Route::post('/{id}/edit', 'API\WosController@updateWos');
        Route::post('/{id}/delete', 'API\WosController@deleteWos');
        Route::post('/{id}/take', 'API\WosController@takeWos');
        Route::post('/{id}/setor', 'API\WosController@setorWos');
        Route::post('/wos/take/multi', 'API\WosController@takeMultiWos'); // `belum dipake`
        Route::post('/setor/multi', 'API\WosController@setorMultiWos'); // `belum dipake`
        Route::get('/{kode_barang}/on_progress', 'API\WosController@getOnProgress');
    });

    /* pembayaran */
    Route::group(['prefix' => 'pembayaran'], function() {
        Route::get('/', 'API\PembayaranController@index');
        Route::get('/{id}', 'API\PembayaranController@get');
        Route::post('/', 'API\PembayaranController@create');
        Route::post('/{id}/edit', 'API\PembayaranController@update');
        Route::post('/{id}/delete', 'API\PembayaranController@delete');
    });
});
