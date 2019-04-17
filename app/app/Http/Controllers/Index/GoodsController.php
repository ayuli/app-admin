<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\GoodsModel;

class GoodsController extends Controller
{
    /**
     * 所有商品列表
     */
    public function goods(Request $request)
    {
        $type = $request->input('type','all');
        if($type=='all'){   //流加载

            $page = $request->input('page');
            $page_num = 6;

            $start = ($page-1)*$page_num;
            $arr = GoodsModel::offset($start)->limit($page_num)->get();
            $count = count($arr);
            if($count){
                $data = ['code'  => 0, 'data'  =>$arr];
                return json_encode($data,JSON_UNESCAPED_UNICODE);
            }else{
                $data = [ 'code'=>1102 , 'msg'=>'没有更多了!'];
                return json_encode($data,JSON_UNESCAPED_UNICODE);
            }

        }else if ($type=='hot'){
            $goods = GoodsModel::where(['is_hot'=>1])->limit(8)->get();
            $data = ['code'  => 0, 'data'  =>$goods];
            if($goods){
                return json_encode($data,JSON_UNESCAPED_UNICODE);
            }
        }else if($type=='new'){
            $goods = GoodsModel::where(['is_new'=>1])->limit(8)->get();
            $data = ['code'  => 0, 'data'  =>$goods];
            if($goods){
                return json_encode($data,JSON_UNESCAPED_UNICODE);
            }
        }else if($type=='best'){
            $goods = GoodsModel::where(['is_best'=>1])->limit(8)->get();
            $data = ['code'  => 0, 'data'  =>$goods ];
            if($goods){
                return json_encode($data,JSON_UNESCAPED_UNICODE);
            }
        }else if($type=='price'){   //价格
            $arrows = $request->input('arrows');
            $page = $request->input('page');
            $page_num = 6;

            $start = ($page-1)*$page_num;
            if($arrows=='↑'){
                $arr = GoodsModel::offset($start)->orderBy('goods_price','desc')->limit($page_num)->get();
            }else if($arrows=='↓'){
                $arr = GoodsModel::offset($start)->orderBy('goods_price','asc')->limit($page_num)->get();
            }

            $count = count($arr);
            if($count){
                $data = ['code'  => 0, 'data'  =>$arr];
                return json_encode($data,JSON_UNESCAPED_UNICODE);
            }else{
                $data = [ 'code'=>1102 , 'msg'=>'没有更多了!'];
                return json_encode($data,JSON_UNESCAPED_UNICODE);
            }
        }


    }


}
