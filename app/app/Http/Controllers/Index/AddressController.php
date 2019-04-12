<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function getregion(Request $request){
        $pid = $request->input('pid',1);
        $regin = DB::table('app_region')->where('p_id',$pid)->get();
        $data = json_decode($regin,1);
        return $data;

    }
    public function selregion(){
        $regin = DB::table('app_region')->get();
        $data = json_decode($regin,1);
        return $data;
    }
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
        public function addressGet(Request $request){
            $name = $request->session()->get('user_name');
            if($name){
                $info = DB::table('app_address')->where('user_id',$name)->get();
                if($info){
                    return $info;   //查询成功
                }
            }else{
                return 2;   //请先登陆
            }
        }
}
