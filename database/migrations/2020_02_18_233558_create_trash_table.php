<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrashTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trash', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('content');
            $table->string('model');
            $table->string('method');
            $table->string('class');
            $table->integer('line_number');
            $table->string('namespace');
            $table->string('file');
            $table->string('dir');
            $table->date('deleted_date');
            $table->time('deleted_time');
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
        Schema::dropIfExists('trash');
    }
}
