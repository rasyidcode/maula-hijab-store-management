<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wos', function (Blueprint $table) {
            $table->bigIncrements('id'); // gabungan antara NAMA_PENJAHIT + TANGGAL_KEMBALI
            $table->string('kode_barang');
            $table->bigInteger('yard');
            $table->bigInteger('pcs');
            $table->timestamp('tanggal_diambil')->nullable();
            $table->timestamp('tanggal_kembali')->nullable();
            $table->bigInteger('jumlah_kembali');
            $table->boolean('status_bayar')->default(0); // false = belum bayar, true = sudah bayar
            $table->timestamp('tanggal_bayar')->nullable();
            $table->string('no_ktp_penjahit');
            $table->timestamps();

            $table->foreign('no_ktp_penjahit')->references('no_ktp')->on('penjahit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wos');
    }
}
