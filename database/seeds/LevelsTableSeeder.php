<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('levels')->insert([
            [
                'number' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'number' => 2,
                'created_at' => Carbon::now(),
            ],
            [
                'number' => 3,
                'created_at' => Carbon::now(),
            ],
            [
                'number' => 4,
                'created_at' => Carbon::now(),
            ],
            [
                'number' => 5,
                'created_at' => Carbon::now(),
            ],
            [
                'number' => 6,
                'created_at' => Carbon::now(),
            ],
            [
                'number' => 7,
                'created_at' => Carbon::now(),
            ],
            [
                'number' => 8,
                'created_at' => Carbon::now(),
            ],
            [
                'number' => 9,
                'created_at' => Carbon::now(),
            ],
            [
                'number' => 10,
                'created_at' => Carbon::now(),
            ],
            [
                'number' => 11,
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
