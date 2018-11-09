<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToTestFolderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_folders', function (Blueprint $table) {
            $table->foreign('test_folder_id')->references('id')->on('test_folders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_folders', function (Blueprint $table) {
            $table->dropForeign('test_folders_test_folder_id_foreign');
        });
    }
}
