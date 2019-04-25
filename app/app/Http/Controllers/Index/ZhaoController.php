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
        $user_id  = $request->input('user_id');
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

        //判断是否收藏
        $res=DB::table('app_collection')->where(['user_id'=>$user_id,'goods_id'=>$goods_id])->first();
        if($res){
            $code=1;
        }else{
            $code=0;
        }
        return json_encode(['goodsInfo'=>$goodsinfo,'attrInfo'=>$info,'code'=>$code]);
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

    //前台购物车单删批删

    public function indexCartDel(Request $request){
        $cart_id=$request->input('cart_id');
        $cart_id=explode(',',rtrim($cart_id));
        $cartUpdate=[
            'is_delete'=>2,
        ];
        $res = CartModel::whereIn('cart_id',$cart_id)->update($cartUpdate);
        if($res){
            return json_encode(['code'=>1,'msg'=>'删除成功']);
        }else{
            return json_encode(['code'=>2,'msg'=>'请稍后再试！']);
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
        $uc_id = $request->input('uc_id','');

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
            'order_status'=>1,
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

        if(!$cartRes){
            DB::rollBack();
            return json_encode(['msg'=>'该商品已生成订单，请刷新页面再试！','code'=>3]);
        }

        //生成订单详情
        $goodsInfo = CartModel::join('app_goods','app_cart.goods_id','=','app_goods.goods_id')
            ->whereIn('app_cart.cart_id',$cart_id)
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

        //

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
            if($uc_id!=''){
                $res=DB::table('app_user_coupon')->where('uc_id',$uc_id)->update(['is_del'=>2]);
            }
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

    //领取优惠券
    public function drawCoupon(Request $request){
        $user_id = $request->input('user_id');
        $coupon_id = $request->input('coupon_id');
        $where = [
            'user_id'=>$user_id,
            'coupon_id'=>$coupon_id
        ];
        $data = DB::table('app_user_coupon')->where($where)->first();
//        print_r($data);exit;
        if(empty($data)){
            $wheres = [
                'user_id'=>$user_id,
                'coupon_id'=>$coupon_id,
                'createtime'=>time()
            ];
            $res = DB::table('app_user_coupon')->insert($wheres);
            if($res){
                return json_encode(['msg'=>'领取成功','code'=>1]);
            }else{
                return json_encode(['msg'=>'领取失败','code'=>3]);
            }
        }else{
            return json_encode(['msg'=>'只可领取一张','code'=>2]);
        }
    }

    //获取优惠券
    public function getUserCoupon(Request $request){
        $user_id=$request->input('user_id');
        $couponInfo=DB::table('app_user_coupon')
                        ->where(['user_id'=>$user_id,'is_del'=>1,'coupon_del'=>0])
                        ->join('app_coupon','app_user_coupon.coupon_id','=','app_coupon.coupon_id')
                        ->get();
        if(count($couponInfo)>0){
            foreach ($couponInfo as $k=>$v){
                if($v->coupon_type==1){
                    $coupon_attr=explode('-',$v->coupon_attr);
                    $couponInfo[$k]->max=$coupon_attr[0];
                    $couponInfo[$k]->price=$coupon_attr[1];
                }else if($v->coupon_type==2){
                    $couponInfo[$k]->price=$v->coupon_attr;
                }else{
                    $couponInfo[$k]->discount=$v->coupon_attr;
                }
            }
            echo json_encode(['code'=>1,'data'=>$couponInfo]);
        }else{
            echo json_encode(['code'=>0,'data'=>'']);
        }
    }


    /**
     * 领取优惠卷 展示所有优惠卷
     */
    public function getCoupon()
    {
        $coupon = DB::table('app_coupon')->get();
        $data = ['code'=>0,'msg'=>'success','data'=>$coupon];
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    /**
     * 执行领取优惠卷
     */
    public function couponDo(Request $request)
    {
        $coupon_id = $request->input('coupon_id');
        $user_id = $request->input('user_id');
        // 先判断该用户是否领取该优惠卷
        $coupon_user = DB::table('app_user_coupon')->where(['user_id'=>$user_id,'coupon_id'=>$coupon_id,'is_del'=>1])->get();
        if(count($coupon_user)>0){ return returnJson('1022','该用户已领取该优惠卷');}
        //优惠卷 -1
        $coupon_num = DB::table('app_coupon')->where(['coupon_id'=>$coupon_id])->value('coupon_num');
        $coupon_num = $coupon_num-1;
        $res_num = DB::table('app_coupon')->where(['coupon_id'=>$coupon_id])->update(['coupon_num'=>$coupon_num]);
        if(!$res_num){ return returnJson('1023','领取失败');}
        // 用户加优惠卷
        $data= ['user_id'=>$user_id,'coupon_id'=>$coupon_id,'createtime'=>time()];
        $res_insert = DB::table('app_user_coupon')->insert($data);
        if(!$res_insert){ return returnJson('1023','领取失败');}
        return json_encode(['code'=>0,'msg'=>'领取成功','num'=>$coupon_num],JSON_UNESCAPED_UNICODE);
    }

    /**
     *  个人中心展示优惠卷
     */
    public function couponContent(Request $request)
    {
        $user_id = $request->input('user_id');
        $couponInfo = DB::table('app_user_coupon')
            ->where(['user_id' => $user_id, 'is_del' => 1, 'coupon_del' => 0])
            ->join('app_coupon', 'app_user_coupon.coupon_id', '=', 'app_coupon.coupon_id')
            ->get();
    }


    //订单失效
    public function orderDel(){
        $dataorder = DB::table('app_order')->get();
        foreach($dataorder as $k=>$v){
            $add_time = $v->add_time;
            $die_time = $add_time+86400;
            $time = time();
            if( $time > $die_time){
                $where=[
                    'order_id'=>"$v->order_id"
                ];
                $where1=[
                    'order_status'=>6
                ];
                $res = DB::table('app_order')->where($where)->update($where1);

            }else{

            }
        }
    }



    //优惠券失效 unused未使用   used已使用  pastdue已过期
    public function couponDel(Request $request){
        $user_id = $request->input('user_id');
        $type = $request->input('type');
        $datacoupon = DB::table('app_user_coupon')->where('is_del',1)->get();
        foreach($datacoupon as $k=>$v){
            $add_time = $v->createtime;
            $die_time = $add_time+86400;
            $time = time();
            if( $time > $die_time){
                $where=[
                    'coupon_id'=>"$v->coupon_id",
                    'user_id'=>"$v->user_id"
                ];
                $where1=[
                    'is_del'=>3
                ];
                $res = DB::table('app_user_coupon')->where($where)->update($where1);
            }
        }

        $wheredata = [
            'is_del'=>$type,
            'user_id'=>$user_id
        ];
        $data = DB::table('app_user_coupon')->join('app_coupon','app_user_coupon.coupon_id','=','app_coupon.coupon_id')->where($wheredata)->get();
//        print_r($data);
        if(count($data)>0){
            return json_encode(['data'=>$data,'code'=>1]);
        }else{
            return json_encode(['data'=>'','code'=>2]);
        }

    }


    public function couponStatus(){

        $datacoupon = DB::table('app_user_coupon')->where('is_del',1)->get();
        foreach($datacoupon as $k=>$v){
            $add_time = $v->createtime;
            $die_time = $add_time+86400;
            $time = time();
            if( $time > $die_time){
                $where=[
                    'coupon_id'=>"$v->coupon_id",
                    'user_id'=>"$v->user_id"
                ];
                $where1=[
                    'is_del'=>3
                ];
                $res = DB::table('app_user_coupon')->where($where)->update($where1);
            }else{

            }

        }
    }

}
