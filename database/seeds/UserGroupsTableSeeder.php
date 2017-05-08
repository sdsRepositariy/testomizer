<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_groups')->insert([
            [
                'group' => 'teachers',
                'created_at' => Carbon::now(),
            ],
            [
                'group' => 'students',
                'created_at' => Carbon::now(),
            ],
            [
                'group' => 'parents',
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
