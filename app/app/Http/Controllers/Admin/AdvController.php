<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\Model\AdvModel;
use App\Model\GoodsModel;

class AdvController extends Controller
{

    //轮播图
    public function slide()
    {
        $goods = AdvModel::where(['slide_show'=>1,'is_del'=>0])->orderBy('add_time','desc')->limit(6)->get();
        $data = ['code'=>0,'msg'=>'success','data'=>$goods];
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }


    //广告添加展示
    public function adv()
    {
        return view('admin.adv.adv');
    }

    //广告添加执行
    public function advAdd(Request $request)
    {
        $name = $request->input('name');
        $logo = $request->input('logo');
        $is_show = $request->input('is_show');
        $slide_show = $request->input('slide_show');
        if($name==''|| $logo==''){return returnJson('111','请填写完整');}
        if($is_show==1){DB::table('app_ad')->update(['is_show'=>2]);}
        $data = ['ad_title'=>$name,'ad_img'=>$logo,'add_time'=>time(),'is_show'=>$is_show,'slide_show'=>$slide_show];
        $res = AdvModel::insert($data);
        if($res){return returnJson('0','添加成功');
        }else{
            return returnJson('110','添加失败');}
    }

    //广告列表展示
    public function advGet()
    {
        $adv_all = AdvModel::where(['is_del'=>0])->paginate(4);
        $data = ['data' => $adv_all];
        return view('admin.adv.advget',$data);
    }
    //app广告展示
    public function appAdvGet()
    {
        $adv = AdvModel::where(['is_del'=>0,'is_show'=>1])->first();
        $data = ['code'=>0,'msg'=>'success','img' => $adv['ad_img']];
        return  json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    //删除
    public function advDel(Request $request)
    {
        $ad_id = $request->input('ad_id');
        $arr = AdvModel::where(['ad_id'=>$ad_id])->first();
        if($arr['is_show']==1){ return returnJson('120','该广告已展示,不允许删除');}
        $res = AdvModel::where(['ad_id'=>$ad_id])->update(['is_del'=>1]);
        if($res)
        {return returnJson('0','删除成功');}
        else
        {return returnJson('110','删除失败');}
    }

    //修改展示
    public function advUpda(Request $request)
    {
        $ad_id = $request->input('ad_id');
        $ad_first = AdvModel::where(['ad_id'=>$ad_id])->first();
        $data = ['arr'=>$ad_first];
        return view('admin.adv.advupda',$data);
    }

    // 修改执行
    public function advUpdaDo(Request $request)
    {
        $name = $request->input('name');
        $logo = $request->input('logo');
        $ad_id = $request->input('ad_id');
        $is_show = $request->input('is_show');
        $slide_show = $request->input('slide_show');
        if($ad_id==''){echo "非法操作";}
        if($name==''|| $logo==''){return returnJson('100','请填写完整');}
        if($is_show==1){DB::table('app_ad')->update(['is_show'=>2]);}
        $data = ['ad_title'=>$name,'ad_img'=>$logo,'is_show'=>$is_show,'slide_show'=>$slide_show];
        $res = AdvModel::where(["ad_id"=>$ad_id])->update($data);
        if($res!==false){
            $json = ['code'  => 0, 'msg'   => '修改成功'];
        }else{
            $json = ['code'  => 110, 'msg'   => '修改失败'];
        }
        return  json_encode($json,JSON_UNESCAPED_UNICODE);
    }

    //设为默认
    public  function advDefault(Request $request)
    {
        $ad_id = $request->input('ad_id');
        DB::table('app_ad')->update(['is_show'=>2]);
        DB::table('app_ad')->where(['ad_id'=>$ad_id])->update(['is_show'=>1]);
        return returnJson('0','已设为默认');
    }



}
