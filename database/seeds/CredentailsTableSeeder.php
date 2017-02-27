<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CredentailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('credentials')->insert([
    		'role_id' => 1,
            'credential_id' => 1,
            'credential_type' => 'App\Models\Users\User',
            'login' => 'a21293',
            'password' => 'Serov001',
            'created_at' => Carbon::now(),
		]);
    }
}
