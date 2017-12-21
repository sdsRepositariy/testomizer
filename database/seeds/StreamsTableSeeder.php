<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class StreamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('streams')->insert([
            [
                'name' => 'А',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Б',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'В',
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
