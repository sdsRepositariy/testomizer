<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToAnswerScaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('answer_scale', function (Blueprint $table) {
            $table->foreign('scale_id')->references('id')->on('scales')->onDelete('cascade');
            $table->foreign('answer_id')->references('id')->on('answers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('answer_scale', function (Blueprint $table) {
            $table->dropForeign('answer_scale_scale_id_foreign');
            $table->dropForeign('answer_scale_answer_id_foreign');
        });
    }
}
