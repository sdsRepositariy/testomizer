<?php

use Illuminate\Database\Seeder;

class TaskListsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('task_lists')->insert([
            [
                'user_id' => 1,
                'task_folder_id' => 1,
                'name' => 'Default',
            ],
        ]);
    }
}
