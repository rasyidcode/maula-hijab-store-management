<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBahanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bahan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_jenis_bahan');
            $table->bigInteger('yard');
            $table->bigInteger('harga');
            $table->timestamp('tanggal_masuk');
            $table->bigInteger('value');
            $table->boolean('status_potong')->default(0); // false => ready, true => sudah dipotong
            $table->timestamps();

            $table->foreign('kode_jenis_bahan')->references('kode')->on('jenis_bahan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bahan');
    }
}
