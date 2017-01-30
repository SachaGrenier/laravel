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
		
	  Schema::create('t_sector', function (Blueprint $table) {
            $table->increments('idSector');
            $table->string('seName');
        });
		
	   Schema::create('t_title', function (Blueprint $table) {
            $table->increments('idTitle');
            $table->string('tiName');
        });
		
		
        Schema::create('t_applicant', function (Blueprint $table) {
            $table->increments('idApplicant');
            $table->string('apFirst_name');
			$table->string('apLast_name');
			$table->string('apEmail');
			$table->string('apPhone_number');
			$table->timestamps();
		
        });
		
	   Schema::create('t_contact_company', function (Blueprint $table) {
            $table->increments('idContact_company');
            $table->string('conName');
			$table->string('conWebsite');
			$table->string('conPhone_number');
			$table->string('conLogo_path');
        });
		
	
		
	 Schema::create('t_contact', function (Blueprint $table) {
            $table->increments('idContact');
            $table->string('conFirst_name');
			$table->string('conLast_name');
			$table->string('conEmail');
			$table->string('conPhone_number');
			$table->integer('fkContact_company')->unsigned();
			$table->timestamps();
			$table->foreign('fkContact_company')->references('idContact_company')->on('t_contact_company');
        });
		
	
		
		    Schema::create('t_user', function (Blueprint $table) {
            $table->increments('idUser');
			$table->string('usLogin');
			$table->string('usPassword');
            $table->string('usFirst_name');
			$table->string('usLast_name');
            $table->string('usEmail');          
			$table->boolean('usType')->default(0);
			$table->string('usPicture_path');
			$table->integer('fkTitle')->unsigned();
			$table->integer('fkSector')->unsigned();
            $table->timestamps();
			$table->foreign('fkTitle')->references('idTitle')->on('t_title');
			$table->foreign('fkSector')->references('idSector')->on('t_sector');
        });
		
			   Schema::create('t_ticket', function (Blueprint $table) {
            $table->increments('idTicket');
            $table->string('tiTitle');
			$table->text('tiContent');
            $table->text('tiNote');
			$table->boolean('tiArchived')->default(0);
			$table->boolean('tiProject')->default(0);
			$table->date('tiTime_limit');
			$table->integer('fkUser')->unsigned();
			$table->integer('fkSector')->unsigned();
			$table->integer('fkApplicant')->unsigned();
            $table->timestamps();
			$table->foreign('fkUser')->references('idUser')->on('t_user');
			$table->foreign('fkSector')->references('idSector')->on('t_sector');
			$table->foreign('fkApplicant')->references('idApplicant')->on('t_applicant');
        });
		
		   Schema::create('t_ticket_contact', function (Blueprint $table) {
            $table->increments('idTicket_contact');
            $table->integer('idfkTicket')->unsigned();
			$table->integer('idfkContact')->unsigned();
			$table->foreign('idfkContact')->references('idContact')->on('t_contact');
			$table->foreign('idfkTicket')->references('idTicket')->on('t_ticket');
        });
		
		  Schema::create('t_file', function (Blueprint $table) {
            $table->increments('idFile');
            $table->string('fiPath');
			$table->string('fiExt',5);
			$table->integer('fkTicket')->unsigned();
			$table->timestamps();
			$table->foreign('fkTicket')->references('idTicket')->on('t_ticket');
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
