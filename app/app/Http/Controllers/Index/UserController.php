<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\Model\UserModel;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
    //注册
    public function register(Request $request){
        $name = $request->input('name');
        $yzm = $request->input('yzm');
        $code = $request->cookie($name);
        if($yzm==$code){
            $pd = $request->input('pwd');
            $pwd = md5(md5($pd));
            $time = time();
            $res = DB::table('app_user')->insert(['user_name'=>$name,'user_pwd'=>$pwd,'add_time'=>$time]);
            $res1 = DB::table('app_user')->where(['user_name'=>$name,'user_pwd'=>$pwd])->first();
            $uid = $res1->user_id;
            if($res){
                $request -> session() -> put('user_name',$name);
                echo json_encode(['code'=>1,'uid'=>$uid]);
            }else{
                return 2;//注册失败
            }
        }else{
            return 3;
        }
    }
    //登陆
    public function login(Request $request){
       /* $ses=$request->session()->get('user_name');
        if($request->session()->get('user_name')){
            return 3;
        }*/
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


    /**
     * 忘记密码  点击确认忘记密码
     * 参数  user_name user_pwd user_pwd2 user_code
     * return 1000 验证码以失效 1001 参数不能为空
     *  1002 用户不存在 1003密码不一致 1004 验证码有误
     * return 0  修改成功
     */
    public function forget(Request $request)
    {
        $user_name = $request->input('user_name');
        $user_pwd = $request->input('user_pwd');
        $user_pwd2 = $request->input('user_pwd2');
        $user_code = $request->input('user_code');
        $code = $request->cookie($user_name);
        if($code==''){return returnJson('1000','验证码已失效');}
        $user_info = UserModel::where(['user_name'=>$user_name])->first();
        if($user_name==''||$user_pwd==''||$user_pwd2==''||$user_code=='')
        {return returnJson('1001','参数不能为空');}
        if(!$user_info){return returnJson('1002','用户不存在');}
        if($user_pwd!=$user_pwd2){return returnJson('1003','密码输入不一致');}
        if($user_code != $code){return returnJson('1004','验证码有误');}
        $res = UserModel::where(['user_name'=>$user_name])->update(['user_pwd'=>md5(md5($user_pwd))]); //存数据库
        if($res)
        {setcookie($user_name,'',-1); return returnJson('0','修改成功');}
    }

    /**
     * 获取验证码
     * 参数 user_name
     * return 0 ,code
     */
    public function getVerCode(Request $request)
    {
        $user_name = $request->input('user_name');
        $user_info = UserModel::where(['user_name'=>$user_name])->first();
        if(!$user_info){
            return returnJson('1001','用户不存在');
        }
        //生成验证码
        $rand1 = rand(0,8);
        $rand = md5(rand(10000,99999));
        $str_rand = str_shuffle($rand.$user_name);
        $code = substr($str_rand,$rand1,6);
        // 存数据库 或者缓存
//        Redis::set('code',$code); //存缓存
        Cookie::queue($user_name,$code,1); //存cookie
//        UserModel::where(['user_name'=>$user_name])->update(['user_code'=>$code]); //存数据库
        return returnJson('0','验证码为:'.$code);

    }
		//注册验证码
	    public function getCode(Request $request)
    {
        $user_name = $request->input('user_name');
        $user_info = UserModel::where(['user_name'=>$user_name])->first();
        if(!$user_info){
			//生成验证码
			$rand1 = rand(0,4);
			$rand = rand(1000,9999);
			$str_rand = str_shuffle($rand.$user_name);
			$code = substr($str_rand,$rand1,6);
			// 存数据库 或者缓存
	//        Redis::set('code',$code); //存缓存
			Cookie::queue($user_name,$code,1); //存cookie
	//        UserModel::where(['user_name'=>$user_name])->update(['user_code'=>$code]); //存数据库
        }else{
			return returnJson('1001','用户已存在');
		}
        return returnJson('0','验证码为:'.$code);

    }
        //个人资料展示
        public function  showuserinfo(Request $request){
            $uid=$request->input('uid');
            $res=DB::table('user_info')->where('user_id',$uid)->first();
            $res1=json_encode($res);
            if($res){
                return $res1;
            }else{
                return 2;
            }
        }
        //添加修改个人资料
        public function adduserinfo(Request $request){
            $uid=$request->input('uid');
            $nickname=$request->input('nickname');
            $age=$request->input('age');
            $sex=$request->input('sex');
            if($sex=='保密'){
                $sex='0';
            }elseif ($sex=='男'){
                $sex='1';
            }elseif ($sex=='女'){
                $sex='2';
            }
            $data = array(
              'nickname'=>$nickname,
                'age'=>$age,
                'sex'=>$sex,
            );
            $res1=DB::table('user_info')->where('user_id',$uid)->first();
            if($res1){
                $res=DB::table('user_info')->where('user_id',$uid)->update($data);
            }else{
                $res=DB::table('user_info')->insert(['user_id'=>$uid,'nickname'=>$nickname,'age'=>$age,'sex'=>$sex,]);
            }
            if($res){
                return 1;
            }else{
                return 2;
            }
        }


    //用户头像上传
    public function uploadPortrait(Request $request){
        $user_id=$request->input('user_id');
        $imgInfo=$request->input('data');
        $name=$request->input('name');
        $imgInfo=substr($imgInfo,17);
        $file_name="user/".$user_id."/";
        if(!is_dir($file_name)){
            $res=mkdir($file_name,0777,true);
            if(!$res){
                echo json_encode(['code'=>1,'msg'=>'请稍后再试！']);die;
            }
        }
        $res=file_put_contents($file_name.$name,$imgInfo,FILE_APPEND);
        $touxiangurl=DB::table('user_info')->where('user_id',$user_id)->value('touxiangurl');
        if(!empty($touxiangurl)){
            @unlink($file_name);
        }
        $res=DB::table('user_info')->where('user_id',$user_id)->update(['touxiangurl'=>$file_name]);
        if($res){
            echo json_encode(['code'=>1,'msg'=>'上传成功！']);
        }else{
            echo json_encode(['code'=>1,'msg'=>'请稍后再试！']);
        }
    }
    /**
     *  前台个人中心订单展示
     */
    public function orderGet(Request $request)
    {
        $user_id = $request->input('user_id');
        $type = $request->input('type');
        $arr=DB::table('app_order')
            ->join('app_order_goods','app_order.order_id','=','app_order_goods.order_id')
            ->where(['user_id'=>$user_id,'order_status'=>$type])
            ->get();
        if(count($arr)>0){$data = ['code'=>0,'msg'=>'success','data'=>$arr];}else{
            $data = ['code'=>404,'msg'=>'没有数据'];}
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }

}
