<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBidAndFileTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bids', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('job_id')->unsigned();
            $table->foreign('job_id')
                ->references('id')->on('jobs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->dateTime('date')->nullable();
            $table->double('est_budget')->nullable();
            $table->text('additional_description')->nullable();
            $table->text('reply_to_special_request')->nullable();
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')
                ->references('id')->on('rfi_status')
                ->onUpdate('cascade');
            $table->string('sales_pic')->nullable();
            $table->dateTime('rfp_submission_date')->nullable();
            $table->dateTime('rfq_submission_date')->nullable();
            $table->dateTime('first_meeting_target_date')->nullable();
            $table->dateTime('closure_target_date')->nullable();
            $table->tinyInteger('delete')->default(0);
            $table->integer('created_by');
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });

        Schema::create('bid_files', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('bid_id')->unsigned();
            $table->foreign('bid_id')
                ->references('id')->on('bids')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('file_type_id')->unsigned();
            $table->foreign('file_type_id')
                ->references('id')->on('file_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('file_name')->nullable();
            $table->string('link_path', 255)->nullable();
            $table->string('status')->nullable();
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
        Schema::drop('bid_files');
        Schema::drop('bids');
    }
}
