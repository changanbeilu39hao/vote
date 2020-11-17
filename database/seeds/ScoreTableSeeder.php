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
    $arr2 = [4,5,6,14,15,16,17];
    $arr3 = [7,8,9,18,19,20,21];

        for ($i=1; $i < 2001; $i++) {  
            for ($v=0; $v<7;$v++){
                DB::table('scores')->insert([
                    'user_id'=>$arr[$v] ,
                    'item_id'=>$i,
                    'score'=>random_int(100,8000)/100,
                ]);
                }
        }

        for ($i=2001; $i < 4001; $i++) {  
            for ($v=0; $v<7;$v++){
                DB::table('scores')->insert([
                    'user_id'=>$arr2[$v] ,
                    'item_id'=>$i,
                    'score'=>random_int(100,8000)/100,
                ]);
                }
        }

        for ($i=4001; $i < 6001; $i++) {  
            for ($v=0; $v<7;$v++){
                DB::table('scores')->insert([
                    'user_id'=>$arr3[$v] ,
                    'item_id'=>$i,
                    'score'=>random_int(100,8000)/100,
                ]);
                }
        }

    }
}
