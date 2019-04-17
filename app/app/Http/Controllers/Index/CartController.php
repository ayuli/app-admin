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
            'status'=>1
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
}