<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned();
            $table->integer('user_group_id')->unsigned();
            $table->integer('community_id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('first_name', 255);
            $table->string('middle_name', 255);
            $table->string('last_name', 255);
            $table->string('login', 100)->unique();
            $table->string('password', 100);
            $table->string('email', 255)->nullable()->unique();
            $table->string('phone_number', 45)->nullable()->unique();
            $table->date('birthday')->nullable();
            $table->softDeletes();
            $table->rememberToken()->nullable();
            $table->timestamps();
            $table->timestamp('pass_start_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
