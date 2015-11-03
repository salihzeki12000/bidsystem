<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupportTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('industries', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('industry');
            $table->string('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });

        DB::table('industries')->insert(
            array(
                'industry' => 'Industry 1',
                'status' => 'Active'
            )
        );
        DB::table('industries')->insert(
            array(
                'industry' => 'Industry 2',
                'status' => 'Active'
            )
        );
        DB::table('industries')->insert(
            array(
                'industry' => 'Industry 3',
                'status' => 'Active'
            )
        );
        DB::table('industries')->insert(
            array(
                'industry' => 'Industry 4',
                'status' => 'Active'
            )
        );


        Schema::create('requirements', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('requirement');
            $table->string('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });

        DB::table('requirements')->insert(
            array(
                'requirement' => 'Insurance',
                'status' => 'Active'
            )
        );
        DB::table('requirements')->insert(
            array(
                'requirement' => 'Requirement',
                'status' => 'Active'
            )
        );

        Schema::create('highlights', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('highlight');
            $table->string('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });

        DB::table('highlights')->insert(
            array(
                'highlight' => 'highlight 1',
                'status' => 'Active'
            )
        );
        DB::table('highlights')->insert(
            array(
                'highlight' => 'highlight 2',
                'status' => 'Active'
            )
        );


        Schema::create('potentials', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('potential');
            $table->string('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });

        DB::table('potentials')->insert(
            array(
                'potential' => 'Potential 1',
                'status' => 'Active'
            )
        );
        DB::table('potentials')->insert(
            array(
                'potential' => 'Potential 2',
                'status' => 'Active'
            )
        );

        Schema::create('accesses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('access_type');
            $table->string('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });

        DB::table('accesses')->insert(
            array(
                'access_type' => 'User G1',
                'status' => 'Active'
            )
        );
        DB::table('accesses')->insert(
            array(
                'access_type' => 'User G2',
                'status' => 'Active'
            )
        );
        DB::table('accesses')->insert(
            array(
                'access_type' => 'Admin G1',
                'status' => 'Active'
            )
        );
        DB::table('accesses')->insert(
            array(
                'access_type' => 'Admin G2',
                'status' => 'Active'
            )
        );

        Schema::create('contacts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('contact_type');
            $table->string('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });
        DB::table('contacts')->insert(
            array(
                'contact_type' => 'Main',
                'status' => 'Active'
            )
        );
        DB::table('contacts')->insert(
            array(
                'contact_type' => 'Management',
                'status' => 'Active'
            )
        );
        DB::table('contacts')->insert(
            array(
                'contact_type' => 'Logistics',
                'status' => 'Active'
            )
        );
        DB::table('contacts')->insert(
            array(
                'contact_type' => 'Billing',
                'status' => 'Active'
            )
        );
        DB::table('contacts')->insert(
            array(
                'contact_type' => 'HR',
                'status' => 'Active'
            )
        );

        Schema::create('country_state_towns', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('town')->nullable();
            $table->integer('postcode')->nullable();
            $table->string('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });

        DB::table('country_state_towns')->insert(
            array(
                'country' => 'Singapore',
                'state' => 'Singapore',
                'town' => 'Redhill',
                'postcode' => '600000',
                'created_by' => 1,
                'status' => 'Active'
            )
        );
        DB::table('country_state_towns')->insert(
            array(
                'country' => 'Singapore',
                'state' => 'Singapore',
                'town' => 'Woodlands',
                'postcode' => '600000',
                'created_by' => 1,
                'status' => 'Active'
            )
        );
        DB::table('country_state_towns')->insert(
            array(
                'country' => 'United States',
                'state' => 'California',
                'town' => 'Los Angeles',
                'postcode' => '90001',
                'created_by' => 1,
                'status' => 'Active'
            )
        );

        Schema::create('achievements', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('achievement_type');
            $table->string('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });

        DB::table('achievements')->insert(
            array(
                'achievement_type' => 'Certificate',
                'status' => 'Active'
            )
        );
        DB::table('achievements')->insert(
            array(
                'achievement_type' => 'Achievement',
                'status' => 'Active'
            )
        );
        DB::table('achievements')->insert(
            array(
                'achievement_type' => 'Highlights',
                'status' => 'Active'
            )
        );

        Schema::create('rates', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('rate_category');
            $table->text('description')->nullable();
            $table->string('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });

        DB::table('rates')->insert(
            array(
                'rate_category' => 'Cost Efficiency',
                'status' => 'Active'
            )
        );
        DB::table('rates')->insert(
            array(
                'rate_category' => 'Technology Availability',
                'status' => 'Active'
            )
        );
        DB::table('rates')->insert(
            array(
                'rate_category' => 'Responsiveness',
                'status' => 'Active'
            )
        );
        DB::table('rates')->insert(
            array(
                'rate_category' => 'Assurance of Supply',
                'status' => 'Active'
            )
        );
        DB::table('rates')->insert(
            array(
                'rate_category' => 'Quality of Operations',
                'status' => 'Active'
            )
        );

        Schema::create('appointment_objectives', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('app_objective');
            $table->text('description')->nullable();
            $table->string('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });

        DB::table('appointment_objectives')->insert(
            array(
                'app_objective' => 'Meeting',
                'status' => 'Active'
            )
        );
        DB::table('appointment_objectives')->insert(
            array(
                'app_objective' => 'Follow Up',
                'status' => 'Active'
            )
        );
        DB::table('appointment_objectives')->insert(
            array(
                'app_objective' => 'Courtesy Call',
                'status' => 'Active'
            )
        );
        DB::table('appointment_objectives')->insert(
            array(
                'app_objective' => 'Issue Resolution',
                'status' => 'Active'
            )
        );
        DB::table('appointment_objectives')->insert(
            array(
                'app_objective' => 'Site Visit',
                'status' => 'Active'
            )
        );
        DB::table('appointment_objectives')->insert(
            array(
                'app_objective' => 'Management Review',
                'status' => 'Active'
            )
        );
        DB::table('appointment_objectives')->insert(
            array(
                'app_objective' => 'Others',
                'status' => 'Active'
            )
        );

        Schema::create('ticket_issues', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('ticket_issue');
            $table->text('description')->nullable();
            $table->string('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });

        DB::table('ticket_issues')->insert(
            array(
                'ticket_issue' => 'Technical',
                'status' => 'Active'
            )
        );
        DB::table('ticket_issues')->insert(
            array(
                'ticket_issue' => 'Inquiry',
                'status' => 'Active'
            )
        );
        DB::table('ticket_issues')->insert(
            array(
                'ticket_issue' => 'Login',
                'status' => 'Active'
            )
        );
        DB::table('ticket_issues')->insert(
            array(
                'ticket_issue' => 'Network',
                'status' => 'Active'
            )
        );

        Schema::create('logistics', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });

        DB::table('logistics')->insert(
            array(
                'name' => 'Ship',
                'status' => 'Active'
            )
        );
        DB::table('logistics')->insert(
            array(
                'name' => 'Flight',
                'status' => 'Active'
            )
        );
        DB::table('logistics')->insert(
            array(
                'name' => 'Land',
                'status' => 'Active'
            )
        );

        Schema::create('services', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });

        DB::table('services')->insert(
            array(
                'name' => 'Service 1',
                'status' => 'Active'
            )
        );
        DB::table('services')->insert(
            array(
                'name' => 'Service 2',
                'status' => 'Active'
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
        Schema::drop('logistics');
        Schema::drop('services');
        Schema::drop('industries');
        Schema::drop('requirements');
        Schema::drop('highlights');
        Schema::drop('potentials');
        Schema::drop('accesses');
        Schema::drop('contacts');
        Schema::drop('country_state_towns');
        Schema::drop('achievements');
        Schema::drop('rates');
        Schema::drop('appointment_objectives');
        Schema::drop('ticket_issues');
    }
}