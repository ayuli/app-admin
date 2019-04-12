<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\CollModel;

class CollController extends Controller
{
    //收藏
    public function coll(Request $request){
        $user_id = $request->input('user_id');
        $goods_id = $request->input('goods_id');
        $add_time = time();
        $data = [
            'user_id' => $user_id,
            'goods_id'  => $goods_id,
            'add_time'  =>$add_time
        ];
        $res = CollModel::insert($data);
        if($res){
            $result = [ 'code'=>0 , 'msg'=>'收藏成功' ];
            return json_encode($result,JSON_UNESCAPED_UNICODE);
        }else{
            $result = [ 'code'=>110 , 'msg'=>'收藏失败' ];
            return json_encode($result,JSON_UNESCAPED_UNICODE);
        }


        
    }


}
