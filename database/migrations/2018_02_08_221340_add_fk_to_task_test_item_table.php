<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToTaskTestItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_test_item', function (Blueprint $table) {
            $table->foreign('test_item_id')->references('id')->on('test_items');
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
        Schema::table('task_test_item', function (Blueprint $table) {
            $table->dropForeign('task_test_item_test_item_id_foreign');
            $table->dropForeign('task_test_item_task_id_foreign');
        });
    }
}
