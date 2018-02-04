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
            [
                'name' => 'школа',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'гімназія',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'ліцей',
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
