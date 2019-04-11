<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function register(){

    }
    public function registersole(Request $request){
        $name = $request->input('name');
        $res = DB::table('app_user')->where('username',$name)->first();
        if($res){
            return 1;
        }else{
            return 2;
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
