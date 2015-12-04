<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('sender')->unsigned()->nullable();
            $table->foreign('sender')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('receiver')->unsigned()->nullable();
            $table->foreign('receiver')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('subject')->nullable();
            $table->text('description');
            $table->enum('message_type', array('Initiate', 'Reply'));
            $table->tinyInteger('is_read')->default(0);
            $table->string('status')->nullable();
            $table->integer('created_by');
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });

        Schema::create('reply_messages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('reply_message_id')->unsigned();
            $table->foreign('reply_message_id')
                ->references('id')->on('messages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('reply_to')->unsigned();
            $table->foreign('reply_to')
                ->references('id')->on('messages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('status')->nullable();
            $table->integer('created_by');
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });

        Schema::create('appointment_request', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('sender')->unsigned()->nullable();
            $table->foreign('sender')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('receiver')->unsigned()->nullable();
            $table->foreign('receiver')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('no_of_pic');
            $table->integer('objective_id')->unsigned();
            $table->foreign('objective_id')
                ->references('id')->on('appointment_objectives')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('description')->nullable();
            $table->text('location');
            $table->dateTime('date_time');
            $table->enum('status', array('Confirmed', 'Unconfirmed'));
            $table->integer('created_by');
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });

        Schema::create('appointment_response', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('appointment_request_id')->unsigned();
            $table->foreign('appointment_request_id')
                ->references('id')->on('appointment_request')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('description')->nullable();
            $table->enum('response_action', array('Accept', 'Reject', 'Request to modify'));
            $table->integer('created_by');
            $table->integer('modified_by')->nullable();
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
        Schema::drop('appointment_response');
        Schema::drop('appointment_request');
        Schema::drop('reply_messages');
        Schema::drop('messages');
    }
}