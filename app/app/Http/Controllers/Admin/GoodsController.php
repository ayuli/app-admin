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
