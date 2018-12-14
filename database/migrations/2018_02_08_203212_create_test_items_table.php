<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('test_folder_id')->unsigned()->nullable();
            $table->string('name', 64);
            $table->string('description', 255)->nullable();
            $table->smallInteger('duration')->nullable();
            $table->string('layout_path', 255);
            $table->boolean('skip_question');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_items');
    }
}
