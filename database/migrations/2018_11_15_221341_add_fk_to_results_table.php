<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('results', function (Blueprint $table) {
            $table->foreign('task_user_id')->references('id')->on('task_user');
            $table->foreign('task_test_item_id')->references('id')->on('task_test_item')->onDelete('cascade');
            $table->foreign('answer_id')->references('id')->on('answers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('results', function (Blueprint $table) {
            $table->dropForeign('results_task_user_id_foreign');
            $table->dropForeign('results_task_test_item_id_foreign');
            $table->dropForeign('results_answer_id_foreign');
        });
    }
}
