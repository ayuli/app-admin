<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //注册
    public function register(Request $request){
        $name = $request->input('name');
        $pd = $request->input('pwd');
        $pwd = md5(md5($pd));
        $time = time();
        $res = DB::table('app_user')->insert(['user_name'=>$name,'user_pwd'=>$pwd,'add_time'=>$time]);
        if($res){
            $request -> session() -> put('user_name',$name);
            return 1;//注册成功
        }else{
            return 2;//注册失败
        }
    }
    //登陆
    public function login(Request $request){
        $ses=$request->session()->get('user_name');
        if($request->session()->get('user_name')){
            return 3;
        }
        $name = $request->input('name');
        $pd = $request->input('pwd');
        $pwd = md5(md5($pd));
        $res = DB::table('app_user')->where(['user_name'=>$name,'user_pwd'=>$pwd])->first();
        $uid = $res->user_id;
        if($res){
            $request -> session() -> put('user_name',$name);
            echo json_encode(['code'=>1,'uid'=>$uid]);
        }else{
            return 2;//登陆失败
        }
    }
    //验证唯一
    public function registersole(Request $request){
        $name = $request->input('name');
        $res = DB::table('app_user')->where('user_name',$name)->first();
        if($res){
            return 2;//已存在
        }else{
            return 1;//唯一
        }
    }
    //个人中心页面展示数据
    public function  userCenter(Request $request){
        $uid = $request->uid;
        $user = DB::table('app_user')->where('user_id',$uid)->first();
        $username = $user->user_name;
        $userscore = $user->user_score;
        $data1=array(
            'user_id'=>$uid,
            'order_status'=>1
        );
        $data2=array(
            'user_id'=>$uid,
            'order_status'=>2
        );
        $data3=array(
            'user_id'=>$uid,
            'order_status'=>3
        );
        $pay1 = DB::table('app_order')->where($data1)->count();
        $pay2 = DB::table('app_order')->where($data2)->count();
        $pay3 = DB::table('app_order')->where($data3)->count();
        $order = DB::table('app_order')->count();
        $info = array(
                    'username' =>$username,
                    'userscore' =>$userscore,
                    'pay1' =>$pay1,
                    'pay2' =>$pay2,
                    'pay3' =>$pay3,
                    'order' =>$order,
                );
        $data = json_encode($info);
        return $data;
    }
    //退出登陆
    public function outlogin(Request $request){
        $res = $request->session()->pull('user_name');
        if($res){
            return 1;//退出
        }else{
            return 2;//未退出
        }
    }
}
