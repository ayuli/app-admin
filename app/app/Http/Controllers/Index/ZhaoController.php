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
        $goodsinfo = DB::table('app_goods')->where('goods_id',$goods_id)->first();

        $goodsinfo->goods_imgs=explode('|',$goodsinfo->goods_imgs);

        $goodsinfo->add_time = date('Y-m-d H:i:s',$goodsinfo->add_time);

        $goods_attr = DB::table('app_product')->where('goods_id',$goods_id)->pluck('goods_attr');

        if(count($goods_attr)!=0){
            $data = [];
            foreach($goods_attr as $v){
                $data[] = DB::table('app_goods_attr')
                    ->whereIn('goods_attr_id',explode(',',$v))
                    ->get();
            }

            $arr=[];
            foreach($data as $k=>$v){
                $arr[$k]="";
                foreach($v as $kk=>$vv){
                    $arr[$k] .= $vv->attr_value.' ';

                }
            }
            $price = [];
            foreach($data as $k=>$v){
                $price[$k]=0;
                foreach($v as $kk=>$vv){
                    $price[$k] += $vv->attr_price;
                }

            }

            $info=[];

            foreach($data as $k=>$v){
                $info[$k]['attr_price']=$price[$k];
                $info[$k]['goods_attr']=$goods_attr[$k];
                $info[$k]['attr_value']=$arr[$k];
            }
        }else{
            $info="";
        }

        return json_encode(['goodsInfo'=>$goodsinfo,'attrInfo'=>$info]);
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

    public function indexCartDel(Request $request){
        $goods_id=$request->input('cart_id');
        $user_id=$request->session()->get('user_id');
//        $user_id = 4;
//        $goods_id = [
//            0=>1,
//            1=>2
//        ];

        $cartUpdate=[
        'is_detele'=>2,
        ];
        $res = CartModel::where($where)->whereIn('goods_id',$goodsId)->update($cartupdate);
        if($res){
            return json_encode(['code'=>1,'msg'=>'删除成功']);
        }else{
            return json_encode(['code'=>2,'msg'=>'删除失败']);
        }
    }


    //生成订单
    public function createOrder(Request $request){
        DB::beginTransaction();
        $user_id = $request->input('user_id');
        $cart_id = $request->input('cart_id');
        $cart_id = explode(',',rtrim($cart_id));
        $address_id = $request->input('address_id');
        $total = $request->input('total');
        $way = $request->input('pay_way');

        if(empty($user_id)){
            return json_encode(['msg'=>'未登录','code'=>2]);
        }
        if(empty($cart_id)){
            return json_encode(['msg'=>'未选择商品','code'=>2]);
        }
        $order_sn = date("YmdHis",time()).rand(1000,9999);
        $orderdata=[
            'user_id'=>$user_id,
            'order_sn'=>$order_sn,
            'add_time'=>time(),
            'order_amount'=>$total,
            'pay_amount'=>$total,
            'order_status'=>3,
            'pay_way'=>$way,
            'is_pay'=>2
        ];
        $res = DB::table('app_order')->insert($orderdata);
        $orderInfoId = DB::table('app_order')->where('order_sn',$order_sn)->first();
        if(!$orderInfoId){
            DB::rollBack();
            return json_encode(['msg'=>'添加失败','code'=>3]);
        }
        $order_id=$orderInfoId->order_id;

        //修改购物车状态
        $wherecart = [
            'is_delete'=>2
        ];
        $cartRes = CartModel::where('user_id',$user_id)->whereIn('cart_id',$cart_id)->update($wherecart);

        //生成订单详情
        $goods_id = CartModel::where('user_id',$user_id)->whereIn('cart_id',$cart_id)->pluck('goods_id');
        $goodsInfo = CartModel::join('app_goods','app_cart.goods_id','=','app_goods.goods_id')
            ->whereIn('app_cart.goods_id',$goods_id)
            ->get();
        foreach($goodsInfo as $k=>$v){
            $dataInfo = [
                'order_id'=>$order_id,
                'order_no'=>$order_sn,
                'goods_attr_id'=>"$v->goods_attr_id",
                'goods_id'=>"$v->goods_id",
                'buy_number'=>"$v->goods_num",
                'goods_price'=>"$v->goods_price",
                'goods_name'=>"$v->goods_name",
                'goods_img'=>"$v->goods_img",
                'ctime'=>time()
            ];
            DB::table('app_order_goods')->insert($dataInfo);
        }

        //生成订单地址
        $addressData = DB::table('app_address')->where('id',$address_id)->first();
        $addressInfo = [
            'order_id'=>$order_id,
            'province'=>$addressData->province,
            'city'=>$addressData->city,
            'district'=>$addressData->district,
            'address_name'=>$addressData->consignee_name,
            'address_tel'=>$addressData->consignee_tel,
            'address_detail'=>$addressData->detailed_address,
            'ctime'=>time()
        ];
        $resaddress = DB::table('app_order_address')->insert($addressInfo);
        if($resaddress){
            DB::commit();
            return json_encode(['msg'=>'添加成功','code'=>1,'order_id'=>$order_id]);
        }else{
            DB::rollBack();
            return json_encode(['msg'=>'添加失败','code'=>2]);
        }
    }


    //订单详情
    public function orderShow(Request $request){
        date_default_timezone_set('prc');
        $order_id = $request->input('order_id');
        $data = DB::table('app_order')->where('order_id',$order_id)->first();
        if(!empty($data)){
            $del_time=$data->add_time+86400;
            $dataInfo = [
                'order_sn'=>"$data->order_sn",
                'add_time'=>date('Y-m-d',$data->add_time),
                'order_amount'=>"$data->order_amount",
                'del_time'=>date('Y-m-d',$del_time)
            ];
            return json_encode(['code'=>1,'data'=>$dataInfo]);
        }else{
            return json_encode(['code'=>0,'data'=>'']);
        }

    }


}
