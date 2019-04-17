<?php

namespace App\Http\Controllers\Index;

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
    public function cartshow(){
        $where=[
            'is_delete'=>1
        ];
        $data=CartModel::where($where)
            ->join('app_goods','app_cart.goods_id','=','app_goods.goods_id')
            ->paginate(100)
            ->toArray();
        $num = DB::table('app_cart')->count();
        $data['count']=$num;
        $arr=json_encode($data);
        return $arr;
    }

    //添加购物车
    public function cartAdd(Request $request){
        $data=$request->input();
        $data['is_delete']=1;
        $goods_num=$data['goods_num'];
        $user_id=$data['user_id'];
        $goods_id=$data['goods_id'];
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
