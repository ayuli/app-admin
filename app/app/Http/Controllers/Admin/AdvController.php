<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\AdvModel;

class AdvController extends Controller
{
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
        if($name==''|| $logo==''){
            $json = ['code'  => 111, 'msg'   => '请填写完整'];
            return  json_encode($json,JSON_UNESCAPED_UNICODE);
        }
        $data = [
            'ad_title' => $name,
            'ad_img' =>  $logo,
            'add_time'   =>time()
        ];
        $res = AdvModel::insert($data);
        if($res){
            $json = ['code'  => 0, 'msg'   => '添加成功'];
        }else{
            $json = ['code'  => 110, 'msg'   => '添加失败'];
        }

        return  json_encode($json,JSON_UNESCAPED_UNICODE);

    }

    //广告列表展示
    public function advGet()
    {
        $adv_all = AdvModel::where(['is_del'=>0])->paginate(4);
        $data = ['data' => $adv_all];
        return view('admin.adv.advget',$data);
    }

    //删除
    public function advDel(Request $request)
    {
        $ad_id = $request->input('ad_id');
        $res = AdvModel::where(['ad_id'=>$ad_id])->update(['is_del'=>1]);
        if($res){
            $json = ['code' => 0, 'msg'   => '删除成功'];
        }else{
            $json=['code' => 110, 'msg'   => '删除失败'];
        }
        return json_encode($json,JSON_UNESCAPED_UNICODE);
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
        if($ad_id==''){echo "非法操作";}
        if($name==''|| $logo==''){
            $json = ['code'  => 100, 'msg'   => '请填写完整'];
            return  json_encode($json,JSON_UNESCAPED_UNICODE);
        }
        $data = ['ad_title' => $name, 'ad_img' =>  $logo,];

        $res = AdvModel::where(["ad_id"=>$ad_id])->update($data);
        if($res!==false){
            $json = ['code'  => 0, 'msg'   => '修改成功'];
        }else{
            $json = ['code'  => 110, 'msg'   => '修改失败'];
        }
        return  json_encode($json,JSON_UNESCAPED_UNICODE);
    }


}
