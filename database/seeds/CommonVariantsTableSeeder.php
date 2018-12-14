<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CommonVariantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('common_variants')->insert([
            [
                'variant' => 'Yes',
                'created_at' => Carbon::now(),
            ],
            [
                'variant' => 'No',
                'created_at' => Carbon::now(),
            ],
            [
                'variant' => 'Rather yes than no',
                'created_at' => Carbon::now(),
            ],
            [
                'variant' => 'Rather no than yes',
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
