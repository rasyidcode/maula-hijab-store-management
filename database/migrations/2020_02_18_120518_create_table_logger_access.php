<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLoggerAccess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logger_access', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('route_type', ['web', 'api']);
            $table->string('path');
            $table->string('method');
            $table->string('ip_address');
            $table->string('payload');
            $table->integer('status_code');
            $table->text('user_info');
            $table->text('header_info');
            $table->date('log_date');
            $table->time('log_time');
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
        Schema::dropIfExists('logger_access');
    }
}
