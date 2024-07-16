<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDlaCheckItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dla_check_items', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('monitoring_id');
            $table->tinyInteger('value')->comment = '1=Yes; 0=No';
            $table->string('index');
            $table->integer('date_index');
            $table->date('date');
            $table->integer('status')->comment = '1=Active; 2=Archived';
            $table->bigInteger('created_by');
            $table->bigInteger('last_updated_by');
            $table->tinyInteger('logdel')->default(0);
            $table->timestamps();

            // Foreign Key
            $table->foreign('monitoring_id')->references('id')->on('monitorings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dla_check_items');
    }
}
