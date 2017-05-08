<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CommunityTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('community_types')->insert([
            'name' => 'school',
            'created_at' => Carbon::now(),
        ]);
    }
}
