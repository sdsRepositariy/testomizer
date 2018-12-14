<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('uoms')->insert([
            [
                'name' => 'Score',
                'code' => 'score',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Percent',
                'code' => 'percent',
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
