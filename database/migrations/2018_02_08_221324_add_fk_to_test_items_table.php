<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToTestItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_items', function (Blueprint $table) {
            $table->foreign('test_folder_id')->references('id')->on('test_folders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_items', function (Blueprint $table) {
            $table->dropForeign('test_items_test_folder_id_foreign');
        });
    }
}
