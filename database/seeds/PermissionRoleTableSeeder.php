<?php

use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission_role')->insert([
            [
                'role_id' => 1,
                'permission_id' => 1,
                'object_id' => 1,
            ],
            [
                'role_id' => 1,
                'permission_id' => 2,
                'object_id' => 1,
            ],
            [
                'role_id' => 1,
                'permission_id' => 3,
                'object_id' => 1,
            ],
            [
                'role_id' => 1,
                'permission_id' => 4,
                'object_id' => 1,
            ],
            [
                'role_id' => 1,
                'permission_id' => 1,
                'object_id' => 2,
            ],
            [
                'role_id' => 1,
                'permission_id' => 2,
                'object_id' => 2,
            ],
            [
                'role_id' => 1,
                'permission_id' => 3,
                'object_id' => 2,
            ],
            [
                'role_id' => 1,
                'permission_id' => 4,
                'object_id' => 2,
            ],
        ]);
    }
}
