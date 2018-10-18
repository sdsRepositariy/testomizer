<?php

use Illuminate\Database\Seeder;

class TaskFoldersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('task_folders')->insert([
            [
                'user_id' => 1,
                'name' => 'Default',
            ],
        ]);
    }
}
