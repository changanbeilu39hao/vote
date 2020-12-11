<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Exceptions\InvalidRequestException;
use Auth;

class RanksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index($id=1)
    {
        if (Auth::user()->group_id != 5){
            throw new InvalidRequestException('您没有权限进入!');
        }

        if($id == 1){
            if(Cache::has('rank_1')){
                $data = Cache::get('rank_1');
            }else{
                $top = DB::select("select MAX(Tickets) t from votework where GroupType='小学1-3年级组';");
                $top = $top[0]->t;
    
                $sql = "SELECT s.*,v.Tickets,v.Teacher,v.Student,v.CityId,v.AreaId FROM last_scores_2 s LEFT JOIN user_last_score u on s.item_id = u.item_id LEFT JOIN votework v on s.item_id = v.WorkId where u.status = 1 AND s.group_id=1 GROUP BY item_id ORDER BY (s.last_score+0) desc limit 1000;";
                $data = array_map('get_object_vars',DB::select($sql));
    
                $vote_rank_desc = array_column($data, 'Tickets');
                $score_rank = array_column($data, 'last_score');
                rsort($vote_rank_desc);
                rsort($score_rank);
    
                foreach($data as $k=>$v){
                    $vote_score = round(($v['Tickets']/$top)*20, 3);
                    $data[$k]['vote_score'] = $vote_score ;
                    $data[$k]['total_score'] = $vote_score + $v['last_score'];
                    $data[$k]['vote_rank'] = array_search($v['Tickets'],$vote_rank_desc) + 1;
                    $data[$k]['score_rank'] = array_search($v['last_score'],$score_rank) + 1;
                }
    
    
                $ranks =array_column($data,'total_score');
                array_multisort($ranks, SORT_DESC, $data);     
                Cache::put('key1', array_slice($data, 0, 350));
                Cache::put('rank_1', $data);
            }
            
        }


        if($id == 2){
            if(Cache::has('rank_2')){
                $data = Cache::get('rank_2');
            }else{
                $top = DB::select("select MAX(Tickets) t from votework where GroupType='小学4-6年级组';");
                $top = $top[0]->t;
    
                $sql = "SELECT s.*,v.Tickets,v.Teacher,v.Student,v.CityId,v.AreaId FROM last_scores_2 s LEFT JOIN user_last_score u on s.item_id = u.item_id LEFT JOIN votework v on s.item_id = v.WorkId where u.status = 1 AND s.group_id=2 GROUP BY item_id ORDER BY (s.last_score+0) desc limit 1000;";
                $data = array_map('get_object_vars',DB::select($sql));
    
                $vote_rank_desc = array_column($data, 'Tickets');
                $score_rank = array_column($data, 'last_score');
                rsort($vote_rank_desc);
                rsort($score_rank);
                
                foreach($data as $k=>$v){
                    $vote_score = round(($v['Tickets']/$top)*20, 3);
                    $data[$k]['vote_score'] = $vote_score ;
                    $data[$k]['total_score'] = $vote_score + $v['last_score'];
                    $data[$k]['vote_rank'] = array_search($v['Tickets'],$vote_rank_desc) + 1;
                    $data[$k]['score_rank'] = array_search($v['last_score'],$score_rank) + 1;
                }
                $ranks =array_column($data,'total_score');
                array_multisort($ranks, SORT_DESC, $data);    
                Cache::put('key2', array_slice($data, 0, 350)); 
                Cache::put('rank_2', $data);
            }
        }

        if($id == 3){
            if(Cache::has('rank_3')){
                $data = Cache::get('rank_3');
            }else{
                $top = DB::select("select MAX(Tickets) t from votework where GroupType='初中组';");
                $top = $top[0]->t;
    
                $sql = "SELECT s.*,v.Tickets,v.Teacher,v.Student,v.CityId,v.AreaId FROM last_scores_2 s LEFT JOIN user_last_score u on s.item_id = u.item_id LEFT JOIN votework v on s.item_id = v.WorkId where u.status = 1 AND s.group_id=3 GROUP BY item_id ORDER BY (s.last_score+0) desc limit 1000;";
                $data = array_map('get_object_vars',DB::select($sql));
    
                $vote_rank_desc = array_column($data, 'Tickets');
                $score_rank = array_column($data, 'last_score');
                rsort($vote_rank_desc);
                rsort($score_rank);
                
                foreach($data as $k=>$v){
                    $vote_score = round(($v['Tickets']/$top)*20, 3);
                    $data[$k]['vote_score'] = $vote_score ;
                    $data[$k]['total_score'] = $vote_score + $v['last_score'];
                    $data[$k]['vote_rank'] = array_search($v['Tickets'],$vote_rank_desc) + 1;
                    $data[$k]['score_rank'] = array_search($v['last_score'],$score_rank) + 1;
                }
                $ranks =array_column($data,'total_score');
                array_multisort($ranks, SORT_DESC, $data);     
                Cache::put('key3', array_slice($data, 0, 350));
                Cache::put('rank_3', $data);
            }

        }
        return view('ranks.index',compact('data', 'id'));
    }

    public function city()
    {
        if (Cache::has('city_data')){
            $data = Cache::get('city_data');
            $areas_arr = Cache::get('area_data');
        }else{
            $cities = DB::table('xzq')
            ->where('Parentid', 510000)
            ->select('Name', 'Code')
            ->get();

            $cities_count_sql = 'SELECT x.*,
            (SELECT count(*)  FROM
                (SELECT tg.* FROM
                (SELECT w.Id,c.CityId,c.AreaId FROM works w 
                LEFT JOIN consumer c on c.Id=w.ConsumerId) tg) as tg1
                WHERE 1=1 and tg1.CityId=x.`Code`) num
            FROM
            (SELECT p.`Name` as p_name,c.`Code`,c.`Name`FROM 
            (SELECT `Code`,`Name`,Parentid FROM xzq WHERE Parentid=510000) AS c
            LEFT JOIN xzq p  on p.`Code`=c.Parentid
            ) x';




$areas_count_sql = 'SELECT x_a.`Code`,x.`Name` as CityName ,x_a.`Name` as AreaName,
    (
    SELECT count(*) num FROM
    (SELECT tg.* FROM
    (SELECT w.Id,c.CityId,c.AreaId FROM works w 
    LEFT JOIN consumer c on c.Id=w.ConsumerId) tg) as tg1
    WHERE 1=1 and tg1.CityId=x.`Code` and tg1.AreaId=x_a.`Code`
    ) num
FROM
(SELECT p.`Name` as p_name,c.`Code`,c.`Name`FROM 
(SELECT `Code`,`Name`,Parentid FROM xzq WHERE Parentid=510000) AS c
    LEFT JOIN xzq p  on p.`Code`=c.Parentid
) x
LEFT JOIN xzq x_a on x.`Code`=x_a.Parentid';


$cities_count = array_map('get_object_vars', DB::select($cities_count_sql));
$areas_count = array_map('get_object_vars', DB::select($areas_count_sql));



$found_arr = array_column($cities_count, 'Code');
$found_area_arr = array_column($areas_count, 'Code');

// dd($first);
foreach ($cities as $k=>$v) {
    $areas[] = array_map('get_object_vars', DB::table('xzq')
                        ->where('ParentId', $v->Code)
                        ->select('Code', 'Name', 'Parentid')
                        ->get()
                        ->toArray()); 



    $found_key = array_search($v->Code,$found_arr);
    $found_count = $cities_count[$found_key]['num'];            
    $data[$k]['count'] =  $found_count;
    $data[$k]['count_score'] = $found_count*0.1;
    $data[$k]['city'] = $v->Name;

    // $first = 0;
    $first = DB::table('awardswork')->where('CityId', $v->Code)->where('PrizeLevel', 1)->count();
    // $second = 0;
    $second = DB::table('awardswork')->where('CityId', $v->Code)->where('PrizeLevel', 2)->count();
    // $third = 0;
    $third = DB::table('awardswork')->where('CityId', $v->Code)->where('PrizeLevel', 3)->count();

    

    // foreach (array_slice(Cache::get('key1'), 0, 50) as $a=>$b){
    //     if($b['CityId'] == $v->Code){
    //         $first++;
    //     } 
    // }
    // foreach (array_slice(Cache::get('key1'), 50, 100) as $a=>$b){
    //     if($b['CityId'] == $v->Code){
    //         $second++;
    //     } 
    // }
    // foreach (array_slice(Cache::get('key1'), 150, 200) as $a=>$b){
    //     if($b['CityId'] == $v->Code){
    //         $third++;
    //     } 
    // }



    // foreach (array_slice(Cache::get('key2'), 0, 50) as $a=>$b){
    //     if($b['CityId'] == $v->Code){
    //         $first++;
    //     } 
    // }
    // foreach (array_slice(Cache::get('key1'), 50, 100) as $a=>$b){
    //     if($b['CityId'] == $v->Code){
    //         $second++;
    //     } 
    // }
    // foreach (array_slice(Cache::get('key1'), 150, 200) as $a=>$b){
    //     if($b['CityId'] == $v->Code){
    //         $third++;
    //     } 
    // }


    // foreach (array_slice(Cache::get('key3'), 0, 50) as $a=>$b){
    //     if($b['CityId'] == $v->Code){
    //         $first++;
    //     } 
    // }
    // foreach (array_slice(Cache::get('key1'), 50, 100) as $a=>$b){
    //     if($b['CityId'] == $v->Code){
    //         $second++;
    //     } 
    // }
    // foreach (array_slice(Cache::get('key1'), 150, 200) as $a=>$b){
    //     if($b['CityId'] == $v->Code){
    //         $third++;
    //     } 
    // }


    $data[$k]['first'] = $first;
    $data[$k]['first_score'] = $first*20;

    $data[$k]['second'] = $second;
    $data[$k]['second_score'] = $second*10;

    $data[$k]['third'] = $third;
    $data[$k]['third_score'] = $third*5;

    $data[$k]['total_score'] = $third*5+$first*20+$second*10+$found_count*0.1;
}

$ranks = array_column($data,'total_score');
array_multisort($ranks, SORT_DESC, $data);   

$areas_arr = array_reduce($areas, 'array_merge', array());

foreach ($areas_arr as $k=>$v) {
    // 投稿数量
    // $count = DB::table('works')
    //             ->leftJoin('consumer', 'works.ConsumerId', '=', 'consumer.Id')
    //             ->select('works.Id', 'consumer.CityId', 'consumer.AreaId')
    //             ->where('consumer.AreaId', $v['Code'])
    //             ->count();
    $found_area_key = array_search($v['Code'],$found_area_arr);
    $found_area_count = $areas_count[$found_area_key]['num']; 
    $areas_arr[$k]['count'] = $found_area_count;
    $areas_arr[$k]['city'] = DB::table('xzq')->where('Code', $v['Parentid'])->value('Name');
    $areas_arr[$k]['count_score'] = $found_area_count*0.1;

    // $first = 0;
    $first = DB::table('awardswork')->where('AreaId', $v['Code'])->where('PrizeLevel', 1)->count();
    // $second = 0;
    $second = DB::table('awardswork')->where('AreaId', $v['Code'])->where('PrizeLevel', 2)->count();
    // $third = 0;
    $third = DB::table('awardswork')->where('AreaId', $v['Code'])->where('PrizeLevel', 3)->count();

    

    // foreach (array_slice(Cache::get('key1'), 0, 50) as $a=>$b){
    //     if($b['AreaId'] == $v['Code']){
    //         $first++;
    //     } 
    // }
    // foreach (array_slice(Cache::get('key1'), 50, 100) as $a=>$b){
    //     if($b['AreaId'] == $v['Code']){
    //         $second++;
    //     } 
    // }
    // foreach (array_slice(Cache::get('key1'), 150, 200) as $a=>$b){
    //     if($b['AreaId'] == $v['Code']){
    //         $third++;
    //     } 
    // }



    // foreach (array_slice(Cache::get('key2'), 0, 50) as $a=>$b){
    //     if($b['AreaId'] == $v['Code']){
    //         $first++;
    //     } 
    // }
    // foreach (array_slice(Cache::get('key1'), 50, 100) as $a=>$b){
    //     if($b['AreaId'] == $v['Code']){
    //         $second++;
    //     } 
    // }
    // foreach (array_slice(Cache::get('key1'), 150, 200) as $a=>$b){
    //     if($b['AreaId'] == $v['Code']){
    //         $third++;
    //     } 
    // }


    // foreach (array_slice(Cache::get('key3'), 0, 50) as $a=>$b){
    //     if($b['AreaId'] == $v['Code']){
    //         $first++;
    //     } 
    // }
    // foreach (array_slice(Cache::get('key1'), 50, 100) as $a=>$b){
    //     if($b['AreaId'] == $v['Code']){
    //         $second++;
    //     } 
    // }
    // foreach (array_slice(Cache::get('key1'), 150, 200) as $a=>$b){
    //     if($b['AreaId'] == $v['Code']){
    //         $third++;
    //     } 
    // }


    $areas_arr[$k]['first'] = $first;
    $areas_arr[$k]['first_score'] = $first*20;

    $areas_arr[$k]['second'] = $second;
    $areas_arr[$k]['second_score'] = $second*10;

    $areas_arr[$k]['third'] = $third;
    $areas_arr[$k]['third_score'] = $third*5;

    $areas_arr[$k]['total_score'] = $third*5+$first*20+$second*10+$found_area_count*0.1;
}
$areas_ranks = array_column($areas_arr,'total_score');
array_multisort($areas_ranks, SORT_DESC, $areas_arr); 
Cache::put('city_data', $data);
Cache::put('area_data', $areas_arr);
        }
        
       
        // dd($areas_arr);
        return view('ranks.city',compact('data', 'areas_arr'));
    }
}
