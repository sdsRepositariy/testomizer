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
                'name' => 'a',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'b',
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
