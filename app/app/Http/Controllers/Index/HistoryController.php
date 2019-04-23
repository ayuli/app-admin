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
            'add_htime'=>$time
        );
        $data = array(
            'goods_id'=>$goodsis,
            'user_id'=>$uid
        );
        $selectgoods = DB::table('app_history')->where($data)->first();
        if ($selectgoods){
            $res = DB::table('app_history')->where('goods_id',$goodsis)->update($info);
        }else{
            $res = DB::table('app_history')->insert($info);
        }
        if($res){
            return 1;
        }else{
            return 2;
        }
    }
    //展示浏览记录
    public function showhistory(Request $request){
        $uid = $request->uid;
        $res = DB::table('app_history')->join('app_goods','app_goods.goods_id','=','app_history.goods_id')->where('user_id',$uid)->get();
        foreach($res as $k =>$v){
            $res[$k]->add_htime=date("Y-m-d H:i:s",$res[$k]->add_htime);
        }
        $data=array(
            'res'=>$res,
            'num'=>count($res),
        );
        return $res;
    }
    //删除浏览记录
    public function delhistory(Request $request){
        $id = $request->id;
        $res = DB::table('app_history')->where('history_id',$id)->delete();
        if($res){
            return 1;
        }else{
            return 2;
        }
    }
    //删除所有浏览记录
    public function delahistory(){
        $res = DB::table('app_history')->delete();
        if($res){
            return 1;
        }else{
            return 2;
        }
    }
}
