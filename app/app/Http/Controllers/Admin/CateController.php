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
        $data = getCateInfo($cateInfo);  //递归处理
        return view('admin.cate.cate',['cate'=>$data]);
    }

    /**
     * 商品分类展示接口
     */
    public function cateGet()
    {
        $cate_all = CateModel::where(['is_del'=>0])->get();
        $dat = getCateInfo($cate_all);
        $data = ['data' => $dat];
        return view('admin.cate.categet',$data);
    }
    /**
     * 分类删除接口
     */
    public function cateDel(Request $request)
    {
        $cate_id = $request->input('cate_id');
        $res = CateModel::where(['cate_id'=>$cate_id])->update(['is_del'=>1]);
        if($res){
            return  returnJson(0,'删除成功');
        }else{
            return  returnJson(110,'删除失败');
        }
    }
    /**
     * 分类修改展示
     */
    public function cateUpda(Request $request)
    {
        $cate_id = $request->input('cate_id');
        $cateInfo = CateModel::all();
        $cateData = getCateInfo($cateInfo);
        $cate_first = CateModel::where(['cate_id'=>$cate_id])->first();
        $data = ['cate'=>$cate_first, 'cateInfo'=> $cateData];
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
        if($cate_id==''){ exit("非法操作"); }
        if($name==''){
            return  returnJson(100,'请填写完整');
        }
        $data = [
            'cate_name' => $name, 'p_id' => $p_id,
            'show_in_nav'   => $nav, 'is_show' =>  $show
        ];
        $res = CateModel::where(["cate_id"=>$cate_id])->update($data);
        if($res!==false){
            return  returnJson(0,'修改成功');
        }else{
            return  returnJson(110,'修改失败');
        }

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
            return  returnJson(111,'请填写分类名称');
        }
        $data = [
            'cate_name' => $name, 'p_id' => $p_id,
            'show_in_nav'   => $nav, 'is_show' =>  $show
        ];
        $res = CateModel::insert($data);
        if($res){
            return  returnJson(0,'添加成功');
        }else{
            return  returnJson(110,'添加失败');
        }
    }

}
