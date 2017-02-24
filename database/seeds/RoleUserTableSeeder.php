<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('role_user')->insert([
    		'user_id' => 1,
            'role_id' => 1,
            'created_at' => Carbon::now(),
		]);
    }
}
