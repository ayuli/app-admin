<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Model\CateModel;
class CateController extends Controller{
	public function cateshow(Request $request){
		$cate_id = $request->input('cate_id');
		$cate_all = CateModel::where(['is_del'=>0])->get();
        $dat = getCateInfo($cate_all);
        $data = ['data' => $dat];
		$res = json_encode(['code'=>2,'msg'=>'暂无数据！']);
	}
}