<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileTypeAndRfiStatusTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_types', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('file_type');
            $table->string('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });

        DB::table('file_types')->insert(
            array(
                'file_type' => 'Invoice',
                'status' => 'Active'
            )
        );
        DB::table('file_types')->insert(
            array(
                'file_type' => 'DN',
                'status' => 'Active'
            )
        );
        DB::table('file_types')->insert(
            array(
                'file_type' => 'CN',
                'status' => 'Active'
            )
        );
        DB::table('file_types')->insert(
            array(
                'file_type' => 'Logo',
                'status' => 'Active'
            )
        );
        DB::table('file_types')->insert(
            array(
                'file_type' => 'Profile',
                'status' => 'Active'
            )
        );
        DB::table('file_types')->insert(
            array(
                'file_type' => 'Support',
                'status' => 'Active'
            )
        );
        DB::table('file_types')->insert(
            array(
                'file_type' => 'Registration',
                'status' => 'Active'
            )
        );
        DB::table('file_types')->insert(
            array(
                'file_type' => 'Others',
                'status' => 'Active'
            )
        );

        Schema::create('rfi_status', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('rfi_status');
            $table->tinyInteger('available_for_company')->default(0);
            $table->tinyInteger('available_for_job')->default(0);
            $table->tinyInteger('available_for_bid_lsp')->default(0);
            $table->tinyInteger('available_for_bid_outsourcer')->default(0);
            $table->text('description')->nullable();
            $table->string('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('modified_by')->nullable();
            $table->timestamps();
        });

        DB::table('rfi_status')->insert(
            array(
                'rfi_status' => 'Draft',
                'available_for_company' => 1,
                'available_for_job' => 1,
                'available_for_bid_lsp' => 1,
                'status' => 'Active'
            )
        );
        DB::table('rfi_status')->insert(
            array(
                'rfi_status' => 'Active',
                'available_for_company' => 1,
                'status' => 'Active'
            )
        );
        DB::table('rfi_status')->insert(
            array(
                'rfi_status' => 'Inactive',
                'available_for_company' => 1,
                'status' => 'Active'
            )
        );
        DB::table('rfi_status')->insert(
            array(
                'rfi_status' => 'Published',
                'available_for_job' => 1,
                'status' => 'Active'
            )
        );
        DB::table('rfi_status')->insert(
            array(
                'rfi_status' => 'Canceled',
                'available_for_job' => 1,
                'available_for_bid_lsp' => 1,
                'status' => 'Active'
            )
        );
        DB::table('rfi_status')->insert(
            array(
                'rfi_status' => 'Awarded',
                'available_for_job' => 1,
                'available_for_bid_outsourcer' => 1,
                'status' => 'Active'
            )
        );
        DB::table('rfi_status')->insert(
            array(
                'rfi_status' => 'Submitted',
                'available_for_bid_lsp' => 1,
                'status' => 'Active'
            )
        );
        DB::table('rfi_status')->insert(
            array(
                'rfi_status' => 'Shortlist',
                'available_for_bid_outsourcer' => 1,
                'status' => 'Active'
            )
        );
        DB::table('rfi_status')->insert(
            array(
                'rfi_status' => 'Keep In View',
                'available_for_bid_outsourcer' => 1,
                'status' => 'Active'
            )
        );
        DB::table('rfi_status')->insert(
            array(
                'rfi_status' => 'Rejected',
                'available_for_bid_outsourcer' => 1,
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
        Schema::drop('file_types');
        Schema::drop('rfi_status');
    }
}
