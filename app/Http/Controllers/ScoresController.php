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
        $is_inspected = DB::table('users')->where('group_id', Auth::user()->inspected)->where('inspected', 1)->first();
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
            Session::put('user_page2_'.Auth::user()->id,  $page);
        } else {
            if (Session::get('user_page2_'.Auth::user()->id) != null){
                $page = Session::get('user_page2_'.Auth::user()->id);
                }
        }
        $limit = ($page-1)*$size;
        
        $api_url = 'http://192.168.9.125:8085/api/WorkApi/';
        $img_url = 'https://aqjy.newssc.org';
        $group_id = Auth::user()->group_id;
       
        $is_scored_items = DB::table('scores')->where('user_id', Auth::user()->id)->get('item_id')->map(function ($value) {
            return (array)$value;
        })->toArray();

        if ($is_scored_items == null ){
            $works = DB::select("select DISTINCT a.item_id from user_item a LEFT JOIN users b ON  a.user_id=b.id where b.group_id=$group_id AND (a.item_id) in (select item_id from user_item group by item_id having count(*) = 3) AND status = 1 AND a.item_id limit $limit,$size");

            $total = count(array_map('get_object_vars', DB::select("select a.item_id from user_item a LEFT JOIN users b ON  a.user_id=b.id where b.group_id=$group_id AND (a.item_id) in (select item_id from user_item group by item_id having count(*) = 3) AND status = 1 AND a.item_id "))); 
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
            DB::table('scores')->updateOrInsert(
                ['user_id'=>$user_id, 'item_id'=>$item_id], 
                ['score'=>$score],
                );
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
}
