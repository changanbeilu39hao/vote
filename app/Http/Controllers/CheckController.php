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
        $inspected = DB::table('users')->where('id', Auth::user()->id)->value('inspected');
        if ($inspected == 1) {
            throw new InvalidRequestException('您已完成作品审查！');
        }

        if (Auth::user()->id)

        $totle = DB::table('user_item')->where('user_id', Auth::user()->id)->count();

        if($totle == 30) {
            Session::put('totle_'.Auth::user()->id, 1);
        }

        if ($request->get('level') != null){
            if ($request->get('level') == 2){
                
            }
            if ($request->get('level') == 3){

            }
            
        }else{
            $data = DB::table('works')->paginate(4);
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
}
