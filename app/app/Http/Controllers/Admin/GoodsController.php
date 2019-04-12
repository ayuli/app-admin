<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GoodsController extends Controller
{
    //商品添加页面
    public function goodsAdd(){
        $typeInfo=DB::table('app_type')->get();
        return view('admin.goods.goodsAdd',['typeInfo'=>$typeInfo]);
    }

    //商品添加执行页面
    public function goodsAddDo(Request $request){
        $data=$request->input();
        print_r($data);die;
        $attr_values_list=$data['attr_value_list'];
        $attr_price_list=$data['attr_price_list'];
        $attrInsert=[];
        foreach($attr_values_list as $k=>$v){
            if(!empty($v)){
                if(is_array($v)){
                    foreach($v as $key=>$val){
                        $attrInsert[]=[
                            'attr_id'=>$k,
                            'attr_value'=>$val,
                            'attr_price'=>$attr_price_list[$k][$key]
                        ];
                    }
                }else{
                    $attrInsert[]=[
                        'attr_id'=>$k,
                        'attr_value'=>$v,
                    ];
                }
            }
        }
        print_r($attrInsert);die;
        $goods_imgs="";
        $goods_insert=[
            'cate_id'=>$data['cate_id'],
            'goods_name'=>$data['goods_name'],
            'brand_id'=>$data['brand_id'],
            'goods_number'=>$data['goods_number'],
            'goods_price'=>$data['goods_price'],
            'goods_img'=>$data['goods_img'],
            'goods_score'=>$data['goods_score'],
            'add_time'=>time(),
            'is_show'=>$data['is_show'],
            'is_best'=>$data['is_best'],
            'is_new'=>$data['is_new'],
            'is_hot'=>$data['is_hot'],
            'goods_imgs'=>$goods_imgs
        ];
    }

    //生成货号
    public function goodsSn(){

    }

    //选择类型
    public function changeType(Request $request){
        $type_id=$request->input('type_id');
        $attrInfo=DB::table('app_attr')->where('type_id',$type_id)->get();
        foreach($attrInfo as $k=>$v){
            if(!empty($v->attr_values)) {
                $attrInfo[$k]->attr_values = explode("\n", $v->attr_values);
            }
        }
        return view("admin.goods.changeType",['attrInfo'=>$attrInfo]);
    }
}
