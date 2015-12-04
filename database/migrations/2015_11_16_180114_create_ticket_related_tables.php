<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketRelatedTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('status');
            $table->integer('created_by');
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });

        DB::table('ticket_categories')->insert(
            array(
                'name' => 'Category 1',
                'status' => 'Active',
                'created_by' => 1,
                'created_at' => DB::raw('CURRENT_TIMESTAMP'),
                'updated_at' => DB::raw('CURRENT_TIMESTAMP')
            )
        );

        DB::table('ticket_categories')->insert(
            array(
                'name' => 'Category 2',
                'status' => 'Active',
                'created_by' => 1,
                'created_at' => DB::raw('CURRENT_TIMESTAMP'),
                'updated_at' => DB::raw('CURRENT_TIMESTAMP')
            )
        );

        DB::table('ticket_categories')->insert(
            array(
                'name' => 'Category 3',
                'status' => 'Active',
                'created_by' => 1,
                'created_at' => DB::raw('CURRENT_TIMESTAMP'),
                'updated_at' => DB::raw('CURRENT_TIMESTAMP')
            )
        );

        Schema::create('tickets', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('company_id')->unsigned()->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')
                ->references('id')->on('ticket_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('issue_subject');
            $table->text('issue_description');
            $table->enum('status', array('open', 'close'));
            $table->tinyInteger('is_attended')->default(0);
            $table->integer('created_by');
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });

        Schema::create('ticket_files', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('ticket_id')->unsigned();
            $table->foreign('ticket_id')
                ->references('id')->on('tickets')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('file_name');
            $table->string('file_path');
            $table->integer('created_by');
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });

        Schema::create('ticket_responses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('ticket_id')->unsigned();
            $table->foreign('ticket_id')
                ->references('id')->on('tickets')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('reply_description');
            $table->integer('created_by');
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });

        Schema::create('ticket_response_files', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('ticket_response_id')->unsigned();
            $table->foreign('ticket_response_id')
                ->references('id')->on('ticket_responses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('file_name');
            $table->string('file_path');
            $table->integer('created_by');
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });

        Schema::create('ticket_admin_email', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('email');
            $table->integer('created_by');
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });

        DB::table('ticket_admin_email')->insert(
            array(
                'email' => 'bid@bid.com',
                'created_by' => 1,
                'created_at' => DB::raw('CURRENT_TIMESTAMP'),
                'updated_at' => DB::raw('CURRENT_TIMESTAMP')
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ticket_admin_email');
        Schema::drop('ticket_response_files');
        Schema::drop('ticket_responses');
        Schema::drop('ticket_files');
        Schema::drop('tickets');
        Schema::drop('ticket_categories');
    }
}