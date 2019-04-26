<?php

namespace App\Http\Controllers\Admin;

use App\Model\CateModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GoodsController extends Controller
{
    //商品添加页面
    public function goodsAdd(){
        $cate_all = CateModel::where(['is_del'=>0])->get();
        $cateInfo = getCateInfo($cate_all);
        $brandInfo=DB::table('app_brand')->where('is_del',0)->get();
        $typeInfo=DB::table('app_type')->get();
        return view('admin.goods.goodsAdd',['cateInfo'=>$cateInfo,'brandInfo'=>$brandInfo,'typeInfo'=>$typeInfo]);
    }

    //商品添加执行页面
    public function goodsAddDo(Request $request){
        DB::beginTransaction();
        $data=$request->input();
        if(empty($data['goods_name'])){
            echo json_encode(['code'=>2,'msg'=>'名称必填']);exit;
        }
        if(empty($data['cate_id'])){
            echo json_encode(['code'=>2,'msg'=>'分类必选']);exit;
        }
        if(empty($data['brand_id'])){
            echo json_encode(['code'=>2,'msg'=>'品牌必选']);exit;
        }
        if(empty($data['goods_price'])){
            echo json_encode(['code'=>2,'msg'=>'价格必填']);exit;
        }
        if(empty($data['goods_number'])){
            echo json_encode(['code'=>2,'msg'=>'库存必填']);exit;
        }
        
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
        if(!empty($data['goods_imgs'])){
            $goods_imgs=implode('|',$data['goods_imgs']);
        }else{
            $goods_imgs="";
        }
        if(empty($data['goods_img'])){
            $data['goods_img']="";
        }
        if(empty($data['goods_desc'])){
            $data['goods_desc']="";
        }
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
            if(!empty($data['type_id'])){
                $attr_values_list=$data['attr_value_list'];
                $attr_price_list=$data['attr_price_list'];
                $attrInsert=[];
                foreach($attr_values_list as $k=>$v){
                    if(!empty($v)){
                        if(is_array($v)){
                            foreach($v as $key=>$val){
                                if($val!=""){
                                    $attrInsert[]=[
                                        'goods_id'=>$goods_id,
                                        'attr_id'=>$k,
                                        'attr_value'=>$val,
                                        'attr_price'=>$attr_price_list[$k][$key]
                                    ];
                                }
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
            }
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


        $name=$data['file']['name'];

        $filename="goods/".date("Ymd",time()).'/';
        if(!is_dir($filename)){
            mkdir($filename,0777,true);
        }
        $res=move_uploaded_file($tmp_name,$filename.$name);
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
            $attr_count=DB::table('app_goods_attr')->where('goods_id',$goods_id)->count();
            return view("admin.goods.changeType", ['attrInfo' => $attrInfo,'goods_attr'=>$goods_attr,'attr_count'=>$attr_count]);

        }else {
            return view("admin.goods.changeType", ['attrInfo' => $attrInfo]);
        }
    }

    //商品展示
    public function goodsShow(){
        $num=10;
        $goods_info=DB::table('app_goods')
                    ->where('app_goods.is_del',1)
                    ->join('app_cate','app_cate.cate_id','=','app_goods.cate_id')
                    ->join('app_brand','app_brand.brand_id','=','app_goods.brand_id')
                    ->orderBy('goods_id','asc')
                    ->paginate($num);
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

        if(!empty($goodsInfo->goods_imgs)){
            $goodsInfo->goods_imgs=explode('|',$goodsInfo->goods_imgs);
        }

        $cate_all = CateModel::where(['is_del'=>0])->get();
        $cateInfo = getCateInfo($cate_all);
        $brandInfo=DB::table('app_brand')->where('is_del',0)->get();
        $typeInfo=DB::table('app_type')->get();

        return view('admin.goods.goodsUpdate',['cateInfo'=>$cateInfo,'goodsInfo'=>$goodsInfo,'brandInfo'=>$brandInfo,'typeInfo'=>$typeInfo]);
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

        if(!empty($data['goods_imgs'])){
            $goods_imgs=implode('|',$data['goods_imgs']);
        }else{
            $goods_imgs="";
        }

        if(empty($data['goods_img'])){
            $data['goods_img']="";
        }
        if(empty($data['goods_desc'])){
            $data['goods_desc']="";
        }

        if(!empty($data['del_imgs'])){
            foreach($data['del_imgs'] as $k=>$v){
                unlink($v);
            }
        }

        if(!empty($data['del_img'])){
            unlink($data['del_img']);
        }

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
            'is_show'=>$data['is_show'],
            'is_best'=>$data['is_best'],
            'is_new'=>$data['is_new'],
            'is_hot'=>$data['is_hot'],
            'goods_imgs'=>$goods_imgs,
            'goods_desc'=>$data['goods_desc']
        ];
        $res=DB::table('app_goods')->where('goods_id',$goods_id)->update($goods_insert);
        if($res){
            if(!empty($data['type_id'])) {
                    $attrWhere=[];
                    $attrInsert=[];
                    $attr_price_list=$data['attr_price_list'];
                    $attr_values_list=$data['attr_value_list'];
                    foreach ($attr_values_list as $k => $v) {
                        if (!empty($v)) {
                            if (is_array($v)) {
                                foreach ($v as $key => $val) {
                                    if($val!=""){
                                        $attrWhere[] = [
                                            'attr_value' => $val,
                                            'attr_price' => $attr_price_list[$k][$key]
                                        ];
                                        $attrInsert[] = [
                                            'goods_id' => $goods_id,
                                            'attr_id' => $k
                                        ];
                                    }
                                }
                            } else {
                                $attrWhere[] = [
                                    'goods_id' => $goods_id,
                                    'attr_id' => $k,
                                ];
                                $attrInsert[] = [
                                    'attr_value' => $v,
                                    'attr_price' => 0
                                ];
                            }
                        }
                    }

            }
            if(!empty($attrWhere)) {
                foreach ($attrWhere as $k => $v) {
                    $arr = DB::table('app_goods_attr')->where($v)->get();
                    if (count($arr) == 0) {
                        $goods_attr_insert = array_merge($v, $attrInsert[$k]);
                        $res = DB::table('app_goods_attr')->insert($goods_attr_insert);
                    } else {
                        $res = DB::table('app_goods_attr')->where($v)->update($attrInsert[$k]);
                    }
                }
            }
            if($res){
                DB::commit();
                echo json_encode(['code'=>1,'msg'=>'修改成功！']);
            }else{
                echo json_encode(['code'=>2,'msg'=>'未修改']);
            }

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

    //货品添加
    public function productAdd(Request $request){
        $goods_id=$request->input('goods_id');
        $product_info=DB::table('app_product')->where('goods_id',$goods_id)->get();
        $goods_info=DB::table('app_goods')->where('goods_id',$goods_id)->select('goods_id','goods_name','goods_sn')->first();
        $attr_id=DB::table('app_goods_attr')->where('goods_id',$goods_id)->pluck('attr_id');
        $attr_id=DB::table('app_attr')->whereIn('attr_id',$attr_id)->where('attr_input_type',1)->pluck('attr_id');
        $attr_name=DB::table('app_attr')->whereIn('attr_id',$attr_id)->where('attr_input_type',1)->pluck('attr_name');
        if(count($attr_name)==0){
            echo "<script>alert('该商品没有属性！');history.go(-1)</script>";exit;
        }
        $attr_info=DB::table('app_goods_attr')->where('goods_id',$goods_id)->whereIn('attr_id',$attr_id)->get();


        foreach($product_info as $k=>$v){
            $attr_value=DB::table('app_goods_attr')->whereIn('goods_attr_id',explode(',',$v->goods_attr))->pluck('attr_value');
            $product_info[$k]->goods_attr=$attr_value;
        }

        $attr_values=[];
        $attr_price=[];

        foreach($attr_info as $k=>$v){
            $attr_values[$v->attr_id][$v->goods_attr_id]=$v->attr_value;
            $attr_price[$v->attr_id][$v->goods_attr_id]=$v->attr_price;
        }
        
        return view('admin.goods.goodsSku',['product_info'=>$product_info,'goods_info'=>$goods_info,'attr_name'=>$attr_name,'attr_values'=>$attr_values,'attr_id'=>$attr_id]);
    }

    //sku添加执行
    public function productAddDo(Request $request){
        DB::beginTransaction();
        $data=$request->input();
        $attr=$data['attr'];

        $goods_id=$data['goods_id'];
        $product_number=$data['product_number'];
        $count=count($data['product_number']);
        $goods_info=DB::table('app_goods')->where('goods_id',$goods_id)->first();
        $goods_num=$goods_info->goods_number;
        $goods_sn=$goods_info->goods_sn;
        for($i=0;$i<$count;$i++){

            $productInsert=[
                'goods_attr'=>implode(',',array_column($attr,$i)),
                'goods_id'=>$goods_id,
                'product_number' => $product_number[$i]
            ];
            $product_id=DB::table('app_product')->insertGetId($productInsert);
            if($product_id){
                $product_sn = $goods_sn . '_' . $product_id;
                $res=DB::table('app_product')->where('product_id',$product_id)->update(['product_sn'=>$product_sn]);

            }
        }
        $goods_num+=array_sum($product_number);

        $res=DB::table('app_goods')->where('goods_id',$goods_id)->update(['goods_number'=>$goods_num]);
        if($res){
            DB::commit();
            echo json_encode(['code'=>1,'msg'=>'添加成功！']);
        }else{
            DB::rollBack();
            echo json_encode(['code'=>0,'msg'=>'添加失败！']);
        }

    }

    //商品属性
    public function attrAdd(Request $request){
        $type_id=$request->input('type_id');
        if(empty($type_id)){
            echo "<script>alert('请先选择类型！');history.go(-1);</script>";die;
        }
        $typeInfo=DB::table('app_type')->get();
        return view('admin.goods.attrAdd',['typeInfo'=>$typeInfo,'type_id'=>$type_id]);
    }

    //商品属性添加执行
    public function attrAddDo(Request $request){
        $data=$request->input();
        $type_id=$data['type_id'];
        if(empty($data['attr_name'])){
            echo json_encode(['code'=>0,'msg'=>'名称不能为空！']);exit;
        }
        if(!isset($data['attr_values'])){
            $data['attr_values']="";
        }
        $res=DB::table('app_attr')->insert($data);
        if($res){
            echo json_encode(['code'=>1,'msg'=>'添加成功！','type_id'=>$type_id]);
        }else{
            echo json_encode(['code'=>0,'msg'=>'添加失败！']);
        }
    }

    //商品属性展示
    public function attrShow(Request $request){
        $num=10;
        $type_id=$request->input('type_id');
        if(empty($type_id)){
            echo "<script>alert('请先选择类型！');history.go(-1);</script>";die;
        }
        $type_name=DB::table('app_type')->where('type_id',$type_id)->value('type_name');
        $attrInfo=DB::table('app_attr')->where(['type_id'=>$type_id,'is_del'=>1])->paginate($num);
        $attrInfo->appends(['type_id'=>$type_id])->render();
        return view('admin.goods.attrShow',['attrInfo'=>$attrInfo,'type_name'=>$type_name,'type_id'=>$type_id]);
    }

    //商品属性修改
    public function attrUpdate(Request $request){
        $attr_id=$request->input('attr_id');
        $attrInfo=DB::table('app_attr')->where('attr_id',$attr_id)->first();
        $typeInfo=DB::table('app_type')->get();
        return view('admin.goods.attrUpdate',['typeInfo'=>$typeInfo,'attrInfo'=>$attrInfo]);
    }

    //商品属性修改执行
    public function attrUpdateDo(Request $request){
        $data=$request->input();
        $type_id=$data['type_id'];
        $attr_id=$data['attr_id'];
        $res=DB::table('app_attr')->where('attr_id',$attr_id)->update($data);
        if($res){
            echo json_encode(['code'=>1,'msg'=>'修改成功！','type_id'=>$type_id]);
        }else{
            echo json_encode(['code'=>0,'msg'=>'未修改！']);
        }
    }

    //商品属性删除
    public function attrDelete(Request $request){
        $attr_id=$request->input('attr_id');
        $res=DB::table('app_attr')->where('attr_id',$attr_id)->update(['is_del'=>0]);
        if($res){
            echo json_encode(['code'=>1,'msg'=>'删除成功！']);
        }else{
            echo json_encode(['code'=>2,'msg'=>'删除失败！']);
        }
    }
}
