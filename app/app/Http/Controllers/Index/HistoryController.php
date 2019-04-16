<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    public function addhistory(Request $request){
        $goodsis = $request->goodsid;
        $uid = $request->uid;
        $time = time();
        $info = array(
            'user_id'=>$uid,
            'goods_id'=>$goodsis,
            'add_time'=>$time
        );
        $res = DB::table('app_history')->insert($info);
        if($res){
            return 1;
        }else{
            return 2;
        }
    }
}
