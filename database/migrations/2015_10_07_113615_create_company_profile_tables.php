<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyProfileTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_billing_info', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('company_id')->unsigned()->index();;
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('payment_term')->nullable();
            $table->string('taxable')->nullable();
            $table->string('package_type')->nullable();
            $table->string('status')->nullable();
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->timestamps();
        });

        Schema::create('company_achievement', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('company_id')->unsigned()->index();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('category_id')->unsigned()->index();
            $table->foreign('category_id')
                ->references('id')->on('achievements')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('descriptions')->nullable();
            $table->string('status')->nullable();
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->timestamps();
        });

        Schema::create('company_remarks', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('remarks')->nullable();
            $table->string('status')->nullable();
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->timestamps();
        });

        Schema::create('company_potential', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('company_id')->unsigned()->index();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('potential_id')->unsigned()->index();
            $table->foreign('potential_id')
                ->references('id')->on('potentials')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('status')->nullable();
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->timestamps();
        });

        Schema::create('company_requirement', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('company_id')->unsigned()->index();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('requirement_id')->unsigned()->index();
            $table->foreign('requirement_id')
                ->references('id')->on('requirements')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('status')->nullable();
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->timestamps();
        });

        Schema::create('company_industry', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('company_id')->unsigned()->index();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('industry_id')->unsigned()->index();
            $table->foreign('industry_id')
                ->references('id')->on('industries')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('status')->nullable();
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->timestamps();
        });

        Schema::create('company_features', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('company_id')->unsigned()->index();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('feature')->nullable();
            $table->text('details')->nullable();
            $table->string('status')->nullable();
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->timestamps();
        });

        Schema::create('company_logistic', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('company_id')->unsigned()->index();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('logistic_id')->unsigned()->index();
            $table->foreign('logistic_id')
                ->references('id')->on('logistics')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('status')->nullable();
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->timestamps();
        });

        Schema::create('company_service', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('company_id')->unsigned()->index();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('service_id')->unsigned()->index();
            $table->foreign('service_id')
                ->references('id')->on('services')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('status')->nullable();
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
            $table->timestamps();
        });

        DB::table('company_requirement')->insert(
            array(
                'company_id' => 2,
                'requirement_id' => 1,
                'status' => 'Active',
                'created_by' => 1,
                'created_at' => DB::raw('CURRENT_TIMESTAMP')
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
        Schema::drop('company_billing_info');
        Schema::drop('company_achievement');
        Schema::drop('company_logistic');
        Schema::drop('company_service');
        Schema::drop('company_remarks');
        Schema::drop('company_potential');
        Schema::drop('company_requirement');
        Schema::drop('company_industry');
        Schema::drop('company_features');
    }
}