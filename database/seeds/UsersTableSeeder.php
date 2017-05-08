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
            [
                'role_id' => 1,
                'user_group_id' => 1,
                'user_id' => null,
                'community_id' => 1,
                'login' => 1,
                'password' => bcrypt('1'),
                'first_name' => 'TestSuperadmin',
                'middle_name' => 'TestSuperadmin',
                'last_name' => 'TestSuperadmin',
                'email' => 'sdsmail1973@gmail.com',
                'phone_number' => '0503224866',
                'created_at' => Carbon::now(),
            ],
            [
                'role_id' => 2,
                'user_group_id' => 1,
                'community_id' => 1,
                'user_id' => null,
                'login' => 2,
                'password' => bcrypt('2'),
                'first_name' => 'TestAdmin',
                'middle_name' => 'TestAdmin',
                'last_name' => 'TestAdmin',
                'email' => 'lara@gmail.com',
                'phone_number' => '0501234567',
                'created_at' => Carbon::now(),
            ],
            [
                'role_id' => 3,
                'user_group_id' => 1,
                'community_id' => 1,
                'user_id' => null,
                'login' => 3,
                'password' => bcrypt('3'),
                'first_name' => 'TestUser',
                'middle_name' => 'TestUser',
                'last_name' => 'TestUser',
                'email' => 'fred@gmail.com',
                'phone_number' => '0507654321',
                'created_at' => Carbon::now(),
            ],
            [
                'role_id' => 4,
                'user_group_id' => 2,
                'community_id' => 1,
                'user_id' => 1,
                'login' => 4,
                'password' => bcrypt('r'),
                'first_name' => 'TestRespondent',
                'middle_name' => 'TestRespondent',
                'last_name' => 'TestRespondent',
                'email' => null,
                'phone_number' => null,
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
