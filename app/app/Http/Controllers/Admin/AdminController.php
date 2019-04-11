<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //管理员添加页面
    public function adminAdd(){
        return view('admin.admin.adminadd');
    }
    //管理员执行添加
    public function adminInsert(Request $request){
        $admin_name = $request->input('admin_name');
        $admin_pwd = $request->input('admin_pwd');
        $admin_email = $request->input('admin_email');
        $admin_tel = $request->input('admin_tel');
//        print_r($admin_tel);exit;
        $datainfo=[
            'admin_name'=>$admin_name,
            'admin_pwd'=>md5($admin_pwd),
            'admin_email'=>$admin_email,
            'admin_tel'=>$admin_tel,
            'create_time'=>time()
        ];
//        print_r($datainfo);exit;
        $res = DB::table('app_admin')->insert($datainfo);
        if($res){
            echo json_encode(['msg'=>'添加成功','code'=>0]);
        }
    }
    //管理员展示
    public function adminList(){
        $admininfo = DB::table('app_admin')->where('is_del',0)->get();
        return view('admin.admin.adminlist',['admininfo'=>$admininfo]);
    }
    //管理员删除
    public function adminDel(Request $request){
        $admin_id = $request->input('admin_id');
        $is_del=[
            'is_del'=>1
        ];
        $res = DB::table('app_admin')->where('admin_id',$admin_id)->update($is_del);
        if($res){
            echo json_encode(['msg'=>'删除成功','code'=>0]);
        }
    }
    //管理员修改页面
    public function adminUpdate(Request $request){
        $admin_id = $request->input('admin_id');
        $admininfo = DB::table('app_admin')->where('admin_id',$admin_id)->first();
        return view('admin.admin.adminupdate',['admininfo'=>$admininfo]);
    }
    //管理员执行修改
    public function adminUpdataDo(Request $request){
        $admin_name = $request->input('admin_name');
        $admin_id = $request->input('admin_id');
        $admin_email = $request->input('admin_email');
        $admin_tel = $request->input('admin_tel');
        $datainfo=[
            'admin_name'=>$admin_name,
            'admin_email'=>$admin_email,
            'admin_tel'=>$admin_tel,
        ];
        $res = DB::table('app_admin')->where('admin_id',$admin_id)->update($datainfo);
        if($res){
            echo json_encode(['msg'=>'修改成功','code'=>0]);
        }
    }

}
