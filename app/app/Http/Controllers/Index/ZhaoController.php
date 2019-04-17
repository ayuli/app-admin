<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Model\GoodsModel;

class ZhaoController extends Controller
{
    public function indexGoodsDetail(Request $request){
        $goods_id = $request->input('goods_id');
//        $goods_id = 186;
        $goodsinfo = DB::table('app_goods')->where('goods_id',$goods_id)->first();
        $goods_attr = DB::table('app_product')->where('goods_id',$goods_id)->get();

        $data = [];
        foreach($goods_attr as $v){
            $data[] = DB::table('app_goods_attr')
                ->whereIn('goods_attr_id',explode(',',$v->goods_attr))
                ->get();
        }
        $arr=[];
        foreach($data as $k=>$v){
            $arr[$k]="";
            foreach($v as $kk=>$vv){
                $arr[$k] .= $vv->attr_value.' ';
            }
        }
        return json_encode(['goodsInfo'=>$goodsinfo,'attrInfo'=>$arr]);
    }

//    public function goodsSearch(Request $request){
//        $goods_name = $request->input('goods_name');
//        $goodsinfo = DB::table('app_goods')->where('goods_id',$goods_name)->get();
//    }
}