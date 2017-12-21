<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PeriodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('periods')->insert([
            [
                'year_start' => '2015-09-01',
                'year_end' => '2016-08-31',
                'created_at' => Carbon::now(),
            ],
            [
                'year_start' => '2016-09-01',
                'year_end' => '2017-08-31',
                'created_at' => Carbon::now(),
            ],
            [
                'year_start' => '2017-09-01',
                'year_end' => '2018-08-31',
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
