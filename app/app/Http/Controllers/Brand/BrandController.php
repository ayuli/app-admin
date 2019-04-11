<?php

namespace App\Http\Controllers\Brand;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\BrandModel;

class BrandController extends Controller
{
    /**
     * 商品品牌添加页面
     */
    public function brand()
    {
        return view('brand.brand');
    }

    /**
     * 商品品牌展示
     */
    public function brandGet()
    {
        $brand_all = BrandModel::all();
        $data = [
            'data' => $brand_all
        ];
        return view('brand.brandget',$data);
    }

    /**
     * 品牌添加接口
     */
    public function brandAdd()
    {

    }

    /**
     * 品牌logo上传
     */
    public function brandLogo(Request $request)
    {
        echo 111;die;
        $data = $request->input();
        var_dump($data);
    }



}
