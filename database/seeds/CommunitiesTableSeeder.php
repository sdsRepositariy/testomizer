<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CommunitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('communities')->insert([
            'city_id' => 1,
            'community_type_id' => 1,
            'number' => 27,
            'created_at' => Carbon::now(),
        ]);
    }
}
