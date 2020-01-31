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
            $table->string('kode')->primary(); // gabungan antara NAMA_PENJAHIT + TANGGAL_KEMBALI
            $table->string('kode_barang');
            $table->bigInteger('yard');
            $table->bigInteger('pcs');
            $table->timestamp('tanggal_diambil')->nullable();
            $table->timestamp('tanggal_kembali')->nullable();
            $table->enum('status_barang', ['on_going', 'sebagian', 'selesai']);
            $table->boolean('status_bayar');
            $table->bigInteger('jumlah_kembali');
            $table->text('keterangan');
            $table->string('nomor_hp_penjahit');
            $table->timestamps();

            $table->foreign('nomor_hp_penjahit')->references('nomor_hp')->on('penjahit');
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
