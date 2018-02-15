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
                'slug' => "home",
            ],
            [
                'slug' => "permissions",
            ],
            [
                'slug' => "community",
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
                'slug' => "tasks",
            ],
            [
                'slug' => "tests",
            ],
        ]);
    }
}
