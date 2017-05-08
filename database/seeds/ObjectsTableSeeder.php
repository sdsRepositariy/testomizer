<?php

use Illuminate\Database\Seeder;

class ObjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('objects')->insert([
            [
                'slug' => "community",
            ],
            [
                'slug' => "home",
            ],
            [
                'slug' => "user",
            ],
            [
                'slug' => "user-superadmin",
            ],
            [
                'slug' => "user-admin",
            ],
            [
                'slug' => "user-user",
            ],
            [
                'slug' => "user-respondent",
            ],
            [
                'slug' => "tests",
            ],
            [
                'slug' => "permissions",
            ],
        ]);
    }
}
