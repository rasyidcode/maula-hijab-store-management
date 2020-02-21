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
        Route::post('/{id}/remove', 'API\BahanController@remove'); // done_check
        Route::post('/{id}/status', 'API\BahanController@setStatusPotong'); //done_check
        Route::get('/get/yard', 'API\BahanController@getOnlyYard'); //done_check
        Route::get('/{id}/check/status_potong', 'API\BahanController@checkStatusPotong'); //done_check
        Route::get('/check/ready', 'API\BahanController@checkBahanReady'); //done_check
    });

    /* induk */
    Route::group(['prefix' => 'induk'], function() {
        Route::get('/', 'API\IndukController@index'); // done_check
        Route::get('/{id}', 'API\IndukController@get'); // done_check
        Route::post('/', 'API\IndukController@create'); // done_check
        Route::post('/{id}/edit', 'API\IndukController@edit'); // done_check
        Route::post('/{id}/remove', 'API\IndukController@remove'); // done_check
    });

    /* barang */
    Route::group(['prefix' => 'barang'], function() {
        Route::get('/', 'API\BarangController@index'); // done_check
        Route::get('/{id}', 'API\BarangController@get'); // done_check
        Route::post('/', 'API\BarangController@create'); // done_check
        Route::post('/{id}/edit', 'API\BarangController@edit'); // done_check
        Route::post('/{id}/remove', 'API\BarangController@remove'); // done_check
        Route::get('/with/induk', 'API\BarangController@allWithInduk'); // done_check
        Route::get('/{id}/with/induk', 'API\BarangController@oneWithInduk'); // done_check
        Route::get('/with/on_progress', 'API\BarangController@allWithOnProgress'); // pending_check (need wos)
        Route::get('/{id}/with/on_progress', 'API\BarangController@oneWithOnProgress'); // pending_check (need wos)
    });

    /* penjahit */
    Route::group(['prefix' => 'penjahit'], function() {
        Route::get('/', 'API\PenjahitController@index'); // done_check
        Route::get('/{no_ktp}', 'API\PenjahitController@get'); // done_check
        Route::post('/', 'API\PenjahitController@create'); // done_check
        Route::post('/{no_ktp}/edit', 'API\PenjahitController@edit'); // done_check
        Route::post('/{no_ktp}/remove', 'API\PenjahitController@remove'); // done_check
        Route::get('/with/wos', 'API\PenjahitController@allWithWos'); // pending_check (need wos)
        Route::get('/{no_ktp}/wos', 'API\PenjahitController@oneWithWos'); // pending_check (need wos)
    });

    /* wos */
    Route::group(['prefix' => 'wos'], function() {
        Route::get('/', 'API\WosController@all'); // done_check
        Route::get('/with/relations', 'API\WosController@allWithRelations'); // done_check
        Route::get('/{id}', 'API\WosController@get'); // done_check
        Route::post('/', 'API\WosController@create'); // done_check
        Route::post('/{id}/edit', 'API\WosController@edit'); // done_check
        Route::post('/{id}/remove', 'API\WosController@remove'); // done_check
        Route::post('/{id}/take', 'API\WosController@take'); // done_check
        Route::post('/{id}/return', 'API\WosController@return'); // done_check
        Route::post('/wos/take/multi', 'API\WosController@takeMulti'); // `belum dipake`
        Route::post('/setor/multi', 'API\WosController@setorMulti'); // `belum dipake`
        Route::get('/{kode_barang}/on_progress', 'API\WosController@getOnProgress'); // `belum dipake`
        Route::get('/{id}/with/relations', 'API\WosController@oneWithRelations');
        Route::get('/to/pay', 'API\WosController@allWosToPay');
    });
});
