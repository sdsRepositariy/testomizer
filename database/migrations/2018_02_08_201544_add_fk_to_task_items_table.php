<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToTaskItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_items', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('task_folder_id')->references('id')->on('task_folders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_items', function (Blueprint $table) {
            $table->dropForeign('task_items_user_id_foreign');
            $table->dropForeign('task_items_task_folder_id_foreign');
        });
    }
}
