<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
    		'role_id' => 1,
            'owner_id' => 1,
            'owner_type' => 'App\Models\Users\Admin',
            'login' => 'a21293',
            'password' => bcrypt('Serov001'),
            'created_at' => Carbon::now(),
		]);
    }
}
