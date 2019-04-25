<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        if(empty($admin_name)){
            return json_encode(['msg'=>'管理员名称不能为空','code'=>1]);
        }
        $data = DB::table('app_admin')->where('admin_name',$admin_name)->value('admin_name');
        if($admin_name == $data){
            return json_encode(['msg'=>'该名称已存在','code'=>1]);
        }
        if(empty($admin_pwd)){
            return json_encode(['msg'=>'密码不能为空','code'=>1]);
        }
        $reg='/^.{3,11}$/';
        if(!preg_match($reg,$admin_pwd)){
            return json_encode(['msg'=>'密码3到11位','code'=>1]);
        }
        if(empty($admin_email)){
            return json_encode(['msg'=>'邮箱不能为空','code'=>1]);
        }
        $reg='/^[a-z0-9]+([._-][a-z0-9]+)*@([0-9a-z]+\.[a-z]{2,14}(\.[a-z]{2})?)$/i';
        if(!preg_match($reg,$admin_email)){
            return json_encode(['msg'=>'请输入正确的邮箱','code'=>1]);
        }
        if(empty($admin_tel)){
            return json_encode(['msg'=>'电话不能为空','code'=>1]);
        }
        $regtel='/^1[3-9]\d{9}$/';
        if(!preg_match($regtel,$admin_tel)){
            return json_encode(['msg'=>'请输入正确格式的手机号','code'=>1]);
        }


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
        $admininfo = DB::table('app_admin')->where('is_del',0)->paginate(4);
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
//        print_r($admin_id);exit;
        if(empty($admin_name)){
            return json_encode(['msg'=>'管理员名称不能为空','code'=>1]);
        }
        $data = DB::table('app_admin')->where('admin_name',$admin_name)->value('admin_name');
        $data_id = DB::table('app_admin')->where('admin_name',$admin_name)->value('admin_id');
//        print_r($data);exit;
        if($admin_name == $data && $admin_id != $data_id){
            return json_encode(['msg'=>'该名称已存在','code'=>1]);
        }
        if(empty($admin_email)){
            return json_encode(['msg'=>'邮箱不能为空','code'=>1]);
        }
        $reg='/^[a-z0-9]+([._-][a-z0-9]+)*@([0-9a-z]+\.[a-z]{2,14}(\.[a-z]{2})?)$/i';
        if(!preg_match($reg,$admin_email)){
            return json_encode(['msg'=>'请输入正确的邮箱','code'=>1]);
        }
        if(empty($admin_tel)){
            return json_encode(['msg'=>'电话不能为空','code'=>1]);
        }
        $regtel='/^1[3-9]\d{9}$/';
        if(!preg_match($regtel,$admin_tel)){
            return json_encode(['msg'=>'请输入正确格式的手机号','code'=>1]);
        }

        $datainfo=[
            'admin_name'=>$admin_name,
            'admin_email'=>$admin_email,
            'admin_tel'=>$admin_tel,
        ];
        $res = DB::table('app_admin')->where('admin_id',$admin_id)->update($datainfo);
        if($res){
            echo json_encode(['msg'=>'修改成功','code'=>0]);
        }else{
            echo json_encode(['msg'=>'未修改','code'=>2]);
        }
    }
    //赋予角色页面
    public function roleDo(Request $request){
        $admin_id = $request->input('admin_id');
        $admininfo = DB::table('app_admin')->where('admin_id',$admin_id)->first();
        $roleinfo = DB::table('app_role')->get();

        $role_id = DB::table('app_admin_role')->where('admin_id',$admin_id)->first();
//        print_r($role_id);exit;
        return view('admin.admin.roledo',['admininfo'=>$admininfo,'roleinfo'=>$roleinfo,'role_id'=>$role_id]);
    }
    //执行赋予
    public function adminrole(Request $request){
        $admin_id = $request->input('admin_id');
        $role_id = $request->input('role_id');

        $res = DB::table('app_admin_role')->where('admin_id',$admin_id)->first();
        $data = [
            'admin_id'=>$admin_id,
            'role_id'=>$role_id
        ];
        if($res){
            DB::table('app_admin_role')->where('admin_id',$admin_id)->update($data);
            return json_encode(['msg'=>'赋予成功','code'=>0,'admin_id'=>$admin_id]);
        }else{
            DB::table('app_admin_role')->where('admin_id',$admin_id)->insert($data);
            return json_encode(['msg'=>'赋予成功','code'=>0]);
        }
    }
    //角色添加展示
    public function roleAdd(){
        $roleinfo = DB::table('app_node')->get();
        return view('admin.admin.roleadd',['roleinfo'=>$roleinfo]);
    }
    //角色的权限查询
    public function roleNodeDo(Request $request){
        $names = $request->input('names');
        $data = DB::table('app_node')->where('node_name','like',"%$names%")->get();
//        print_r($data);exit;
        $objview =view('admin.admin.rolenodedo',['info'=>$data,'names'=>$names]);
        $content = response($objview)->getContent();

        return json_encode(['data'=>$content,'code'=>1]);

    }
    //角色执行添加
    public function roleInsert(Request $request){
        $data = $request->input('data');
        $role_name = $request->input('role_name');

        if(empty($data)){
            return json_encode(['msg'=>'您未选择权限','code'=>1]);
        }
        if(empty($role_name)){
            return json_encode(['msg'=>'名称不能为空','code'=>1]);
        }

        $roleinfo = [
            'role_name'=>$role_name
        ];
        $id = DB::table('app_role')->insertGetId($roleinfo);
        $info = [];
        foreach($data as $k=>$v){
            $info[] = ['role_id'=>$id,'node_id'=>$v];
        }
        $res = DB::table('app_role_node')->insert($info);
        if($res){
            return json_encode(['msg'=>'添加成功','code'=>0]);
        }else{
            return json_encode(['msg'=>'添加失败','code'=>1]);
        }
    }
    //角色展示
    public function roleList(){
        $roleinfo = DB::table('app_role')->where('is_del',0)->paginate(4);
        return view('admin.admin.rolelist',['roleinfo'=>$roleinfo]);

    }
    //角色删除
    public function roleDel(Request $request){
        $role_id = $request->input('role_id');
        $is_del=[
            'is_del'=>1
        ];
        $res = DB::table('app_role')->where('role_id',$role_id)->update($is_del);
        if($res){
            return json_encode(['msg'=>'删除成功','code'=>0]);
        }
    }
    //角色修改页面
    public function roleUpdate(Request $request){
        $role_id = $request->input('role_id');
        $roleinfo = DB::table('app_role')->where('role_id',$role_id)->first();

        $nodeinfo = DB::table('app_node')->get();
        $role_node = DB::table('app_role_node')->where('role_id',$role_id)->pluck('node_id');
        $data = json_decode($role_node);

//        print_r($role_node);exit;
        return view('admin.admin.roleupdate',['roleinfo'=>$roleinfo]);
    }


    public function roleUpdateNodeDo(Request $request){
        $role_id = $request->input('role_id');
        $names = $request->input('names');
        $info = DB::table('app_node')->where('node_name','like',"%$names%")->get();
        $role_node = DB::table('app_role_node')->where('role_id',$role_id)->pluck('node_id');

        $data = json_decode($role_node);
        $objview =view('admin.admin.roleupdatenodedo',['info'=>$info,'data'=>$data,'names'=>$names]);
        $content = response($objview)->getContent();
        return json_encode(['data'=>$content,'code'=>1,'names'=>$names]);
    }
    //角色执行修改
    public function roleUpdateDo(Request $request){

        $data = $request->input('data');
//        print_r($data);exit;
        $role_name = $request->input('role_name');
        $role_id = $request->input('role_id');

        if(empty($data)){
            return json_encode(['msg'=>'选择权限','code'=>1]);
        }
        if(empty($role_name)){
            return json_encode(['msg'=>'名称不能为空','code'=>1]);
        }
        $roleinfo = [
            'role_name'=>$role_name
        ];
        $id = DB::table('app_role')->where('role_id',$role_id)->update($roleinfo);

        $info = [];
        foreach($data as $k=>$v){
            $info[] = ['role_id'=>$role_id,'node_id'=>$v];
        }
        DB::table('app_role_node')->where('role_id',$role_id)->delete();

        $res = DB::Table('app_role_node')->insert($info);
        if($res){
            return json_encode(['msg'=>'添加成功','code'=>0]);
        }else{
            return json_encode(['msg'=>'添加失败','code'=>1]);
        }
    }
    //权限添加展示
    public function nodeAdd(){
        return view('admin.node.nodeadd');
    }
    //权限执行添加
    public function nodeInsert(Request $request){
        $node_name = $request->input('node_name');
        $action_name = $request->input('action_name');

        if(empty($node_name)){
            return json_encode(['msg'=>'名称不能为空','code'=>1]);
        }
        if(empty($action_name)){
            return json_encode(['msg'=>'方法名不能为空','code'=>1]);
        }

        $nodeinfo = [
            'node_name'=>$node_name,
            'action_name'=>$action_name
        ];
        $res = DB::table('app_node')->insert($nodeinfo);
        if($res){
            return json_encode(['msg'=>'添加成功','code'=>0]);
        }else{
            return json_encode(['msg'=>'添加失败','code'=>1]);
        }
    }
    //权限展示
    public function nodeList(){
        $nodeinfo = DB::table('app_node')->where('is_del',0)->paginate(4);
        return view('admin.node.nodelist',['nodeinfo'=>$nodeinfo]);
    }
    //权限删除
    public function nodeDel(Request $request){
        $node_id = $request->input('node_id');
        $is_del=[
            'is_del'=>1
        ];
        $res = DB::table('app_node')->where('node_id',$node_id)->update($is_del);
        if($res){
            echo json_encode(['msg'=>'删除成功','code'=>0]);
        }
    }
    //权限的修改页面
    public function nodeUpdate(Request $request){
        $node_id = $request->input('node_id');
        $nodeinfo = DB::table('app_node')->where('node_id',$node_id)->first();
        return view('admin.node.nodeupdate',['nodeinfo'=>$nodeinfo]);
    }
    //权限的执行修改
    public function nodeUpdataDo(Request $request){
        $node_name = $request->input('node_name');
        $action_name = $request->input('action_name');
        $node_id = $request->input('node_id');

        if(empty($node_name)){
            return json_encode(['msg'=>'名称不能为空','code'=>1]);
        }
        if(empty($action_name)){
            return json_encode(['msg'=>'方法名不能为空','code'=>1]);
        }

        $nodeinfo = [
            'node_name'=>$node_name,
            'action_name'=>$action_name
        ];
        $res = DB::table('app_node')->where('node_id',$node_id)->update($nodeinfo);
        if($res){
            return json_encode(['msg'=>'修改成功','code'=>0]);
        }else{
            return json_encode(['msg'=>'未修改','code'=>1]);
        }
    }
    //优惠券添加
    public function couponAdd(Request $request){
        $goods_id = $request->input('goods_id');
        return view('admin.coupon.couponadd',['goods_id'=>$goods_id]);
    }
    //优惠券执行添加
    public function couponInsert(Request $request){
        $select = $request->input('select');
        $coupon_name = $request->input('coupon_name');
        $coupon_num = $request->input('coupon_num');
        $coupon_attr = $request->input('coupon_attr');
        if(empty($select)){
            return json_encode(['msg'=>'类型不能为空','code'=>1]);
        }
        if(empty($coupon_name)){
            return json_encode(['msg'=>'名称不能为空','code'=>1]);
        }
        if(empty($coupon_num)){
            return json_encode(['msg'=>'数量不能为空','code'=>1]);
        }
        if(empty($coupon_attr)){
            return json_encode(['msg'=>'规格不能为空','code'=>1]);
        }

        $couponinfo = [
            'coupon_type'=>$select,
            'coupon_name'=>$coupon_name,
            'coupon_num'=>$coupon_num,
            'coupon_attr'=>$coupon_attr
        ];

        $res = DB::table('app_coupon')->insert($couponinfo);
        if($res){
            return json_encode(['msg'=>'添加成功','code'=>0]);
        }else{
            return json_encode(['msg'=>'添加失败','code'=>1]);
        }
    }
    //优惠券展示
    public function couponList(){
        $couponinfo = DB::table('app_coupon')
            ->where('coupon_del',0)
            ->paginate(4);
        return view('admin.coupon.couponlist',['couponinfo'=>$couponinfo]);
    }
    //优惠券删除
    public function couponDel(Request $request){
        $coupon_id = $request->input('coupon_id');
        $coupon_del=[
            'coupon_del'=>1
        ];
        $res = DB::table('app_coupon')->where('coupon_id',$coupon_id)->update($coupon_del);
        if($res){
            echo json_encode(['msg'=>'删除成功','code'=>0]);
        }else{
            echo json_encode(['msg'=>'删除失败','code'=>1]);
        }
    }
    //优惠券修改页面
    public function couponUpdate(Request $request){
        $coupon_id = $request->input('coupon_id');
        $couponinfo = DB::table('app_coupon')->where('coupon_id',$coupon_id)->first();
        return view('admin.coupon.couponupdate',['couponinfo'=>$couponinfo]);
    }
    //优惠券执行修改
    public function couponUpdateDo(Request $request){
        $coupon_id = $request->input('coupon_id');
        $coupon_name = $request->input('coupon_name');
        $coupon_num = $request->input('coupon_num');
        $coupon_attr = $request->input('coupon_attr');

        if(empty($coupon_name)){
            return json_encode(['msg'=>'名称不能为空','code'=>1]);
        }
        if(empty($coupon_num)){
            return json_encode(['msg'=>'数量不能为空','code'=>1]);
        }
        if(empty($coupon_attr)){
            return json_encode(['msg'=>'规格不能为空','code'=>1]);
        }

        $couponinfo = [
            'coupon_name'=>$coupon_name,
            'coupon_num'=>$coupon_num,
            'coupon_attr'=>$coupon_attr
        ];
        $res = DB::table('app_coupon')->where('coupon_id',$coupon_id)->update($couponinfo);
        if($res){
            return json_encode(['msg'=>'修改成功','code'=>0]);
        }else{
            return json_encode(['msg'=>'未修改','code'=>1]);
        }
    }
    //类型的添加的页面
    public function typeAdd(){
        return view('admin.goods.typeadd');
    }
    //类型执行添加
    public function typeInsert(Request $request){
        $type_name = $request->input('type_name');
        if(empty($type_name)){
            return json_encode(['msg'=>'名称不能为空','code'=>1]);
        }
        $typeinfo = [
            'type_name'=>$type_name,
            'createtime'=>time()
        ];

        $res = DB::table('app_type')->insert($typeinfo);
        if($res){
            return json_encode(['msg'=>'添加成功','code'=>0]);
        }else{
            return json_encode(['msg'=>'添加失败','code'=>1]);
        }
    }
    //类型展示页面
    public function typeList(){
        $typeinfo = DB::table('app_type')->where('is_del',0)->paginate(4);
        return view('admin.goods.typelist',['typeinfo'=>$typeinfo]);
    }
    //类型的删除
    public function typeDel(Request $request){
        $type_id = $request->input('type_id');
        $is_del=[
            'is_del'=>1
        ];
        $res = DB::table('app_type')->where('type_id',$type_id)->update($is_del);
        if($res){
            echo json_encode(['msg'=>'删除成功','code'=>0]);
        }else{
            echo json_encode(['msg'=>'删除失败','code'=>1]);
        }
    }
    //类型的修改页面
    public function typeUpdate(Request $request){
        $type_id = $request->input('type_id');
        $typeinfo = DB::table('app_type')->where('type_id',$type_id)->first();
        return view('admin.goods.typeupdate',['typeinfo'=>$typeinfo]);
    }
    //类型执行修改
    public function typeUpdateDo(Request $request){
        $typeid= $request->input('typeid');
        $type_name = $request->input('type_name');
        if(empty($type_name)){
            return json_encode(['msg'=>'名称不能为空','code'=>1]);
        }
        $typeinfo = [
            'type_name'=>$type_name,
        ];
        $res = DB::table('app_type')->where('type_id',$typeid)->update($typeinfo);
        if($res){
            return json_encode(['msg'=>'修改成功','code'=>0]);
        }else{
            return json_encode(['msg'=>'未修改','code'=>1]);
        }
    }
    //退出
    public function quit(){
        session()->pull('admin_id');
        session()->pull('admin_name');
        return redirect('adminLogin');
    }
}
