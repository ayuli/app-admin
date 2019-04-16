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
     * 商品品牌展示接口
     */
    public function brandGet()
    {
        $brand_all = BrandModel::where(['is_del'=>0])->paginate(4);
        $data = [
            'data' => $brand_all
        ];
        return view('admin.brand.brandget',$data);
    }

    /**
     * 品牌删除接口
     */
    public function brandDel(Request $request)
    {
        $brand_id = $request->input('brand_id');
        $res = BrandModel::where(['brand_id'=>$brand_id])->update(['is_del'=>1]);
        if($res){
            $json = ['code' => 0, 'msg'   => '删除成功'];
        }else{
            $json=['code' => 110, 'msg'   => '删除失败'];
        }
        return json_encode($json,JSON_UNESCAPED_UNICODE);
    }

    /**
     * 品牌修改展示
     */
    public function brandUpda(Request $request)
    {
        $brand_id = $request->input('brand_id');
        $brand_first = BrandModel::where(['brand_id'=>$brand_id])->first();
        $data = [
            'brand'=>$brand_first
        ];
        return view('admin.brand.brandupda',$data);
    }

    /**
     * 品牌修改执行接口
     */
    public function brandUpdaDo(Request $request)
    {
        $name = $request->input('name');
        $url = $request->input('url');
        $is_show = $request->input('redio');
        $brand_id = $request->input('brand_id');
        if($brand_id==''){
            echo "非法操作";
        }
        $logo = $request->input('logo');
        if($name==''|| $url=="" || $logo==''){
            $json = ['code'  => 100, 'msg'   => '请填写完整'];
            return  json_encode($json,JSON_UNESCAPED_UNICODE);
        }
        $data = [
            'brand_name' => $name,
            'site_url' => $url,
            'is_show'   => $is_show,
            'brand_logo' => $logo
        ];
        $res = BrandModel::where(["brand_id"=>$brand_id])->update($data);
        if($res!==false){
            $json = ['code'  => 0, 'msg'   => '修改成功'];
        }else{
            $json = ['code'  => 110, 'msg'   => '修改失败'];
        }
        return  json_encode($json,JSON_UNESCAPED_UNICODE);

    }

    /**
     * 品牌添加接口
     */
    public function brandAdd(Request $request)
    {
        $name = $request->input('name');
        $url = $request->input('url');
        $is_show = $request->input('redio');
        $logo = $request->input('logo');
        if($name==''|| $url=="" || $logo==''){
            $json = ['code'  => 111, 'msg'   => '请填写完整'];
            return  json_encode($json,JSON_UNESCAPED_UNICODE);
        }
        $data = [
            'brand_name' => $name,
            'site_url' => $url,
            'is_show'   => $is_show,
            'brand_logo' =>  $logo
        ];
        $res = BrandModel::insert($data);
        if($res){
            $json = ['code'  => 0, 'msg'   => '添加成功'];
        }else{
            $json = ['code'  => 110, 'msg'   => '添加失败'];
        }

        return  json_encode($json,JSON_UNESCAPED_UNICODE);

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

            }

        }
        return json_encode($file_path);
    }


}
