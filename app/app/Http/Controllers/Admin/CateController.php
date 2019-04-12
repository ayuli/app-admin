<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\CateModel;

class CateController extends Controller
{
    /**
     * 分类添加页面
     */
    public function cate()
    {
        $cateInfo = CateModel::all();
        $data = $this->getCateInfo($cateInfo);
        return view('admin.cate.cate',['cate'=>$data]);
    }

    /**
     *处理分类 无限极分类-递归
     */
    function getCateInfo($data,$p_id=0,$level=0){
        static $info=[];
        foreach($data as $k=>$v){
            if($v['p_id']==$p_id){
                $v['level']=str_repeat('&nbsp;&nbsp;',$level*4);
                $info[]=$v;
                $this->getCateInfo($data,$v['cate_id'],$level+1);
            }
        }
        return $info;
    }

    /**
     * 商品分类展示接口
     */
    public function cateGet()
    {
        $cate_all = CateModel::where(['is_del'=>0])->get();
        $dat = $this->getCateInfo($cate_all);
        $data = [
            'data' => $dat
        ];
        return view('admin.cate.categet',$data);
    }

    /**
     * 分类删除接口
     */
    public function cateDel(Request $request)
    {
        $cate_id = $request->input('cate_id');
//        echo $cate_id;die;
        $res = CateModel::where(['cate_id'=>$cate_id])->update(['is_del'=>1]);
        if($res){
            $json = [
                'code' => 0,
                'msg'   => '删除成功'
            ];
        }else{
            $json=[
                'code' => 110,
                'msg'   => '删除失败'
            ];
        }

        return json_encode($json,JSON_UNESCAPED_UNICODE);
    }

    /**
     * 分类修改展示
     */
    public function cateUpda(Request $request)
    {
        $cate_id = $request->input('cate_id');
        $cateInfo = CateModel::all();
        $cateData = $this->getCateInfo($cateInfo);

        $cate_first = CateModel::where(['cate_id'=>$cate_id])->first();
        $data = [
            'cate'=>$cate_first,
            'cateInfo'=> $cateData
        ];
        return view('admin.cate.cateupda',$data);
    }

    /**
     * 分类修改执行接口
     */
    public function cateUpdaDo(Request $request)
    {
        $name = $request->input('name');
        $p_id = $request->input('p_id');
        $nav = $request->input('nav');
        $show = $request->input('show');
        $cate_id = $request->input('cate_id');
        if($cate_id==''){ echo "非法操作"; }

        if($name==''){
            $json = ['code'  => 100, 'msg'   => '请填写完整'];
            return  json_encode($json,JSON_UNESCAPED_UNICODE);
        }
        $data = [
            'cate_name' => $name,
            'p_id' => $p_id,
            'show_in_nav'   => $nav,
            'is_show' =>  $show
        ];
        $res = CateModel::where(["cate_id"=>$cate_id])->update($data);
        if($res!==false){
            $json = ['code'  => 0, 'msg'   => '修改成功'];
        }else{
            $json = ['code'  => 110, 'msg'   => '修改失败'];
        }
        return  json_encode($json,JSON_UNESCAPED_UNICODE);

    }

    /**
     * 分类添加接口
     */
    public function cateAdd(Request $request)
    {
        $name = $request->input('name');
        $p_id = $request->input('p_id');
        $nav = $request->input('nav');
        $show = $request->input('show');
        if($name==''){
            $json = ['code'  => 111, 'msg'   => '请填写分类名称'];
            return  json_encode($json,JSON_UNESCAPED_UNICODE);
        }
        $data = [
            'cate_name' => $name,
            'p_id' => $p_id,
            'show_in_nav'   => $nav,
            'is_show' =>  $show
        ];
        $res = CateModel::insert($data);
        if($res){
            $json = ['code'  => 0, 'msg'   => '添加成功'];
        }else{
            $json = ['code'  => 110, 'msg'   => '添加失败'];
        }

        return  json_encode($json,JSON_UNESCAPED_UNICODE);

    }

}
