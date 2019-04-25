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
        $type=$request->input('type','is_del');
        $search=$request->input('search',"");

        $where=[];

        if($type=="pricex"){
            $column="goods_price";
            $order="asc";
        }else if($type=="prices"){
            $column="goods_price";
            $order="desc";
        }else{
            $column="goods_id";
            $order="asc";
            $where=[
                "$type"=>1
            ];
        }

        $page = $request->input('page',1);
        $page_num = 6;
        $start = ($page-1)*$page_num;

        $arr = GoodsModel::where('goods_name','like',"%$search%")->where($where)->orderBy($column,$order)->offset($start)->limit($page_num)->get();
        $count = count($arr);
        if ($count) {
            $data = ['code' => 0, 'data' => $arr,'count'=>$count];
            return json_encode($data, JSON_UNESCAPED_UNICODE);
        } else {
            $data = ['code' => 1102, 'msg' => '没有更多了!'];
            return json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }

}
