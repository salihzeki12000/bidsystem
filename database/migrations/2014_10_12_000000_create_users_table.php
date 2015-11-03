<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('company_name');
            $table->enum('category', array('LSP', 'Outsourcing', 'Advertiser'));
            $table->date('date_joined')->nullable();
            $table->date('date_operation_started')->nullable();
            $table->string('registration_num')->nullable();
            $table->string('paid_up_capital')->nullable();
            $table->string('logo')->nullable();
            $table->integer('no_of_employees')->nullable();
            $table->integer('annual_turnover')->nullable();
            $table->text('keyword')->nullable();
            $table->string('physical_file_number')->nullable();
            $table->integer('billing_period')->nullable();
            $table->tinyInteger('include_gst')->default(0);
            $table->integer('gst_percent')->nullable()->default(0);
            $table->enum('status', array('Draft', 'Active', 'Inactive'));
            $table->integer('account_quota')->default(2);
            $table->integer('delete')->default(0);
            $table->integer('created_by');
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });

        Schema::create('company_contacts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('contact_type_id')->unsigned();
            $table->foreign('contact_type_id')
                ->references('id')->on('contacts')
                ->onUpdate('cascade');
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('address_line_3')->nullable();
            $table->integer('postcode')->nullable();
            $table->string('town')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('tel_num')->nullable();
            $table->string('fax_num')->nullable();
            $table->string('website')->nullable();
            $table->string('pic_name')->nullable();
            $table->string('pic_department')->nullable();
            $table->string('pic_designation')->nullable();
            $table->string('pic_mobile_num')->nullable();
            $table->string('pic_email_1')->nullable();
            $table->string('pic_email_2')->nullable();
            $table->string('status')->nullable();
            $table->integer('created_by');
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->enum('type', array('super_admin', 'globe_admin', 'inward_group_admin', 'inward_group_user', 'outward_group_admin', 'outward_group_user'));
            $table->enum('status', array('Draft', 'Active', 'Inactive'));
            $table->integer('company_id')->unsigned()->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('delete')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(
            array(
                'first_name' => 'Sun',
                'last_name' => 'Zelun',
                'email' => 'bid@bid.com',
                'password' => bcrypt('111111'),
                'type' => 'super_admin',
                'status' => 'Active',
                'created_at' => DB::raw('CURRENT_TIMESTAMP')
            )
        );

        DB::table('companies')->insert(
            array(
                'company_name' => 'Outsourcing Company',
                'category' => 'Outsourcing',
                'date_joined' => '2010-10-10',
                'date_operation_started' => '2015-10-10',
                'registration_num' => 'RN',
                'paid_up_capital' => 'PUC',
                'no_of_employees' => 200,
                'annual_turnover' => 600000,
                'keyword' => 'Keyword',
                'physical_file_number' => 'PFN',
                'billing_period' => '30',
                'include_gst' => 0,
                'status' => 'Active',
                'account_quota' => 10,
                'delete' => 0,
                'created_by' => 1,
                'created_at' => DB::raw('CURRENT_TIMESTAMP')
            )
        );

        DB::table('companies')->insert(
            array(
                'company_name' => 'LSP Company',
                'category' => 'LSP',
                'date_joined' => '2010-10-10',
                'date_operation_started' => '2015-10-10',
                'registration_num' => 'RN',
                'paid_up_capital' => 'PUC',
                'no_of_employees' => 200,
                'annual_turnover' => 600000,
                'keyword' => 'Keyword',
                'physical_file_number' => 'PFN',
                'billing_period' => '30',
                'include_gst' => 0,
                'status' => 'Active',
                'account_quota' => 10,
                'delete' => 0,
                'created_by' => 1,
                'created_at' => DB::raw('CURRENT_TIMESTAMP')
            )
        );

        DB::table('users')->insert(
            array(
                'first_name' => 'Inward',
                'last_name' => 'Bid',
                'email' => 'inward@bid.com',
                'password' => bcrypt('111111'),
                'type' => 'inward_group_admin',
                'status' => 'Active',
                'company_id' => 2,
                'created_at' => DB::raw('CURRENT_TIMESTAMP')
            )
        );

        DB::table('users')->insert(
            array(
                'first_name' => 'Outward',
                'last_name' => 'Bid',
                'email' => 'outward@bid.com',
                'password' => bcrypt('111111'),
                'type' => 'outward_group_admin',
                'status' => 'Active',
                'company_id' => 1,
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
        Schema::drop('company_contacts');
        Schema::drop('users');
        Schema::drop('companies');
    }
}
