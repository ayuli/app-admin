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
        DB::beginTransaction();
        $data=$request->input();
        $goods_imgs=implode('|',$data['goods_imgs']);
        $goods_insert=[
            'cate_id'=>$data['cate_id'],
            'type_id'=>$data['type_id'],
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
            'goods_imgs'=>$goods_imgs,
            'goods_desc'=>$data['goods_desc']
        ];
        $goods_id=DB::table('app_goods')->insertGetId($goods_insert);
        $goods_sn=$this->goodsSn($goods_id);
        $res=DB::table('app_goods')->update(['goods_sn'=>$goods_sn]);
        if($res){
            $attr_values_list=$data['attr_value_list'];
            $attr_price_list=$data['attr_price_list'];
            $attrInsert=[];
            foreach($attr_values_list as $k=>$v){
                if(!empty($v)){
                    if(is_array($v)){
                        foreach($v as $key=>$val){
                            $attrInsert[]=[
                                'goods_id'=>$goods_id,
                                'attr_id'=>$k,
                                'attr_value'=>$val,
                                'attr_price'=>$attr_price_list[$k][$key]
                            ];
                        }
                    }else{
                        $attrInsert[]=[
                            'goods_id'=>$goods_id,
                            'attr_id'=>$k,
                            'attr_value'=>$v,
                            'attr_price'=>0
                        ];
                    }
                }
            }
            $res=DB::table('app_goods_attr')->insert($attrInsert);
            if($res){
                DB::commit();
                echo json_encode(['code'=>1,'msg'=>'添加成功！']);
            }else{
                DB::rollBack();
                echo json_encode(['code'=>2,'msg'=>'添加失败！']);
            }
        }else{
            DB::rollBack();
            echo json_encode(['code'=>2,'msg'=>'添加失败！']);
        }
    }

    //生成货号
    public function goodsSn($goods_id){
        $goods_sn=date('Ymd',time()).'00'.$goods_id;
        if($goods_sn){
            $count=DB::table('app_goods')->where('goods_sn',$goods_sn)->count();
            if($count){
                $goods_sn=$this->getGoodsSn($goods_id);
            }
        }
        return $goods_sn;
    }

    //上传图片
    public function goodsUpload(Request $request){
        $data=$_FILES;
        $tmp_name=$data['file']['tmp_name'];

        $picInfo=file_get_contents($tmp_name);

        $name=$data['file']['name'];

        $filename="goods/".date("Ymd",time()).'/';
        if(!is_dir($filename)){
            mkdir($filename,0777,true);
        }
        $res=file_put_contents($filename.$name,$picInfo,FILE_APPEND);
        if($res){
            echo json_encode(['code'=>1,'msg'=>'上传成功！','filename'=>$filename.$name]);
        }else{
            echo json_encode(['code'=>0,'msg'=>'上传失败！','filename'=>""]);
        }
    }

    //选择类型
    public function changeType(Request $request){
        $type_id=$request->input('type_id');
        $goods_id=$request->input('goods_id');
        $attrInfo = DB::table('app_attr')->where('type_id', $type_id)->get();
        foreach ($attrInfo as $k => $v) {
            if (!empty($v->attr_values)) {
                $attrInfo[$k]->attr_values = explode("\n", $v->attr_values);
            }
        }

        if(!empty($goods_id)){
            $goods_attr=DB::table('app_goods_attr')->where('goods_id',$goods_id)->get();
            $attr_count=count($goods_attr);
            return view("admin.goods.changeType", ['attrInfo' => $attrInfo,'goods_attr'=>$goods_attr,'attr_count'=>$attr_count]);

        }else {
            return view("admin.goods.changeType", ['attrInfo' => $attrInfo]);
        }
    }

    //商品展示
    public function goodsShow(){
        $goods_info=DB::table('app_goods')
                    ->where('app_goods.is_del',1)
                    ->join('app_cate','app_cate.cate_id','=','app_goods.cate_id')
                    ->join('app_brand','app_brand.brand_id','=','app_goods.brand_id')
                    ->get();
        foreach($goods_info as $k=>$v){
            if($v->is_hot==1){
                $goods_info[$k]->is_hot='√';
            }else{
                $goods_info[$k]->is_hot='×';
            }

            if($v->is_best==1){
                $goods_info[$k]->is_best='√';
            }else{
                $goods_info[$k]->is_best='×';
            }

            if($v->is_new==1){
                $goods_info[$k]->is_new='√';
            }else{
                $goods_info[$k]->is_new='×';
            }

        }
        return view('admin.goods.goodsShow',['goods_info'=>$goods_info]);
    }

    //商品修改
    public function goodsUpdate(Request $request){
        $goods_id=$request->input('goods_id');
        $goodsInfo=DB::table('app_goods')->where('goods_id',$goods_id)->first();
        $goodsInfo->goods_imgs=explode('|',$goodsInfo->goods_imgs);
        $typeInfo=DB::table('app_type')->get();
        return view('admin.goods.goodsUpdate',['goodsInfo'=>$goodsInfo,'typeInfo'=>$typeInfo]);
    }

    //商品修改执行
    public function goodsUpdateDo(Request $request){
        DB::beginTransaction();
        $data=$request->input();
        if(!isset($data['is_show'])){
            $data['is_show']=1;
        }
        if(!isset($data['is_best'])){
            $data['is_best']=0;
        }
        if(!isset($data['is_hot'])){
            $data['is_hot']=0;
        }
        if(!isset($data['is_new'])){
            $data['is_new']=0;
        }
        $goods_imgs=implode('|',$data['goods_imgs']);
        $goods_id=$data['goods_id'];
        $goods_insert=[
            'cate_id'=>$data['cate_id'],
            'type_id'=>$data['type_id'],
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
            'goods_imgs'=>$goods_imgs,
            'goods_desc'=>$data['goods_desc']
        ];
        $res=DB::table('app_goods')->where('goods_id',$goods_id)->update($goods_insert);
        if($res){
            $attr_values_list=$data['attr_value_list'];
            $attr_price_list=$data['attr_price_list'];
            $attrInsert=[];
            $attrWhere=[];
            foreach($attr_values_list as $k=>$v){
                if(!empty($v)){
                    if(is_array($v)){
                        foreach($v as $key=>$val){
                            $attrWhere[]=[
                                'attr_value'=>$val,
                                'attr_price'=>$attr_price_list[$k][$key]
                            ];
                            $attrInsert[]=[
                                'goods_id'=>$goods_id,
                                'attr_id'=>$k
                            ];
                        }
                    }else{
                        $attrWhere[]=[
                            'goods_id'=>$goods_id,
                            'attr_id'=>$k,
                        ];
                        $attrInsert[]=[
                            'attr_value'=>$v,
                            'attr_price'=>0
                        ];
                    }
                }
            }

            foreach($attrWhere as $k=>$v){
                $arr=DB::table('app_goods_attr')->where($v)->get();
                if(count($arr)==0){
                    $goods_attr_insert=array_merge($v,$attrInsert[$k]);
                    $res=DB::table('app_goods_attr')->insert($goods_attr_insert);
                }else{
                    $res=DB::table('app_goods_attr')->where($v)->update($attrInsert[$k]);
                }
            }
            DB::commit();
            echo json_encode(['code'=>1,'msg'=>'修改成功！']);
        }else{
            DB::rollBack();
            echo json_encode(['code'=>2,'msg'=>'修改失败！']);
        }
    }

    //商品删除
    public function goodsDelete(Request $request){
        $goods_id=$request->input('goods_id');
        $res=DB::table('app_goods')->where('goods_id',$goods_id)->update(['is_del'=>0]);
        if($res){
            echo json_encode(['code'=>1,'msg'=>'删除成功！']);
        }else{
            echo json_encode(['code'=>0,'msg'=>'删除失败！']);
        }
    }
}
