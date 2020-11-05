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
        if ($request->get('page') !=null && $size = $request->get('size') != null){
            $page = $request->get('page');
            $size = $request->get('size');
        }
        $url = 'https://aqjy.newssc.org';
        $group_id = Auth::user()->group_id;
        $data = file_get_contents("http://192.168.9.125:8085/api/WorkApi/list?page=$page&size=$size&group=$group_id");
        $data = json_decode($data,true);

        $r_url = route('check.pre');
        $works = $data['data'];
        $total = $data['count'];

        $item_ids =DB::table('user_item')->where('user_id', Auth::user()->id)->where('status', 1)->get('item_id')->toArray();

        $ids = [];
        if ($item_ids != null) {
            foreach ($item_ids as $id) {
                $ids[] = $id->item_id;
            }
        }


        
        foreach ($works as $k=>$v) {
            $works[$k]['samllImage'] = $url.$v['samllImage']; 
            $works[$k]['bigImage']   = $url.$v['bigImage']; 
            if(in_array($v['id'], $ids)){
                $works[$k]['status'] = 1;
            }else{
                $works[$k]['status'] = 0;
            }
        }

        
        return view('pages.index', compact('works', 'total', 'page' , 'r_url'));
    }

    public function pre_store(Request $request)
    {
        $id = $request->get('id');
        $query = DB::table('user_item')->where('user_id', Auth::user()->id)->where('item_id', $id)->first();
        
        if($query == null) {
            DB::table('user_item')->insert(
                ['user_id' => Auth::user()->id, 
                 'item_id' => $id, 
                 'status'  => 1
            ]);
        
        }else{
            if ($query->status == 1){
                DB::table('user_item')->where('user_id', Auth::user()->id)->where('item_id', $id)->update(['status'=> 0]);
            }else{
                DB::table('user_item')->where('user_id', Auth::user()->id)->where('item_id', $id)->update(['status'=>1]);
            }
        }

        return 200;
    }
}
