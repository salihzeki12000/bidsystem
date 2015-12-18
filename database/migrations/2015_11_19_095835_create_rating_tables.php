<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('c');
            $table->integer('e');
            $table->integer('t');
            $table->integer('r');
            $table->integer('a');
            $table->integer('q');
            $table->text('comment');
            $table->tinyInteger('moderated');
            $table->integer('rate_by')->unsigned()->nullable();
            $table->foreign('rate_by')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::drop('ratings');
    }
}