<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id('id');
            $table->integer('take')->default(1);
            $table->integer('total_points');
            $table->integer('total_correct');
            $table->integer('passing_score');
            $table->tinyInteger('passed')->comment = '1=Passed; 0=Failed';
            $table->foreignId('position_id');
            $table->string('shuffle')->comment = '1=Yes; 0=No';
            $table->string('type')->comment = '1=PMI; 2=Subcon';
            $table->foreignId('questionnaire_id');
            $table->string('employee_no');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('middlename')->nullable();
            $table->string('section');
            $table->string('agency');
            $table->integer('year');
            $table->string('immediate_superior');
            $table->date('date_hired');
            $table->json('summary');
            $table->integer('status')->comment = '1=Active; 2=Archived';
            $table->tinyInteger('logdel')->default(0);
            $table->timestamps();

            $table->foreign('position_id')->references('id')->on('positions');
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
        Schema::dropIfExists('exams');
    }
}
