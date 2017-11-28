<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->foreign('period_id')->references('id')->on('periods');
            $table->foreign('level_id')->references('id')->on('levels');
            $table->foreign('stream_id')->references('id')->on('streams');
            $table->foreign('community_id')->references('id')->on('communities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->dropForeign('grades_level_id_foreign');
            $table->dropForeign('grades_period_id_foreign');
            $table->dropForeign('grades_stream_id_foreign');
            $table->dropForeign('grades_community_id_foreign');
        });
    }
}
