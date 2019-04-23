<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\OrderModel;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //orderGet 后台订单展示
    public function orderGet()
    {
        $data = OrderModel::join('app_user','app_order.user_id','app_user.user_id')->paginate(4);
        return view('admin.order.orderget',['data'=>$data]);
    }

    /**
     *  订单详情
     */
    public function orderDetails(Request $request)
    {
        $order_id = $request->input('order_id');

        $data = OrderModel::join('app_order_goods','app_order.order_id','=','app_order_goods.order_id')
            ->join('app_user','app_order.user_id','=','app_user.user_id')->where(['app_order.order_id'=>$order_id])->get();
        return view('admin.order.orderdetails',['data'=>$data]);
    }

}
