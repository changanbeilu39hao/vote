<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for ($i=1; $i < 22; $i++) { 
            $is_inspector = 0;
            if ($i<10){
                $is_inspector = 1;
            }

            $group = 0;
            foreach ([1,2,3] as $v) {
                $group++;
                if($v == 3){
                    $group = 0;
                }
            }

            DB::table('users')->insert([
            'name' => 'zhuanjia'.$i,
            'email' => 'test@test'.$i,
            'is_inspector' => $is_inspector,
            'group_id'=> $group, 
            'password' => Hash::make('password'),

            ]);
        }
    }
}
