<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;


class UserAdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
    		'first_name' => 'Dmitriy',
            'middle_name' => 'Sergeevich',
            'last_name' => 'Serov',
            'email' => 'sdsmail1973@gmail.com',
            'phone_number' => '0503224866',
            'created_at' => Carbon::now(),
		]);
    }
}
