<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AnswerFormsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('answer_forms')->insert([
            [
                'name' => 'One variant',
                'code' => 'single',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Multiple variants',
                'code' => 'multiple',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Ordering/matching',
                'code' => 'order',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Free answer',
                'code' => 'free',
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
