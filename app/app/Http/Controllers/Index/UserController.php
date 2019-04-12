<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function register(Request $request){
        $name = $request->input('name');
        $pd = $request->input('pwd');
        $pwd = sha1(md5(md5($pd)));
        $time = time();
        $res = DB::table('app_user')->insert(['user_name'=>$name,'user_pwd'=>$pwd,'add_time'=>$time]);
        if($res){
            return 1;//注册成功
        }else{
            return 2;//注册失败
        }
    }
    public function registersole(Request $request){
        $name = $request->input('name');
        $res = DB::table('app_user')->where('user_name',$name)->first();
        if($res){
            return 2;//已存在
        }else{
            return 1;//唯一
        }
    }
    public function  userCenter(){
        $user = DB::table('app_user')->first();
        $username = $user->user_name;
        $userscore = $user->user_score;
        $pay1 = DB::table('app_order')->where('order_status',1)->count();
        $pay2 = DB::table('app_order')->where('order_status',2)->count();
        $pay3 = DB::table('app_order')->where('order_status',3)->count();
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
}
