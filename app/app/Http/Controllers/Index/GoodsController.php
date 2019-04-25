<?php

namespace App\Http\Controllers\Index;

use App\Model\CartModel;
use App\Model\CateModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\GoodsModel;
use Illuminate\Support\Facades\DB;

class GoodsController extends Controller
{
    /**
     * 所有商品列表
     */
    public function goods(Request $request)
    {
        $type=$request->input('type','is_del');
        $search=$request->input('search',"");

        $cate_id=$request->input('cate_id',"");

        $page = $request->input('page',1);


        $where=[];

        if($type=="pricex"){
            $column="goods_price";
            $order="asc";
        }else if($type=="prices"){
            $column="goods_price";
            $order="desc";
        }else if($type=="is_best"){
            $column="goods_id";
            $order="asc";
            $where=[ "$type"=>1];
        }else if($type=="is_new"){
            $column="goods_id";
            $order="desc";
            $where=[ "$type"=>1];
        }

        if(!isset($where['is_del'])){
            $where['is_del']=1;
        }

        $page_num = 6;
        $start = ($page-1)*$page_num;

        if($cate_id==null){

            $arr = GoodsModel::where('goods_name','like',"%$search%")->where($where)->orderBy($column,$order)->offset($start)->limit($page_num)->get();
            $count = count($arr);

        }else{
            $cate=CateModel::where('is_show',1)->get();
            $cateInfo=getCateInfo($cate,$cate_id);

            $cateId=[];

            foreach($cateInfo as $k=>$v){
                $cateId[]=$v->cate_id;
            }

            $arr = DB::table('app_goods')->where('goods_name','like',"%$search%")->where($where)->whereIn('cate_id',$cateId)->orderBy($column,$order)->offset($start)->limit($page_num)->get();

            $count = count($arr);
        }



        if ($count) {
            $data = ['code' => 0, 'data' => $arr,'count'=>$count];
            return json_encode($data, JSON_UNESCAPED_UNICODE);
        } else {
            $data = ['code' => 1102, 'msg' => '没有更多了!'];
            return json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }

}
