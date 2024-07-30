<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('cc')->nullable();
            $table->string('subject');
            $table->text('request');
            $table->bigInteger('requestor');
            $table->bigInteger('department_id');
            $table->bigInteger('assignee')->nullable();
            $table->bigInteger('second_assignee')->nullable();
            $table->bigInteger('assigned_by')->nullable();
            $table->bigInteger('reassigned_by')->nullable();
            $table->string('attachments')->nullable();
            $table->foreignId('service_type_id')->nullable();
            $table->text('remarks')->nullable();
            $table->double('trt')->nullable();
            $table->dateTime('assigned_at')->nullable();
            $table->dateTime('reassigned_at')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->tinyInteger('status')->comment = '1=Unassigned; 2=In Progress; 3=For Verification; 4=Confirmed; 5=Cancelled';
            $table->dateTime('for_verification_at')->nullable();
            $table->bigInteger('for_verification_by')->nullable();
            $table->dateTime('confirmed_at')->nullable();
            $table->bigInteger('confirmed_by')->nullable();
            $table->bigInteger('created_by');
            $table->bigInteger('last_updated_by');
            $table->tinyInteger('logdel')->default(0);
            $table->timestamps();

            $table->foreign('service_type_id')->references('id')->on('service_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
