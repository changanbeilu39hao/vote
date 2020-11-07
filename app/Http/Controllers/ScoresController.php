<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ScoresController extends Controller
{
    public function index(Request $request, $size=4, $page=1)
    {
        $limit = ($page-1)*$size;
        $url = 'http://192.168.9.125:8085/api/WorkApi/';
        $group_id = Auth::user()->group_id;
        dd($group_id);
        $works = DB::select("select a.item_id from user_item a LEFT JOIN users b ON  a.user_id=b.id where b.group_id=$group_id AND (a.item_id) in (select item_id from user_item group by item_id having count(*) = 1) AND status = 1 limit $limit,$size;");
            foreach (array_map('get_object_vars', $works) as $v) {
                $json = (array) json_decode(file_get_contents($url.$v['item_id']));
                $data[] = (array) $json['data'];
            }
            
        $works = $data;
        return view('scores.index', compact('works'));
    }
}
