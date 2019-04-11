<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    //登录页面
    public function adminLogin(){
        return view('admin.login.login');
    }
    //登录执行
    public function adminLoginDo(Request $request){
        $data=$request->input();
        $admin_name=$data['admin_name'];
        $admin_pwd=$data['admin_pwd'];
        $code=$data['code'];
        $codeInfo = session('verifylogin');
        if($code !== $codeInfo){
            echo json_encode(['code'=>2,'msg'=>'验证码有误！']);die;
        }
        $admin_pwd=md5($admin_pwd);
        $admin_info=DB::table('app_admin')->where('admin_name',$admin_name)->first();
        if(!empty($admin_info)){
            if($admin_info->admin_pwd == $admin_pwd){
                echo json_encode(['code'=>1,'msg'=>'登录成功！']);
            }else{
                echo json_encode(['code'=>2,'msg'=>'登录失败！']);
            }
        }else{
            echo json_encode(['code'=>2,'msg'=>'登录失败！']);
        }
    }

    // 验证码
    public function codeImg($tmp){
        //生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder;
        $builder->setIgnoreAllEffects(true);
        $builder->setBackgroundColor(255, 255, 255);
        //可以设置图片宽高及字体
        $builder->build($width = 150, $height = 50, $font = null);
        //获取验证码的内容
        $phrase = $builder->getPhrase();
        //把内容存入session
        session(['verifylogin'=>$phrase]);
        //生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header('Content-Type: image/jpeg');
        $builder->output();
    }



}
