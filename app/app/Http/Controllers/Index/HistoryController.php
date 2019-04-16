<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    //添加浏览记录
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
    //展示浏览记录
    public function showhistory(Request $request){
        $uid = $request->uid;
        $res = DB::table('app_histort')->where('user_id',$uid)->get();
        $time = $res->addtime;
        $goodsid = $res->goods_id;
        $goodsname = DB::table('app_goods')->where('goods_id',$goodsid)->first('goods_name');
        $info = array(
            'goods_name'=>$goodsname,
            'addtime'=>$time
        );
        return $info;
    }
}
