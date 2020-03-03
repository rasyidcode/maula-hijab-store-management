<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemesananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('metode_pemesanan', ['shopee', 'lazada', 'tokopedia', 'manual']);
            $table->string('no_pemesanan')->nullable();
            $table->enum('status_pemesanan', ['perlu_dikirim', 'refund'])->nullable();
            $table->string('no_resi')->nullable();
            $table->string('shipping_provider')->nullable();
            $table->string('status_pickup')->nullable(); // ke_counter, pickup
            $table->timestamp('batas_pengiriman')->nullable();
            $table->timestamp('waktu_pesanan_dibuat')->nullable();
            $table->timestamp('waktu_pembayaran_dilakukan')->nullable();
            $table->bigInteger('ongkos_kirim_dibayar_pembeli')->nullable();
            $table->bigInteger('total_pembayaran')->nullable();
            $table->bigInteger('perkiraan_ongkos_kirim')->nullable();

            $table->string('username')->nullable();
            $table->string('nama_penerima')->nullable();
            $table->string('email')->nullable();
            $table->string('no_hp')->nullable();
            $table->text('alamat_pengiriman')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('provinsi')->nullable();
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
        Schema::dropIfExists('pemesanan');
    }
}
