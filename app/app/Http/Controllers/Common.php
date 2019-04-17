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

?>