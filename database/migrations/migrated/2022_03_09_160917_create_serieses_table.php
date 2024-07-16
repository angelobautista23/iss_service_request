<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeriesesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serieses', function (Blueprint $table) {
            $table->id('id');
            $table->string('description');
            $table->integer('status')->comment = '1=Active; 2=Archived';
            $table->foreignId('created_by');
            $table->foreignId('last_updated_by');
            $table->tinyInteger('logdel')->default(0);
            $table->timestamps();
            
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('last_updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('serieses');
    }
}
