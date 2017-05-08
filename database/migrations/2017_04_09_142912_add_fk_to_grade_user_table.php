<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToGradeUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grade_user', function (Blueprint $table) {
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grade_user', function (Blueprint $table) {
            $table->dropForeign('grade_user_user_id_foreign');
            $table->dropForeign('grade_user_grade_id_foreign');
        });
    }
}
