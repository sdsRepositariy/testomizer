<?php

use Illuminate\Database\Seeder;

class TaskItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('task_items')->insert([
            [
                'user_id' => 1,
                'name' => 'Default',
            ],
        ]);
    }
}
