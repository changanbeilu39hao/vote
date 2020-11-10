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

    $arr = [1,2,3,10,11,12,13];

        for ($i=1; $i < 2001; $i++) {  

            for ($v=0; $v<7;$v++){
            DB::table('scores')->insert([
                'user_id'=>$arr[$v] ,
                'item_id'=>$i,
                'score'=>random_int(1,80),
            ]);
            }

        }

    }
}
