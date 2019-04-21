<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    //三级联动
    public function getregion(Request $request){
        $pid = $request->input('pid',1);
        $regin = DB::table('app_region')->where('p_id',$pid)->get();
        $data = json_decode($regin,1);
        return $data;

    }
    //查询所有三级联动id
    public function selregion(){
        $regin = DB::table('app_region')->get();
        $data = json_decode($regin,1);
        return $data;
    }
    //添加收货地址
    public function address(Request $request){
        $consignee_name = $request->input('consignee_name');
        $detailed_address = $request->input('detailed_address');
        $province = $request->input('province');
        $city = $request->input('city');
        $district = $request->input('district');
        $consignee_tel = $request->input('consignee_tel');
        $is_address = $request->input('is_address');
        if($is_address==1){
            DB::table('app_address')->update(['is_address'=>0]);
        }
        $info = array(
            'consignee_name'=>$consignee_name,
            'detailed_address'=>$detailed_address,
            'province'=>$province,
            'city'=>$city,
            'district'=>$district,
            'consignee_tel'=>$consignee_tel,
            'is_address'=>$is_address,

        );
        $res = DB::table('app_address')->insert($info);
        if($res){
            return 1;   //添加成功
        }else{
            return 2;   //添加失败
        }
    }
    //修改收获地址
    public function upaddress(Request $request){
        $consignee_name = $request->input('consignee_name');
        $detailed_address = $request->input('detailed_address');
        $province = $request->input('province');
        $city = $request->input('city');
        $district = $request->input('district');
        $consignee_tel = $request->input('consignee_tel');
        $is_address = $request->input('is_address');
        $id = $request->input('id');
        if($is_address==1){
            DB::table('app_address')->update(['is_address'=>0]);
        }
        $info = array(
            'consignee_name'=>$consignee_name,
            'detailed_address'=>$detailed_address,
            'province'=>$province,
            'city'=>$city,
            'district'=>$district,
            'consignee_tel'=>$consignee_tel,
            'is_address'=>$is_address,

        );
        $res = DB::table('app_address')->where('id',$id)->update($info);
        if($res){
            return 1;   //修改成功
        }else{
            return 2;   //修改失败
        }
    }
        //查询收获地址
    public function addressGet(Request $request){
            $user_id=$request->input('user_id');
            if($user_id){
                $info = DB::table('app_address')->where('user_id',$user_id)->get();
                if($info){
                    return $info;   //查询成功
                }
            }else{
                return 2;   //请先登陆
            }
    }
        //删除收获地址
    public function deladdress(Request $request){
        $id = $request->id;
        $res = DB::table('app_address')->where('id',$id)->delete();
        if($res){
            return 1;
        }else{
            return 2;
        }
    }
}
