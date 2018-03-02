<?php

namespace App\Http\Controllers\admin;

use App\Components\OrderManager;
use App\Components\QNManager;
use App\Http\Controllers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ordersController extends Controller
{
    //首页
    public function index(Request $request)
    {
        $data = $request->all();
        $admin = $request->session()->get('admin');
        $orders = OrderManager::getOrders();
        foreach ($orders as $order){
            $order = OrderManager::getOrderDetailsByLevel($order,'1');
        }
        return view('admin.orders.index', ['orders' => $orders,'admin'=>$admin]);
//        return $orders;
    }

    //查看订单详情
    public function getOrderDetails(Request $request)
    {
        $data = $request->all();
//        dd(json_encode($data));
        if (array_key_exists('id', $data)) {
            $orderDetails = OrderManager::getOrderById($data['id']);
            foreach ($orderDetails as $orderDetail){
                $orderDetail = OrderManager::getOrderDetailsByLevel($orderDetail,'0');
            }
            $admin = $request->session()->get('admin');
            //生成七牛token
            $upload_token = QNManager::uploadToken();
            return view('admin.orders.orderDetails', ['admin' => $admin, 'datas' => $orderDetails, 'upload_token' => $upload_token]);
        } else {
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '非法访问']);
        }
    }

    //设置订单状态
    public function setOrderStatus(Request $request,$id){
        $data = $request->all();
        if (is_numeric($id) !== true) {
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '合规校验失败，请检查参数轮播图id$id']);
        }
        $order = OrderManager::getOrdersById($id);
        $order -> status = $data['status'];
        $order->save();
        return ApiResponse::makeResponse(true,$order,ApiResponse::SUCCESS_CODE);
    }







}












