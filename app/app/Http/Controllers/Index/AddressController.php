<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function address(){

    }
    public function getregion(Request $request){
        $pid = $request->input('pid',1);
        if(empty($request)){
            $regin = DB::table('app_regio')->where('p_id',1)->get();
            $data = json_decode($regin,1);
            return $data;
        }else{
            $regin = DB::table('app_regio')->where('p_id',$pid)->get();
            $data = json_decode($regin,1);
            return $data;
        }
    }
}
