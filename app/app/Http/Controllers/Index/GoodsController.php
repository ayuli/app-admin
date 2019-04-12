<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\GoodsModel;

class GoodsController extends Controller
{
    public function goods()
    {
        $goods = GoodsModel::get();
        $data = [
            'code'  => 0,
            'data'  =>$goods
        ];
        if($goods){
            return json_encode($data,JSON_UNESCAPED_UNICODE);
        }


    }
}
