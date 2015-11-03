<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobAndFileTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->dateTime('date')->nullable();
            $table->integer('location_id')->unsigned();
            $table->foreign('location_id')
                ->references('id')->on('country_state_towns')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('additional_description')->nullable();
            $table->text('special_request')->nullable();
            $table->string('existing_budget')->nullable();
            $table->tinyInteger('existing_lsp')->default(0);
            $table->integer('contract_term')->nullable();
            $table->dateTime('close_date')->nullable();
            $table->dateTime('announcement_date')->nullable();
            $table->dateTime('outsource_start_date')->nullable();
            $table->string('award_to')->nullable();
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')
                ->references('id')->on('rfi_status')
                ->onUpdate('cascade');
            $table->text('keyword')->nullable();
            $table->tinyInteger('delete')->default(0);
            $table->integer('created_by');
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });
        DB::table('jobs')->insert(
            array(
                'company_id' => 1,
                'location_id' => 1,
                'existing_lsp' => 0,
                'status_id' => 4,
                'created_by' => 1,
                'created_at' => DB::raw('CURRENT_TIMESTAMP')
            )
        );

        Schema::create('job_files', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('job_id')->unsigned();
            $table->foreign('job_id')
                ->references('id')->on('jobs')
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

        Schema::create('job_requirement', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('job_id')->unsigned()->index();
            $table->foreign('job_id')
                ->references('id')->on('jobs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('requirement_id')->unsigned()->index();
            $table->foreign('requirement_id')
                ->references('id')->on('requirements')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('status')->nullable()->default('Active');
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->timestamps();
        });
        DB::table('job_requirement')->insert(
            array(
                'job_id' => 1,
                'requirement_id' => 1,
                'created_by' => 1
            )
        );

        Schema::create('job_potential', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('job_id')->unsigned()->index();
            $table->foreign('job_id')
                ->references('id')->on('jobs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('potential_id')->unsigned()->index();
            $table->foreign('potential_id')
                ->references('id')->on('potentials')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('status')->nullable()->default('Active');
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->timestamps();
        });
        DB::table('job_potential')->insert(
            array(
                'job_id' => 1,
                'potential_id' => 1,
                'created_by' => 1
            )
        );

        Schema::create('job_highlight', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('job_id')->unsigned()->index();
            $table->foreign('job_id')
                ->references('id')->on('jobs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('highlight_id')->unsigned()->index();
            $table->foreign('highlight_id')
                ->references('id')->on('highlights')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('status')->nullable()->default('Active');
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->timestamps();
        });
        DB::table('job_highlight')->insert(
            array(
                'job_id' => 1,
                'highlight_id' => 1,
                'created_by' => 1
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
        Schema::drop('job_highlight');
        Schema::drop('job_potential');
        Schema::drop('job_requirement');
        Schema::drop('job_files');
        Schema::drop('jobs');
    }
}