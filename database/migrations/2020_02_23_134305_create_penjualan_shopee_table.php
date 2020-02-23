<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanShopeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan_shopee', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_resi')->nullable();
            $table->string('no_pesanan')->nullable();
            $table->string('status_pesanan')->nullable();
            $table->string('status_retur')->nullable();
            $table->string('username')->nullable();
            $table->timestamp('waktu_pesanan_dibuat')->nullable();
            $table->timestamp('waktu_pesanan_dikirim')->nullable();
            $table->text('nama_produk')->nullable();
            $table->string('warna')->nullable();
            $table->bigInteger('harga')->nullable();
            $table->integer('kuantitas')->nullable();
            $table->string('referensi_sku')->nullable();
            $table->string('sku_induk')->nullable();
            $table->string('opsi_pengiriman')->nullable();
            $table->string('nama_penerima')->nullable();
            $table->string('nomor_hp')->nullable();
            $table->string('alamat_pengiriman')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kode_pos')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualan_shopee');
    }
}
