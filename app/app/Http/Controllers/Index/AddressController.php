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
        if(empty($request)){
            $regin = DB::table('app_regio')->where('p_id',1)->get();
            print_r($regin);
        }
    }
}
