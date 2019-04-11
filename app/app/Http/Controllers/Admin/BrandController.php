<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use App\Model\BrandModel;

class BrandController extends Controller
{
    /**
     * 商品品牌添加页面
     */
    public function brand()
    {
        return view('admin.brand.brand');
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
        return view('admin.brand.brandget',$data);
    }

    /**
     * 品牌添加接口
     */
    public function brandAdd(Request $request)
    {
        $name = $request->input('name');
        $url = $request->input('url');
        $is_show = $request->input('redio');
        $data = [
            'brand_name' => $name,
            'site_url' => $url,
            'is_show'   => $is_show
        ];
        $res = BrandModel::insert($data);
        if($res){
            $json = [
                'code'  => 0,
                'msg'   => '添加成功'
            ];
            return  json_encode($json,JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 品牌logo上传
     */
    public function brandLogo(Request $request)
    {
        if ($request->isMethod('POST')) {

            $fileCharater = $request->file('file');
//            var_dump($fileCharater);
            if ($fileCharater->isValid()) {
                $ext = $fileCharater->getClientOriginalExtension();// 文件后缀
                $path = $fileCharater->getRealPath();//获取文件的绝对路径

                $filename = date('Ymdhis') . '.' . $ext;//定义文件名

                Storage::disk('public')->put($filename, file_get_contents($path));

                $file_path = "./logo/" . $filename;
                var_dump($file_path);die;


            }

        }

    }



}
