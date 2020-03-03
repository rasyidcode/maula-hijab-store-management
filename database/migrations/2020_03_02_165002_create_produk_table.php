<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sku_induk')->nullable();
            $table->text('nama_produk')->nullable();
            $table->string('no_referensi_sku')->nullable();
            $table->string('warna')->nullable();
            $table->bigInteger('harga_asli')->nullable();
            $table->bigInteger('harga_setelah_diskon')->nullable();
            $table->integer('jumlah_pesanan')->nullable();
            $table->bigInteger('total_harga_produk')->nullable();
            $table->bigInteger('total_diskon')->nullable();
            $table->bigInteger('id_pemesanan')->unsigned();
            $table->timestamps();

            $table->foreign('id_pemesanan')->references('id')->on('pemesanan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produk');
    }
}
