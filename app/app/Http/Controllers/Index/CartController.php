<?php

namespace App\Http\Controllers\Index;

use App\Model\CateModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\CartModel;
use Illuminate\Support\Facades\DB;
class CartController extends Controller
{
    /**
     * 购物车接口
     * @return false|string
     */
    public function cartshow(Request $request){
        $user_id=$request->input('user_id');
        $cart_id=$request->input('cart_id','');
        if($cart_id==''){
            $where=[
                'user_id'=>$user_id,
                'is_delete'=>1
            ];
            $data=CartModel::where($where)
                ->join('app_goods','app_cart.goods_id','=','app_goods.goods_id')
                ->get();
            $num = DB::table('app_cart')->where($where)->count();
        }else{
            $cart_id=rtrim($cart_id,',');
            $cart_id=explode(',',$cart_id);
            $data=DB::table('app_cart')->whereIn('cart_id',$cart_id)
                ->join('app_goods','app_cart.goods_id','=','app_goods.goods_id')
                ->get();

            $num=DB::table('app_cart')->whereIn('cart_id',$cart_id)->count();
        }

        if(count($data)>0){
            $goodsInfo=[];
            foreach ($data as $k=>$v){
                if(!empty($v->goods_attr_id)){
                    $arr=getGoodsAttr($v->goods_id,$v->goods_attr_id);
                    $arr->cart_id=$v->cart_id;
                    $arr->goods_num=$v->goods_num;
                    $arr->total_price=$v->total_price;
                    $goodsInfo[]=$arr;
                }else{
                    $goodsInfo[]=$v;
                }
            }

            $info['code']=1;
            $info['data']=$goodsInfo;
            $info['count']=$num;
            $arr=json_encode($info);
            return $arr;
        }else{
            echo json_encode(['code'=>2,'msg'=>'暂无数据！']);
        }



    }

    //添加购物车
    public function cartAdd(Request $request){
        $data=$request->input();
        $data['is_delete']=1;
        $goods_num=$data['goods_num'];
        $user_id=$data['user_id'];
        $goods_id=$data['goods_id'];
        $goods_attr=$data['goods_attr'];
        if($goods_attr==null){
            $goods_attr="";
        }

        $cartInfo=DB::table('app_cart')->where(['goods_id'=>$goods_id,'user_id'=>$user_id,'is_delete'=>1,'goods_attr_id'=>$goods_attr])->first();

        if($cartInfo){
            echo json_encode(['code'=>1,'msg'=>'该商品已在购物车，确认去查看！']);
        }else{
            $goodsInfo=DB::table('app_goods')->where('goods_id',$goods_id)->first();
            $goods_price=$goodsInfo->goods_price;
            $cartInsert=[];
            if(isset($data['goods_attr'])){
                $goods_attr=$data['goods_attr'];
                $attr_price=DB::table('app_goods_attr')->whereIn('goods_attr_id',explode(',',$goods_attr))->pluck('attr_price')->toArray();
                $attr_price=array_sum($attr_price);
                $goods_price=$goods_price+$attr_price;
            }

            $total_price=$goods_price*$goods_num;

            $cartInsert=[
                'goods_id'=>$goods_id,
                'goods_attr_id'=>isset($data['goods_attr'])?$goods_attr:"",
                'goods_num'=>$goods_num,
                'goods_name'=>"$goodsInfo->goods_name",
                'goods_price'=>$goods_price,
                'total_price'=>$total_price,
                'user_id'=>$user_id,
                'is_delete'=>1,
                'add_time'=>time()
            ];
            $res=DB::table('app_cart')->insert($cartInsert);
            if($res){
                echo json_encode(['code'=>1,'msg'=>'加入购物车成功！']);
            }else{
                echo json_encode(['code'=>0,'msg'=>'请稍后重试！']);
            }
        }


    }

    //修改购物车信息
    public function cartUpdate(Request $request){
        $cart_id=$request->input('cart_id');
        $goods_num=$request->input('goods_num');
        $total_price=$request->input('total_price');
        $update=[
            'goods_num'=>$goods_num,
            'total_price'=>$total_price
        ];
        $res=DB::table('app_cart')->where(['cart_id'=>$cart_id])->update($update);
        if(!$res){
            echo json_encode(['code'=>1,'msg'=>'请稍后再试！']);
        }
    }
}
