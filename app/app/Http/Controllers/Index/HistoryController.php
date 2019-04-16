<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    public function addhistory(Request $request){
        $goodsis = $request->goodsid;
        $uid = $request->uid;
        $time = time();
        DB::table('app_his')

    }
}
