<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
class LastScoresController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index(Request $request)
    {
        
        $user = Auth::user()->name;
        $choose = DB::table('last_scores_2')->where($user,'!=',null)->pluck('item_id')->toArray();

        if($request->get('group_id') == null) {
            $group_id = 1;
        }else{
            $group_id = $request->get('group_id');
        }
        
        switch ($group_id) {
            case 1:
                $group = '小学1-3年级组';
                break;
            case 2:
                $group = '小学4-6年级组';
                break;
            case 3:
                $group = '初中组';
                break;
            default:
                $group = '小学1-3年级组';
            break;
        }
        
        if ($request->get('status') == 1) {
            $works = DB::table('votework')
            ->select('SamllImage', 'WorkId', "$user as a" )
            ->leftJoin('last_scores_2', 'votework.WorkId', '=', 'last_scores_2.item_id' )
            ->whereIn('votework.WorkId', $choose)
            ->where('votework.GroupType',  $group)
            ->orderByDesc('Id')
            ->paginate(4); 
            $status = 1;
        }

        if ($request->get('status') == 0){
            $works = DB::table('votework')
            ->select('SamllImage', 'WorkId', "$user as a")
            ->leftJoin('last_scores_2', 'votework.WorkId', '=', 'last_scores_2.item_id' )
            ->whereNotIn('votework.WorkId', $choose)
            ->where('votework.GroupType',  $group)
            ->orderByDesc('Id')
            ->paginate(4);
            $status = 0;
        }

        
           
        return view('scores.last_score', compact('works', 'status', 'group_id'));
    }
    

    public function store(Request $request)
    {
        if($request->ajax()){
            $item_id = $request->get('id');
            $name = Auth::user()->name;
            $score = $request->get('score');
            $group_id =(int)$request->get('group_id');
            
        if (preg_match('/^[0-9]+(.[0-9]{1,2})?$/', $score )) {
            DB::table('last_scores_2')->updateOrInsert(
                ['item_id'=>$item_id], 
                [$name=>$score,'group_id'=>$group_id],     
                );

            $item_id_obj =  DB::table('last_scores_2')->where('item_id', $item_id)->first();
            if (
                $item_id_obj->z1 != null && $item_id_obj->z2 != null &&
                $item_id_obj->z3 != null && $item_id_obj->z4 != null &&
                $item_id_obj->z5 != null && $item_id_obj->z6 != null &&
                $item_id_obj->z7 != null 
                ){
                    $arr = [$item_id_obj->z1,$item_id_obj->z2 ,$item_id_obj->z3 ,$item_id_obj->z4 ,$item_id_obj->z5 ,$item_id_obj->z6 ,$item_id_obj->z7 ];
                    
                    $min = min($arr);
                    $max = max($arr);
                    $last_score = (array_sum($arr) - $min - $max)/5;
                    DB::table('last_scores_2')
                        ->where('item_id', $item_id)
                        ->update(['last_score' => $last_score]);
                }
               
        }else{
            return 201;
        }

            return 200;
        }else{
            return false;
        }
    }
}
