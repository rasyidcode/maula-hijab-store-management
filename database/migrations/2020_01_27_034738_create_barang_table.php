<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->string('kode')->primary();
            $table->string('kode_induk');
            $table->string('warna');
            $table->bigInteger('stok');
            $table->bigInteger('treshold');
            $table->bigInteger('id_bahan')->unsigned();
            $table->timestamps();

            $table->foreign('kode_induk')->references('kode')->on('induk');
            $table->foreign('id_bahan')->references('id')->on('bahan');
        });
    }

    /**
     * Reverse the migrations.`
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang');
    }
}
