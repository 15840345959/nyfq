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
}
