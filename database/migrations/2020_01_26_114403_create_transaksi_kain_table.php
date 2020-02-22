<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiKainTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_kain', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_kain');
            $table->bigInteger('yard');
            $table->bigInteger('harga');
            $table->timestamp('tanggal_masuk');
            $table->bigInteger('value');
            $table->boolean('status_potong')->default(0); // false => ready, true => sudah dipotong
            $table->timestamps();

            $table->foreign('kode_kain')->references('kode')->on('kain');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_kain');
    }
}
