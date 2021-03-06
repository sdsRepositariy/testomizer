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
            [
                'role' => 'superadmin',
            ],
            [
                'role' => 'admin',
            ],
            [
                'role' => 'user',
            ],
            [
                'role' => 'respondent',
            ]
        ]);
    }
}
