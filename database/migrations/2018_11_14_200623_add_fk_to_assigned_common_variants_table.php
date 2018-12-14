<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToAssignedCommonVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assigned_common_variants', function (Blueprint $table) {
            $table->foreign('answer_id')->references('id')->on('answers')->onDelete('cascade');
            $table->foreign('common_variant_id')->references('id')->on('common_variants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assigned_common_variants', function (Blueprint $table) {
            $table->dropForeign('assigned_common_variants_answer_id_foreign');
            $table->dropForeign('assigned_common_variants_common_variant_id_foreign');
        });
    }
}
