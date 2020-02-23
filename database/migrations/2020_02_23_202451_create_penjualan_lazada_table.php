<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanLazadaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan_lazada', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_item_id')->nullable();
            $table->string('order_type')->nullable();
            $table->string('order_flag')->nullable();
            $table->string('seller_sku')->nullable();
            $table->string('lazada_sku')->nullable();
            $table->timestamp('lazada_created_at')->nullable();
            $table->timestamp('lazada_updated_at')->nullable();
            $table->boolean('is_invoice_required')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('shipping_name')->nullable();
            $table->text('shipping_address')->nullable(); // combined address
            $table->string('no_hp')->nullable();
            $table->double('paid_price')->nullable();
            $table->double('unit_price')->nullable();
            $table->double('shipping_fee')->nullable();
            $table->text('product_name')->nullable();
            $table->string('color');
            $table->string('size');
            $table->string('shipping_provider')->nullable();
            $table->string('shipping_type')->nullable();
            $table->string('tracking_code')->nullable();
            $table->string('status')->nullable();
            $table->string('reason_return')->nullable();
            $table->double('refund_amount')->nullable();
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
        Schema::dropIfExists('penjualan_lazada');
    }
}
