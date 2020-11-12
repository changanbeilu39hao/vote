<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Encore\Admin\Widgets\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index(Request $request)
    {
        // $data = DB::select('select * from user_item a where (a.item_id) in (select item_id from user_item group by item_id having count(*) > 1)');

        $inspected = DB::table('users')->where('id', Auth::user()->id)->value('inspected');
        if ($inspected == 1) {
            throw new InvalidRequestException('您已完成作品审查！');
        }

        // $totle = DB::table('user_item')->where('user_id', Auth::user()->id)->count();

        // if($totle == 30) {
        //     Session::put('totle_'.Auth::user()->id, 1);
        // }

        $group_id = Auth::user()->group_id;
        

        if ($request->get('level') != null){
            if ($request->get('level') == 2){
                
            }
            if ($request->get('level') == 3){

            }
            
        }else{
            $data = DB::table('works')->where('group_id', $group_id)->paginate(4);
        };

        

        $selected_ids = DB::table('user_item')
                        ->where('user_id', Auth::user()->id)
                        ->where('status', 1)
                        ->get('item_id')
                        ->toArray();
        $ids = [];
        if ($selected_ids != null) {
            foreach ($selected_ids as $id) {
                $ids[] = $id->item_id;
            }
        }
        return view('pages.index', compact('data', 'ids'));
    
    }

    public function store(Request $request)
    {
        $currentIds = $request->get('all_ids');
        $chosenIds = $request->get('work_ids');

        if ($currentIds != null){
            foreach($currentIds as $id){
                $query = DB::table('user_item')->where('user_id', Auth::user()->id)->where('item_id', $id);
                if($query->first() == null) {
                    DB::table('user_item')->insert(
                        ['user_id' => Auth::user()->id, 
                         'item_id' => $id, 
                         'status'  => 0
                        ],
                    );
                }else{
                    $query->update(
                        ['status'  => 0],
                    );
                }
            }
        }


       if($chosenIds != null){
        foreach ($chosenIds as $id) {
            $query = DB::table('user_item')->where('user_id', Auth::user()->id)->where('item_id', $id)->where('status', 0)->first();
            if($query != null) {
                DB::table('user_item')->where('user_id', Auth::user()->id)->where('item_id', $id)->update(
                    ['status' => 1]
                );
            }
        }
       }


        return redirect($request->get('page'));
    }

    public function confirm()
    {
        if(Session::get('totle_'.Auth::user()->id) == 1 ){
            DB::table('users')->where('id', Auth::user()->id)->update(['inspected'=>1]);
            throw new InvalidRequestException('您已完成作品审查！');
        }
        throw new InvalidRequestException('您已完成作品审查！');
    }


    public function pre(Request $request, $page=1, $size=4)
    {
        if(Auth::user()->id>21){
            $group_id = $request->get('group_id');
            if ($group_id == null){
                $group_id = 1;
            }
        }else{
            $group_id = Auth::user()->group_id;
        }

        $inspected = DB::table('users')->where('id', Auth::user()->id)->where('group_id', $group_id)->where('inspected', 1)->first();
        if ($inspected !=null ) {
            throw new InvalidRequestException('此组已完成作品审查，请前往评分平台！');
        }

      
        // 作品数据
        if ($request->get('page') !=null && $size = $request->get('size') != null){
            $page = $request->get('page');
            $size = $request->get('size');
            Session::put('user_page_'.Auth::user()->id,  $page);
        } else {
            if (Session::get('user_page_'.Auth::user()->id) != null){
                $page = Session::get('user_page_'.Auth::user()->id);
        }
        }
        $level_limit = ($page-1)*$size;

        $level_1_count = count(array_map('get_object_vars', DB::select("select a.item_id from user_item a LEFT JOIN users b ON  a.user_id=b.id where b.group_id=$group_id AND (a.item_id) in (select item_id from user_item group by item_id having count(*) = 1) AND status = 1"))); 

        $level_2_count = count(array_map('get_object_vars', DB::select("select a.item_id from user_item a LEFT JOIN users b ON  a.user_id=b.id where b.group_id=$group_id AND (a.item_id) in (select item_id from user_item group by item_id having count(*) = 2) AND status = 1")))/2; 

        $level_3_count = count(array_map('get_object_vars', DB::select("select a.item_id from user_item a LEFT JOIN users b ON  a.user_id=b.id where b.group_id=$group_id AND (a.item_id) in (select item_id from user_item group by item_id having count(*) = 3) AND status = 1")))/3; 


        $data = file_get_contents(config('app.api_url')."/api/WorkApi/list?page=$page&size=$size&group=$group_id");
        $data = json_decode($data,true);

        $_level = 0;
        if ($request->get('level') != null && $request->get('level') != 0 ){
            $_level = $request->get('level');
            $level_url = config('app.api_url').'/api/WorkApi/';
            $level_data = [];
            $level_page = $request->get('level');
            switch ($level_page) {
                case 1:

                    $data['count'] = $level_1_count;
                    $level_1 = DB::select("select DISTINCT a.item_id from user_item a LEFT JOIN users b ON  a.user_id=b.id where b.group_id=$group_id AND (a.item_id) in (select item_id from user_item group by item_id having count(*) = 1) AND status = 1 limit $level_limit,$size;");

                    foreach (array_map('get_object_vars', $level_1) as $v) {
                        $level_json = (array) json_decode(file_get_contents($level_url.$v['item_id']));
                        $level_data[] = (array) $level_json['data'];
                    }
                    break;
                case 2:

                    $data['count'] = $level_2_count;

                    $level_2 = DB::select("select DISTINCT a.item_id from user_item a LEFT JOIN users b ON  a.user_id=b.id where b.group_id=$group_id AND (a.item_id) in (select item_id from user_item group by item_id having count(*) = 2) AND status = 1 limit $level_limit,$size;");
                    foreach (array_map('get_object_vars', $level_2) as $v) {
                        $level_json = (array) json_decode(file_get_contents($level_url.$v['item_id']));
                        $level_data[] =(array)  $level_json['data'];
                    }
                    break;
                case 3:

                    $data['count'] = $level_3_count;

                    $level_3 = DB::select("select DISTINCT a.item_id from user_item a LEFT JOIN users b ON  a.user_id=b.id where b.group_id=$group_id AND (a.item_id) in (select item_id from user_item group by item_id having count(*) = 3) AND status = 1 limit $level_limit,$size;");
                    foreach (array_map('get_object_vars', $level_3) as $v) {
                        $level_json = (array) json_decode(file_get_contents($level_url.$v['item_id']));
                        $level_data[] = (array) $level_json['data'];
                    }
            }
            $works = $level_data;

        }elseif ($request->get('search_id') != null){
            $search_id = (array) json_decode(file_get_contents(config('app.api_url')."/api/WorkApi/".$request->get('search_id')));
            

            if (Auth::user()->group_id == 0){
                $group_name = '观察组';
            }
            if (Auth::user()->group_id == 1){
                $group_name = '小学1-3年级组';
            }
            if (Auth::user()->group_id == 2){
                $group_name = '小学4-6年级组';
            }
            if (Auth::user()->group_id == 3){
                $group_name = '初中组';
            }

            if($search_id['data']->groupType != $group_name){
                if ($group_name == '观察组'){
                    $works[0] = (array)$search_id['data'];
                    $data['count'] = 2;
                }else{
                    throw new InvalidRequestException('未在该组找到该作品！');
                }
                
            } else {
                $works[0] = (array)$search_id['data'];
                $data['count'] = 2;
            }

        }
        else{
            $data = file_get_contents(config('app.api_url')."/api/WorkApi/list?page=$page&size=$size&group=$group_id");
            $data = json_decode($data,true);
            $works = $data['data'];
  
        }
    
        $url = config('app.img_url');
        
        // 页码
        $r_url = route('check.pre');
        $total = $data['count'];
        $total_page = ceil($total/$size);
        $pre_page = $page - 1;
        $next_page = $page + 1;
        $pre_url = route('check.pre')."?page=$pre_page&size=$size&group=$group_id&level=$_level";
        $next_url = route('check.pre')."?page=$next_page&size=$size&group=$group_id&level=$_level";

        // 已选作品
        $item_ids =DB::table('user_item')->where('user_id', Auth::user()->id)->where('status', 1)->get('item_id')->toArray();
        $ids = [];
        if ($item_ids != null) {
            foreach ($item_ids as $id) {
                $ids[] = $id->item_id;
            }
        }
        $count_ids = count($ids); 
        Session::put('user_count_'.Auth::user()->id, $count_ids);

            foreach ($works as $k=>$v) {
                if (strlen($v['samllImage']) > 90){
                    $works[$k]['samllImage'] = str_replace(',', $url,strrchr($url.$v['samllImage'],',')) ; 
                    $works[$k]['bigImage']   = str_replace(',', $url,strrchr($url.$v['bigImage'], ',')); 
                } else {
                    $works[$k]['samllImage'] = $url.$v['samllImage']; 
                    $works[$k]['bigImage']   = $url.$v['bigImage']; 
                }
                
                if(in_array($v['id'], $ids)){
                    $works[$k]['status'] = 1;
                }else{
                    $works[$k]['status'] = 0;
                }
            }

        // 
        $works_num = [];
        $works_num['level_1'] = $level_1_count;
        $works_num['level_2'] = $level_2_count;
        $works_num['level_3'] = $level_3_count;

        return view('pages.index', compact(
            'works', 'total', 'page' , 'r_url', 
            'pre_url', 'next_url', 'total_page',
            'works_num'

        ));
    }

    public function pre_store(Request $request)
    {
        if ($request->ajax()){

            $id = $request->get('id');
            $query = DB::table('user_item')->where('user_id', Auth::user()->id)->where('item_id', $id)->first();
            
            if($query == null) {
                DB::table('user_item')->insert(
                    ['user_id' => Auth::user()->id, 
                     'item_id' => $id, 
                     'status'  => 1
                ]);
            
            }else{
                DB::table('user_item')->where('user_id', Auth::user()->id)->where('item_id', $id)->delete();
            }
    
            return 200;
        }else{
            return false;
        }

    }


    public function pre_confirm(Request $request)
    {
        if ($request->ajax()){
            $user_id = $request->get('user_id');
            $group_id = DB::table('users')->where('id', $user_id)->value('group_id');
            $level_3_count = count(array_map('get_object_vars', DB::select("select a.item_id from user_item a LEFT JOIN users b ON  a.user_id=b.id where b.group_id=$group_id AND (a.item_id) in (select item_id from user_item group by item_id having count(*) = 3) AND status = 1")))/3; 

            if(in_array(Auth::user()->id, [1,4,7]) ){
                if ($level_3_count == config('app.level_3_count')) {
                    DB::table('users')->where('id', $user_id)->update(['inspected'=>1]);
                    return 200;
                }else{
                    return 201;
                }
            }else{
                return 202;
            }


            
        }else{
            return false;
        }
    }

}
