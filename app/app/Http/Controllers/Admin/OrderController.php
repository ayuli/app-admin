<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\OrderModel;

class OrderController extends Controller
{
    //orderGet 后台订单展示
    public function orderGet()
    {
        $data = OrderModel::paginate(4);
        return view('admin.order.orderget',['data'=>$data]);
    }
}
