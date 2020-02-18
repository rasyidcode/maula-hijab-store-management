<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLoggerCrud extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logger_crud', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('model'); // model bersangkutan
            $table->string('method'); // method bersangkutan
            $table->string('class');
            $table->string('line_number');
            $table->string('file');
            $table->string('dir');
            $table->string('namespace');
            $table->enum('operation', ['create', 'update', 'get', 'delete']); // operasi yang dilakukan
            $table->longText('content'); // konten yang ditambahkan, diupdate, didapatkan atau dihapus
            $table->text('desc'); // (optional) deskripsi jika perlu
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
        Schema::dropIfExists('logger_crud');
    }
}
