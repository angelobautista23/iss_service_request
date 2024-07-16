<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id('id');
            $table->integer('no');
            $table->foreignId('questionnaire_id');
            $table->string('description');
            $table->integer('section')->default(1);
            $table->string('image')->nullable();
            $table->json('choices');
            $table->integer('points')->default(1);
            $table->integer('answer')->default(1);
            $table->integer('status')->comment = '1=Active; 2=Archived';
            $table->bigInteger('created_by');
            $table->bigInteger('last_updated_by');
            $table->tinyInteger('logdel')->default(0);
            $table->timestamps();

            $table->foreign('questionnaire_id')->references('id')->on('questionnaires');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
