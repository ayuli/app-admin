<?php
namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Model\CateModel;
class CateController extends Controller{
	public function cateshow(Request $request){
		$cate_id = $request->input('cate_id');
		$data = CateModel::get()->toArray();
        $info = getCateInfo($data,$cate_id);
		$res= json_encode(['code'=>1,'msg'=>'没有更多数据了！']);
		return $res; 
	}
}