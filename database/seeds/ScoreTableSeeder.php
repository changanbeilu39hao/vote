<?php

use Illuminate\Database\Seeder;


class ScoreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    
        for ($i=1; $i < 2001; $i++) {    
            DB::table('scores')->insert([
                'user_id'=> 1,
                'item_id'=>random_int(1,2000),
                'score'=>random_int(1,80),
            ]);
        }

    }
}
