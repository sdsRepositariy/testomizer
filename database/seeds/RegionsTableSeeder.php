<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regions')->insert([
            'country_id' => 1,
            'name' => 'Zaporozhskaya oblast',
            'created_at' => Carbon::now(),
        ]);
    }
}
