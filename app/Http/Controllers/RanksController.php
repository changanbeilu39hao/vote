<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class RanksController extends Controller
{
    public function index($id=1)
    {
        if($id == 1){
            $top = DB::select("select MAX(Tickets) t from votework where GroupType='小学1-3年级组';");
            $top = $top[0]->t;

            $sql = "SELECT s.*,v.Tickets,v.Teacher,v.Student,v.CityId,v.AreaId FROM last_scores s LEFT JOIN user_last_score u on s.item_id = u.item_id LEFT JOIN votework v on s.item_id = v.WorkId where u.status = 1 AND s.group_id=1 GROUP BY item_id ORDER BY (s.last_score+0) desc limit 1000;";
            $data = array_map('get_object_vars',DB::select($sql));
            
            foreach($data as $k=>$v){
                $vote_score = round(($v['Tickets']/$top)*20, 3);
                $data[$k]['vote_score'] = $vote_score ;
                $data[$k]['total_score'] = $vote_score + $v['last_score'];
            }
            $ranks =array_column($data,'total_score');
            array_multisort($ranks, SORT_DESC, $data);     
            Cache::put('key1', array_slice($data, 0, 350));
        }


        if($id == 2){
            $top = DB::select("select MAX(Tickets) t from votework where GroupType='小学4-6年级组';");
            $top = $top[0]->t;

            $sql = "SELECT s.*,v.Tickets,v.Teacher,v.Student,v.CityId,v.AreaId FROM last_scores s LEFT JOIN user_last_score u on s.item_id = u.item_id LEFT JOIN votework v on s.item_id = v.WorkId where u.status = 1 AND s.group_id=2 GROUP BY item_id ORDER BY (s.last_score+0) desc limit 1000;";
            $data = array_map('get_object_vars',DB::select($sql));
            
            foreach($data as $k=>$v){
                $vote_score = round(($v['Tickets']/$top)*20, 3);
                $data[$k]['vote_score'] = $vote_score ;
                $data[$k]['total_score'] = $vote_score + $v['last_score'];
            }
            $ranks =array_column($data,'total_score');
            array_multisort($ranks, SORT_DESC, $data);    
            Cache::put('key2', array_slice($data, 0, 350)); 
        }


        if($id == 3){
            $top = DB::select("select MAX(Tickets) t from votework where GroupType='初中组';");
            $top = $top[0]->t;

            $sql = "SELECT s.*,v.Tickets,v.Teacher,v.Student,v.CityId,v.AreaId FROM last_scores s LEFT JOIN user_last_score u on s.item_id = u.item_id LEFT JOIN votework v on s.item_id = v.WorkId where u.status = 1 AND s.group_id=3 GROUP BY item_id ORDER BY (s.last_score+0) desc limit 1000;";
            $data = array_map('get_object_vars',DB::select($sql));
            
            foreach($data as $k=>$v){
                $vote_score = round(($v['Tickets']/$top)*20, 3);
                $data[$k]['vote_score'] = $vote_score ;
                $data[$k]['total_score'] = $vote_score + $v['last_score'];
            }
            $ranks =array_column($data,'total_score');
            array_multisort($ranks, SORT_DESC, $data);     
            Cache::put('key3', array_slice($data, 0, 350));
        }

        // dd(Cache::get('key1'));
        return view('ranks.index',compact('data', 'id'));
    }

    public function city()
    {

        $cities = DB::table('xzq')
                    ->where('Parentid', 510000)
                    ->select('Name', 'Code')
                    ->get();
       
        $data = [];
        $areas = [];
        foreach ($cities as $k=>$v) {
            $areas[] = array_map('get_object_vars', DB::table('xzq')
                                ->where('ParentId', $v->Code)
                                ->select('Code', 'Name', 'Parentid')
                                ->get()
                                ->toArray()); 
            
            $count = DB::table('works')
                        ->leftJoin('consumer', 'works.ConsumerId', '=', 'consumer.Id')
                        ->select('works.Id', 'consumer.CityId', 'consumer.AreaId')
                        ->where('consumer.CityId', $v->Code)
                        ->count();
            $data[$k]['count'] =  $count;
            $data[$k]['count_score'] = $count*0.1;
            $data[$k]['city'] = $v->Name;

            $first = 0;
            $second = 0;
            $third = 0;

            foreach (array_slice(Cache::get('key1'), 0, 50) as $a=>$b){
                if($b['CityId'] == $v->Code){
                    $first++;
                } 
            }
            foreach (array_slice(Cache::get('key1'), 51, 150) as $a=>$b){
                if($b['CityId'] == $v->Code){
                    $second++;
                } 
            }
            foreach (array_slice(Cache::get('key1'), 151, 350) as $a=>$b){
                if($b['CityId'] == $v->Code){
                    $third++;
                } 
            }



            foreach (array_slice(Cache::get('key2'), 0, 50) as $a=>$b){
                if($b['CityId'] == $v->Code){
                    $first++;
                } 
            }
            foreach (array_slice(Cache::get('key1'), 0, 50) as $a=>$b){
                if($b['CityId'] == $v->Code){
                    $second++;
                } 
            }
            foreach (array_slice(Cache::get('key1'), 0, 50) as $a=>$b){
                if($b['CityId'] == $v->Code){
                    $third++;
                } 
            }


            foreach (array_slice(Cache::get('key3'), 0, 50) as $a=>$b){
                if($b['CityId'] == $v->Code){
                    $first++;
                } 
            }
            foreach (array_slice(Cache::get('key1'), 0, 50) as $a=>$b){
                if($b['CityId'] == $v->Code){
                    $second++;
                } 
            }
            foreach (array_slice(Cache::get('key1'), 0, 50) as $a=>$b){
                if($b['CityId'] == $v->Code){
                    $third++;
                } 
            }


            $data[$k]['first'] = $first;
            $data[$k]['first_score'] = $first*20;

            $data[$k]['second'] = $second;
            $data[$k]['second_score'] = $second*10;

            $data[$k]['third'] = $third;
            $data[$k]['third_score'] = $third*5;

            $data[$k]['total_score'] = $third*5+$first*20+$second*10+$count*0.1;
        }
        
        $ranks = array_column($data,'total_score');
        array_multisort($ranks, SORT_DESC, $data);   

        $areas_arr = array_reduce($areas, 'array_merge', array());
        
        foreach ($areas_arr as $k=>$v) {
            // 投稿数量
            $count = DB::table('works')
                        ->leftJoin('consumer', 'works.ConsumerId', '=', 'consumer.Id')
                        ->select('works.Id', 'consumer.CityId', 'consumer.AreaId')
                        ->where('consumer.AreaId', $v['Code'])
                        ->count();
            $areas_arr[$k]['count'] = $count;
            $areas_arr[$k]['city'] = DB::table('xzq')->where('Code', $v['Parentid'])->value('Name');
            $areas_arr[$k]['count_score'] = $count*0.1;

            $first = 0;
            $second = 0;
            $third = 0;

            foreach (array_slice(Cache::get('key1'), 0, 50) as $a=>$b){
                if($b['AreaId'] == $v['Code']){
                    $first++;
                } 
            }
            foreach (array_slice(Cache::get('key1'), 51, 150) as $a=>$b){
                if($b['AreaId'] == $v['Code']){
                    $second++;
                } 
            }
            foreach (array_slice(Cache::get('key1'), 151, 350) as $a=>$b){
                if($b['AreaId'] == $v['Code']){
                    $third++;
                } 
            }



            foreach (array_slice(Cache::get('key2'), 0, 50) as $a=>$b){
                if($b['AreaId'] == $v['Code']){
                    $first++;
                } 
            }
            foreach (array_slice(Cache::get('key1'), 0, 50) as $a=>$b){
                if($b['AreaId'] == $v['Code']){
                    $second++;
                } 
            }
            foreach (array_slice(Cache::get('key1'), 0, 50) as $a=>$b){
                if($b['AreaId'] == $v['Code']){
                    $third++;
                } 
            }


            foreach (array_slice(Cache::get('key3'), 0, 50) as $a=>$b){
                if($b['AreaId'] == $v['Code']){
                    $first++;
                } 
            }
            foreach (array_slice(Cache::get('key1'), 0, 50) as $a=>$b){
                if($b['AreaId'] == $v['Code']){
                    $second++;
                } 
            }
            foreach (array_slice(Cache::get('key1'), 0, 50) as $a=>$b){
                if($b['AreaId'] == $v['Code']){
                    $third++;
                } 
            }


            $areas_arr[$k]['first'] = $first;
            $areas_arr[$k]['first_score'] = $first*20;

            $areas_arr[$k]['second'] = $second;
            $areas_arr[$k]['second_score'] = $second*10;

            $areas_arr[$k]['third'] = $third;
            $areas_arr[$k]['third_score'] = $third*5;

            $areas_arr[$k]['total_score'] = $third*5+$first*20+$second*10+$count*0.1;
        }
        $areas_ranks = array_column($areas_arr,'total_score');
        array_multisort($areas_ranks, SORT_DESC, $areas_arr); 
        
        // dd($areas_arr);
        return view('ranks.city',compact('data', 'areas_arr'));
    }
}
