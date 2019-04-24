<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Model\CateModel;
class CateController extends Controller{
	public function cateshow(Request $request){
		$cate_id = $request->input('cate_id');
        $info = getCateInfo($cate_id);
		$data = json_encode($info);
		return $data;
	}
}