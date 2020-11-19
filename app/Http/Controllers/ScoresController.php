<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Support\Facades\Session;
use App\Exceptions\InvalidRequestException;

class ScoresController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index(Request $request, $size = 4, $page = 1, $scored_status = 0)
    {
        $finished_score = Auth::user()->is_scored;
        $is_inspected = DB::table('users')->where('group_id', Auth::user()->group_id)->where('inspected', 1)->first();
        if ( $is_inspected == null) {
            throw new InvalidRequestException('您的当前组还未完成初选！');
        }
        if ($finished_score == 1) {
            throw new InvalidRequestException('您已完成评分，请等待公示结果！');
        }

        

        if ($request->get('scored_status') !=null) {
            $scored_status = $request->get('scored_status');
        }

        
        if ($request->get('page') !=null && $size = $request->get('size') != null){
            $page = $request->get('page');
            $size = $request->get('size');
            // Session::put('user_page2_'.Auth::user()->id,  $page);
        }
        //  else {
        //     if (Session::get('user_page2_'.Auth::user()->id) != null){
        //         $page = Session::get('user_page2_'.Auth::user()->id);
        //         }
        // }
        $limit = ($page-1)*$size;
        
        $api_url = config('app.api_url').'/api/WorkApi/';
        $img_url = config('app.img_url');
        $group_id = Auth::user()->group_id;
       
        $is_scored_items = DB::table('scores')->where('user_id', Auth::user()->id)->get('item_id')->map(function ($value) {
            return (array)$value;
        })->toArray();

        if ($is_scored_items == null ){
            $works = DB::select("select DISTINCT a.item_id from user_item a LEFT JOIN users b ON  a.user_id=b.id where b.group_id=$group_id AND (a.item_id) in (select item_id from user_item group by item_id having count(*) = 3) AND status = 1 AND a.item_id limit $limit,$size");

            $total = count(array_map('get_object_vars', DB::select("select a.item_id from user_item a LEFT JOIN users b ON  a.user_id=b.id where b.group_id=$group_id AND (a.item_id) in (select item_id from user_item group by item_id having count(*) = 3) AND status = 1 AND a.item_id ")))/3; 
        }else{
            $is_scored_item = [];
            foreach ($is_scored_items as $v) {
                $is_scored_item[]=$v['item_id'];
            }
            $str_items = implode(',',$is_scored_item);
    
            if ($scored_status == 0){
                $works = DB::select("select DISTINCT a.item_id from user_item a LEFT JOIN users b ON  a.user_id=b.id where b.group_id=$group_id AND (a.item_id) in (select item_id from user_item group by item_id having count(*) = 3) AND status = 1 AND a.item_id NOT IN ($str_items) limit $limit,$size");
    
                $total = count(array_map('get_object_vars', DB::select("select a.item_id from user_item a LEFT JOIN users b ON  a.user_id=b.id where b.group_id=$group_id AND (a.item_id) in (select item_id from user_item group by item_id having count(*) = 3) AND status = 1 AND a.item_id NOT IN ($str_items)")))/3; 

                
            }else{
                $works = DB::select("select DISTINCT a.item_id from user_item a LEFT JOIN users b ON  a.user_id=b.id where b.group_id=$group_id AND (a.item_id) in (select item_id from user_item group by item_id having count(*) = 3) AND status = 1 AND a.item_id IN ($str_items) limit $limit,$size");
    
                $total = count(array_map('get_object_vars', DB::select("select a.item_id from user_item a LEFT JOIN users b ON  a.user_id=b.id where b.group_id=$group_id AND (a.item_id) in (select item_id from user_item group by item_id having count(*) = 3) AND status = 1 AND a.item_id IN ($str_items)")))/3; 

            }
        }
       

        // dd($works);
        $data = [];
            foreach (array_map('get_object_vars', $works) as $v) {
                $json = (array) json_decode(file_get_contents($api_url.$v['item_id']));
                $data[] = (array) $json['data'];
            }
            
        $works = $data;
        
        foreach ($works as $k=>$v) {
            $is_scored = DB::table('scores')->where('user_id', Auth::user()->id)->where('item_id', $v['id'])->first();
            if ($is_scored != null){
                $works[$k]['score'] = DB::table('scores')->where('user_id', Auth::user()->id)->where('item_id', $v['id'])->value('score');
            }else{
                $works[$k]['score'] = -1;
            }

            if (strlen($v['samllImage']) > 90){
                $works[$k]['samllImage'] = str_replace(',', $img_url,strrchr($img_url.$v['samllImage'],',')) ; 
            } else {
                $works[$k]['samllImage'] = $img_url.$v['samllImage']; 
            }
            
            // if(in_array($v['id'], $ids)){
            //     $works[$k]['status'] = 1;
            // }else{
            //     $works[$k]['status'] = 0;
            // }
        }

        

        $r_url = route('score.index');
        $total_page = ceil($total/$size);
        $pre_page = $page - 1;
        $next_page = $page + 1;
        $pre_url = route('score.index')."?page=$pre_page&size=$size&scored_status=$scored_status";
        $next_url = route('score.index')."?page=$next_page&size=$size&scored_status=$scored_status";

        return view('scores.index', compact('works', 'total', 'page','total_page', 'r_url','pre_page', 'next_page', 'pre_url', 'next_url', 'scored_status'));
    }

    public function store(Request $request)
    {
        if($request->ajax()){
            $item_id = $request->get('id');
            $user_id = Auth::user()->id;
            $score = $request->get('score');
            
        if (preg_match('/^[0-9]+(.[0-9]{1,2})?$/', $score )) {
            DB::table('scores')->updateOrInsert(
                ['user_id'=>$user_id, 'item_id'=>$item_id], 
                ['score'=>$score],
                );
        }else{
            return 201;
        }

            return 200;
        }else{
            return false;
        }
    }

    public function confirm(Request $request)
    {
        if($request->ajax()){
            if($request->get('confirm_score') ==1 ){
                $scores = DB::table('scores')->where('user_id', Auth::user()->id)->count(); 
                if( $scores == 2000){
                    DB::table('users')->where('id', Auth::user()->id)->update(['is_scored'=>1]);
                    return 200;
                }else{
                    return 201;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function detail($id)
    {
        $data = (array) json_decode(file_get_contents(config('app.api_url').'/api/WorkApi/'.$id));
        $data = $data['data'];
        $data->bigImage = config('app.img_url').$data->bigImage;
        return view('scores.detail', compact('data'));
    }

    public function show(Request $request, $group_id=1)
    {

        if(Auth::user()->is_scored == 0){
            if(Auth::user()->group_id != 0 && Auth::user()->group_id != 4){
                throw new InvalidRequestException('您还未完成评分！');
            }
        }

        if($request->get('group_id') != null){
            $group_id = $request->get('group_id');
        }

        if($group_id ==1 ){
            $data =  DB::select("SELECT item_id,
            MAX(IF(`user_id`=1,score,-1)) as 'z1',
            MAX(IF(`user_id`=2,score,-1)) as 'z2',
            MAX(IF(`user_id`=3,score,-1)) as 'z3',
            MAX(IF(`user_id`=10,score,-1)) as 'z10',
            MAX(IF(`user_id`=11,score,-1)) as 'z11',
            MAX(IF(`user_id`=12,score,-1)) as 'z12',
            MAX(IF(`user_id`=13,score,-1)) as 'z13' 
            FROM scores WHERE item_id<2001
            GROUP BY item_id
            ");
        }


        if($group_id ==2 ){
            $data =  DB::select("SELECT item_id,
            MAX(IF(`user_id`=33,score,-1)) as 'z1',
            MAX(IF(`user_id`=5,score,-1)) as 'z2',
            MAX(IF(`user_id`=6,score,-1)) as 'z3',
            MAX(IF(`user_id`=14,score,-1)) as 'z10',
            MAX(IF(`user_id`=15,score,-1)) as 'z11',
            MAX(IF(`user_id`=16,score,-1)) as 'z12',
            MAX(IF(`user_id`=17,score,-1)) as 'z13' 
            FROM scores WHERE item_id>2000 AND item_id<4001
            GROUP BY item_id
            ");
        }

        if($group_id ==3 ){
            $data =  DB::select("SELECT item_id,
            MAX(IF(`user_id`=7,score,-1)) as 'z1',
            MAX(IF(`user_id`=8,score,-1)) as 'z2',
            MAX(IF(`user_id`=9,score,-1)) as 'z3',
            MAX(IF(`user_id`=18,score,-1)) as 'z10',
            MAX(IF(`user_id`=19,score,-1)) as 'z11',
            MAX(IF(`user_id`=20,score,-1)) as 'z12',
            MAX(IF(`user_id`=21,score,-1)) as 'z13' 
            FROM scores WHERE item_id>4000 
            GROUP BY item_id
            ");
        }

        // dd($data);

        foreach ($data as $k=>$v) {
            $data[$k]->last_score = 0;
            $arr=[];
            foreach ($v as $a=>$b){
                if($a != 'item_id'){
                    $arr[]=$b;
                }
                if($b == -1){
                    $data[$k]->last_score = -1;
        }
    }
    
       if ($data[$k]->last_score == 0){
            unset($arr[7]);
            $min = min($arr);
            $max = max($arr);
            $last_score = (array_sum($arr) - $min - $max)/5;
            $data[$k]->last_score = round($last_score, 3);
       }

    }

    $a = [];
    foreach($data as $k=>$v){
        $a[] = $v->last_score; 
    }

    $d =[];
    foreach ($data as $k=>$v) {
    $m = [];
        foreach ($v as $i=>$j) {
        $m[$i] = $j;
        }
        $d[$k] = $m;
    }
    
    array_multisort($a, SORT_DESC,$d);
    

    // foreach ($d as $v){
    //     DB::table('last_scores')->insert([
    //         'item_id' => $v['item_id'],
    //         'z1'=>$v['z1'],
    //         'z2'=>$v['z2'],
    //         'z3'=>$v['z3'],
    //         'z4'=>$v['z10'],
    //         'z5'=>$v['z11'],
    //         'z6'=>$v['z12'],
    //         'z7'=>$v['z13'],
    //         'last_score'=>$v['last_score'],
    //         'group_id'=>$group_id

    //     ]);
    // }
    
    return view('scores.show', compact('d'));

    }

    public function last_score(Request $request, $group_id=1)
    {

        if ( Auth::user()->group_id !=4) {
            throw new InvalidRequestException('请终审评委进入终审阶段！');
        }

        if($request->get('group_id') != null){
            $group_id = $request->get('group_id');
        }

        if ($group_id == 1) {
            $data = DB::select('select * from last_scores where group_id=1 order by (last_score+0) DESC');
        }
        if ($group_id == 2) {
            $data = DB::select('select * from last_scores where group_id=2 order by (last_score+0) DESC');
        }
        
        if ($group_id == 3) {
            $data = DB::select('select * from last_scores where group_id=3 order by (last_score+0) DESC');
        }
        
        
        
        $true_ids = DB::table('user_last_score')->where('user_id', Auth::user()->id)->where('status', 1)->get('item_id');

        $false_ids = DB::table('user_last_score')->where('user_id', Auth::user()->id)->where('status', 2)->get('item_id');

        $a=[];
        $b=[];
        foreach($true_ids as $v){
            $a[]=$v->item_id;
        }

        foreach($false_ids as $v){
            $b[]=$v->item_id;
        }

        switch (Auth::user()->id) {
            case 30:
                $user2=31;
                $user3=32;
                break;
            case 31:
                $user2=30;
                $user3=32;
                break;
            case 32:
                $user2=30;
                $user3=31;
                break;    
        }

        foreach($data as $k=>$v){
            $data[$k]->status2 =  DB::table('user_last_score')->where('user_id',$user2)->where('item_id',$v->item_id)->value('status');
            $data[$k]->status3 =  DB::table('user_last_score')->where('user_id',$user3)->where('item_id',$v->item_id)->value('status');
            if (in_array($v->item_id, $a)){
                $data[$k]->status = 1;
            }elseif(in_array($v->item_id, $b)){
                $data[$k]->status = 2;
            }
            else{
                $data[$k]->status = 0;
            }
        }

  
        return view('scores.last', compact('data'));
    }

    public function last_score_choose(Request $request)
    {
        if ($request->ajax()){
            DB::table('user_last_score')->updateOrInsert(
                [
                    'user_id'=>$request->get('user_id'),
                    'item_id'=>$request->get('item_id')],
                [
                    'status'=>$request->get('status')
                ]);

        }else{
            return false;
        }
    }

    public function last_score_confirm(Request $request)
    {

        if ($request->ajax()){
            $one = DB::select(' SELECT u.item_id count  FROM user_last_score u LEFT JOIN last_scores l on u.item_id = l.item_id where u.status = 1 AND l.group_id=1 GROUP BY u.item_id HAVING count(*)>2');
            $count_1 = count($one);

            $two = DB::select(' SELECT u.item_id count  FROM user_last_score u LEFT JOIN last_scores l on u.item_id = l.item_id where u.status = 1 AND l.group_id=2 GROUP BY u.item_id HAVING count(*)>2');
            $count_2 = count($two);

            $three = DB::select(' SELECT u.item_id count  FROM user_last_score u LEFT JOIN last_scores l on u.item_id = l.item_id where u.status = 1 AND l.group_id=3 GROUP BY u.item_id HAVING count(*)>2');
            $count_3 = count($three);

            if ($count_1!=1000 && $count_2!=1000 && $count_3!=1000){
                $count = [$count_1, $count_2, $count_3];
          
                return json_encode($count,true);
            }else{
                return 200;
            }
            

        }else{
            return false;
        }
    }
}
