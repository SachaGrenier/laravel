<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCollumnApplicantId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
			 Schema::table('ticket', function (Blueprint $table) {
				 
				$table->integer('applicant_id')->unsigned();
				$table->foreign('applicant_id')->references('id')->on('applicant');
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
