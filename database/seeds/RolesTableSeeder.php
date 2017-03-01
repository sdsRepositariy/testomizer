<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
    		['role' => 'superadmin', 'created_at' => Carbon::now(),],
    		['role' => 'admin', 'created_at' => Carbon::now(),],
    		['role' => 'respondent', 'created_at' => Carbon::now(),]
		]);
    }
}
