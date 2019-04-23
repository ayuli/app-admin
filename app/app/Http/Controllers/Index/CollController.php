<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\CollModel;

class CollController extends Controller
{
    /**
     *  收藏 url :  collection
     *  post
     *  参数 user_id  goods_id
     *  return  'code'=>0 , 'msg'=>'收藏成功'
     */
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

    /**
     * 取消收藏 url : uncollection
     *  参数 user_id goods_id
     *  return 'code'=>0 , 'msg'=>'已取消收藏'
     */
    public function uncoll(Request $request)
    {
        $user_id = $request->input('user_id');
        $goods_id = $request->input('goods_id');

        $res = CollModel::where(['user_id'=>$user_id,'goods_id'=>$goods_id])->delete();
        if($res){
            $result = [ 'code'=>0 , 'msg'=>'已取消收藏' ];
            return json_encode($result,JSON_UNESCAPED_UNICODE);
        }else{
            $result = [ 'code'=>110 , 'msg'=>'取消失败' ];
            return json_encode($result,JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 展示收藏
     *  url collectionget
     *  get
     */
    public function collGet(Request $request)
    {
        $user_id = $request->input('user_id');
        $data = CollModel::join('app_goods','app_collection.goods_id','=','app_goods.goods_id')->where(['app_collection.user_id'=>$user_id])->get();
		$num=count($data);
		if($num!==0){
			$result = [ 'code'=>0 , 'data'=>$data ,'num'=>$num];
			return json_encode($result,JSON_UNESCAPED_UNICODE);
		}else{
			$result = [ 'code'=>110 , 'msg'=>'查询失败' ];
            return json_encode($result,JSON_UNESCAPED_UNICODE);
		}
    }


}
