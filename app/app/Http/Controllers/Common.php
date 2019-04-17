<?php

/**
 * @param $data      全部分类信息
 * @param int $p_id  父类id
 * @param int $level  层级
 * @return array     分类信息
 */
function getCateInfo($data,$p_id=0,$level=0){
    static $info=[];
    foreach($data as $k=>$v){
        if($v['p_id']==$p_id){
            $v['level']=str_repeat('&nbsp;&nbsp;',$level*4);
            $info[]=$v;
            getCateInfo($data,$v['cate_id'],$level+1);
        }
    }
    return $info;
}



//成功信息
function returnJson($code,$msg)
{
    $data =  ['code'  => $code, 'msg'   => $msg];
    return json_encode($data,JSON_UNESCAPED_UNICODE);

}

//查询商品属性
function getGoodsAttr($goods_id,$goods_attr){
    $goodsinfo = DB::table('app_goods')->where('goods_id',$goods_id)->first();

    $data= DB::table('app_goods_attr')
        ->whereIn('goods_attr_id',explode(',',$goods_attr))
        ->select('attr_value','attr_price')
        ->get();

    $info=[];

    foreach($data as $k=>$v){
        $info['attr_value']="";
        $info['attr_price']=0;
    }

    foreach($data as $k=>$v){
        $info['attr_value'].=$v->attr_value.',';
        $info['attr_price']+=$v->attr_price;
    }
    $info['attr_value']=trim($info['attr_value'],',');

    $goodsinfo->attr_value=$info['attr_value'];
    $goodsinfo->attr_price=$info['attr_price'];

    return json_encode(['goodsInfo'=>$goodsinfo]);
}

?>