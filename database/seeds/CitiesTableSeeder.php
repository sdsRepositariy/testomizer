<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
            'region_id' => 1,
            'name' => 'Zaporozhye',
            'created_at' => Carbon::now(),
        ]);
    }
}
