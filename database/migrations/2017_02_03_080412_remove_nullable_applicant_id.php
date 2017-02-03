<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveNullableApplicantId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
               Schema::table('ticket', function (Blueprint $table) {
				$table->dropForeign('ticket_applicant_id_foreign');
				$table->dropColumn('applicant_id');
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
