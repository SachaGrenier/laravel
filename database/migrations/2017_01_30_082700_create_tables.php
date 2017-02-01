<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		
	  Schema::create('sector', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });
		
	   Schema::create('title', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });
		
		
        Schema::create('applicant', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
			$table->string('last_name');
			$table->string('email')->nullable();
			$table->string('phone_number')->nullable();
			$table->timestamps();
		
        });
		
	   Schema::create('contact_company', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
			$table->string('website')->nullable();
			$table->string('phone_number')->nullable();
			$table->string('logo_path')->nullable();
        });
		
	
		
	 Schema::create('contact', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
			$table->string('last_name');
			$table->string('email');
			$table->string('phone_number');
			$table->integer('contact_company_id')->unsigned();
			$table->timestamps();
			$table->foreign('contact_company_id')->references('id')->on('contact_company');
        });
		
	
		
		    Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
			$table->string('login');
			$table->string('password');
            $table->string('first_name');
			$table->string('last_name');
            $table->string('email');          
			$table->boolean('type')->default(0);
			$table->string('picture_path');
			$table->integer('title_id')->unsigned();
			$table->integer('sector_id')->unsigned()->nullable();
            $table->timestamps();
			$table->foreign('title_id')->references('id')->on('sector');
			$table->foreign('sector_id')->references('id')->on('sector');
        });
		
			   Schema::create('ticket', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
			$table->text('content');
            $table->text('note');
			$table->boolean('archived')->default(0);
			$table->boolean('project')->default(0);
			$table->date('time_limit')->nullable();
			$table->integer('user_id')->unsigned()->nullable();
			$table->integer('sector_id')->unsigned()->nullable();
			$table->integer('applicant_id')->unsigned()->nullable();
            $table->timestamps();
			$table->foreign('user_id')->references('id')->on('user');
			$table->foreign('sector_id')->references('id')->on('sector');
			$table->foreign('applicant_id')->references('id')->on('applicant');
        });
		
		   Schema::create('ticket_contact', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('contact_id')->unsigned();
			$table->integer('ticket_id')->unsigned();
			$table->foreign('contact_id')->references('id')->on('contact');
			$table->foreign('ticket_id')->references('id')->on('ticket');
        });
		
		  Schema::create('file', function (Blueprint $table) {
            $table->increments('id');
            $table->string('path');
			$table->string('ext',5);
			$table->integer('ticket_id')->unsigned();
			$table->timestamps();
			$table->foreign('ticket_id')->references('id')->on('ticket');
        });
		
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
