<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function address(Request $request){
        $consignee_name = $request->input('consignee_name');
        $detailed_address = $request->input('detailed_address');
        $province = $request->input('province');
        $city = $request->input('city');
        $district = $request->input('district');
        $consignee_tel = $request->input('consignee_tel');
        $info = array(
            'consignee_name'=>$consignee_name,
            'detailed_address'=>$detailed_address,
            'province'=>$province,
            'city'=>$city,
            'district'=>$district,
            'consignee_tel'=>$consignee_tel,

        );
        $res = DB::table('app_address')->insert($info);
        if($res){
            return 1;
        }else{
            return 2;
        }
    }
    public function getregion(Request $request){
        $pid = $request->input('pid',1);
        $regin = DB::table('app_region')->where('p_id',$pid)->get();
        $data = json_decode($regin,1);
        return $data;

    }
}
