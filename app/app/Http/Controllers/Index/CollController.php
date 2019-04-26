<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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
        if($user_id==null){
            $result = [ 'code'=>1000 , 'msg'=>'请先登录' ];
            return json_encode($result,JSON_UNESCAPED_UNICODE);
        }
        $add_time = time();
        $data = [
            'user_id' => $user_id,
            'goods_id'  => $goods_id,
            'add_time'  =>$add_time
        ];
        $arr = CollModel::where(['user_id'=>$user_id,'goods_id'=>$goods_id])->get();
        if(count($arr)>0){
            $result = [ 'code'=>100 , 'msg'=>'该商品已收藏' ];
            return json_encode($result,JSON_UNESCAPED_UNICODE);
        }
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
        $rec_id = $request->input('rec_id');
        $res = CollModel::where(['user_id'=>$user_id,'rec_id'=>$rec_id])->delete();

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
		foreach($data as $k =>$v){
            $data[$k]->add_time=date("Y-m-d H:i:s",$data[$k]->add_time);
        }
		$num=count($data);
		if($num!==0){
			$result = [ 'code'=>0 , 'data'=>$data ,'num'=>$num];
			return json_encode($result,JSON_UNESCAPED_UNICODE);
		}else{
			$result = [ 'code'=>110 , 'msg'=>'查询失败' ];
            return json_encode($result,JSON_UNESCAPED_UNICODE);
		}
    }
    //删除全部收藏
    public function delconllection(Request $request)
    {
        $user_id = $request->input('user_id');
        $res = DB::table('app_collection')->where('user_id',$user_id)->delete();
        if ($res){
            return 1;
        }
    }

}
