<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToTaskTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_test', function (Blueprint $table) {
            $table->foreign('test_id')->references('id')->on('tests');
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_test', function (Blueprint $table) {
            $table->dropForeign('task_test_test_id_foreign');
            $table->dropForeign('task_test_task_id_foreign');
        });
    }
}
