<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToInterpretationKeyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('interpretation_key', function (Blueprint $table) {
            $table->foreign('interpretation_id')->references('id')->on('interpretations')->onDelete('cascade');
            $table->foreign('key_id')->references('id')->on('keys')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('interpretation_key', function (Blueprint $table) {
            $table->dropForeign('interpretation_key_interpretation_id_foreign');
            $table->dropForeign('interpretation_key_key_id_foreign');
        });
    }
}
