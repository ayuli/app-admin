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
        $type = $request->input('type');
        if($type=='all'){
            $goods = GoodsModel::get();
            $data = [
                'code'  => 0,
                'data'  =>$goods
            ];
            if($goods){
                return json_encode($data,JSON_UNESCAPED_UNICODE);
            }
        }else if ($type=='hot'){
            $goods = GoodsModel::where(['is_hot'=>1])->limit(8)->get();
            $data = [
                'code'  => 0,
                'data'  =>$goods
            ];
            if($goods){
                return json_encode($data,JSON_UNESCAPED_UNICODE);
            }
        }else if($type=='new'){
            $goods = GoodsModel::where(['is_new'=>1])->limit(8)->get();
            $data = [
                'code'  => 0,
                'data'  =>$goods
            ];
            if($goods){
                return json_encode($data,JSON_UNESCAPED_UNICODE);
            }
        }


    }


}
