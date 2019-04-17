<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Model\GoodsModel;
use App\Model\CartModel;

class ZhaoController extends Controller
{
    //前台详情页
    public function indexGoodsDetail(Request $request){
        $goods_id = $request->input('goods_id');
//        $goods_id = 181;
        $goodsinfo = DB::table('app_goods')->where('goods_id',$goods_id)->first();
        $goodsinfo->add_time = date('Y-m-d H:i:s',$goodsinfo->add_time);

        $goods_attr = DB::table('app_product')->where('goods_id',$goods_id)->pluck('goods_attr');

        $data = [];
        foreach($goods_attr as $v){
            $data[] = DB::table('app_goods_attr')
                ->whereIn('goods_attr_id',explode(',',$v))
                ->get();
        }

        $arr=[];
        foreach($data as $k=>$v){
            $arr[$k]['attr_value']="";
            foreach($v as $kk=>$vv){
                $arr[$k]['attr_value'] .= $vv->attr_value.' ';

            }
        }
        $price = [];
        foreach($data as $k=>$v){
            $price[$k]['attr_price']=0;
            foreach($v as $kk=>$vv){
                $price[$k]['attr_price'] += $vv->attr_price;
            }

        }
        return json_encode(['goodsInfo'=>$goodsinfo,'attrInfo'=>$arr,'price'=>$price,'goods_attr'=>$goods_attr]);
    }

//    //前台搜索
//    public function goodsSearch(Request $request){
//        $goods_name = $request->input('goods_name');
////        $goods_name = "海尔";
//        $goodsinfo = DB::table('app_goods')
//            ->where('is_del',1)
//            ->where('goods_name','like',"%$goods_name%")
//            ->get();
////        print_r($goodsinfo);exit;
//        return json_encode(['goodsInfo'=>$goodsinfo]);
//    }

    //前台订单页单删批删
//    public function indexCartDel(Request $request){
////        $goods_id=$request->input('goods_id');
////        $user_id=$request->session()->get('user_id');
//        $user_id = 4;
//        $goods_id = '1';
//
//        $cartUpdate=[
//        'order_status'=>2,
//        'total'=>0
//        ];
//        $res = CartModel::where('user_id',$user_id)->whereIn('goods_id',$goods_id)->update($cartUpdate);
//             print_r($res);exit;
//        if($res){
//            return json_encode(['code'=>1,'msg'=>'删除成功']);
//        }else{
//            return json_encode(['code'=>2,'msg'=>'删除失败']);
//        }
//    }
}
