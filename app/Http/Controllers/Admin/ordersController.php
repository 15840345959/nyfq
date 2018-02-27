<?php

namespace App\Http\Controllers\admin;

use App\Components\OrderManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ordersController extends Controller
{
    //首页
    public function index(Request $request)
    {
        $data = $request->all();
        $orders = OrderManager::getAllOrders($data);
        return view('admin.orders.index', ['orders' => $orders]);
//        return $orders;
    }

    //查看订单详情
    public function edit(Request $request)
    {
        $data = $request->all();
//        dd(json_encode($data));
        if (array_key_exists('id', $data)) {
            $admin = $request->session()->get('admin');
            $orderDetail = OrderManager::getOrderById($data['id']);
            $param = array(
                'admin' => $admin,
                'data' => $orderDetail
            );
//            dd(json_encode($param));
            return view('admin.orders.edit', $param);
        } else {
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '非法访问']);
        }
    }
}
