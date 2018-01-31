<?php

namespace App\Http\Controllers\API;

use App\Components\OrderManager;
use App\Http\Controllers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /*
     * 旅游产品下单
     */
    public function tourOrder(Request $request)
    {
        $data = $request->all();
        $TourOrder = OrderManager::addTourOrders($data);
        if ($TourOrder) {
            return ApiResponse::makeResponse(true, $TourOrder, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::MISSING_PARAM], ApiResponse::MISSING_PARAM);
        }
    }

    /*
     * 查询订单
     */
    public function getTourOrder(Request $request)
    {
        $data = $request->all();
        $user_id=$data['user_id'];
        $orders=OrderManager::getUserIdListsByUserId($user_id);
        LOG:info("order : " . $orders);
        if ($orders) {
            return ApiResponse::makeResponse(true, $orders, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::MISSING_PARAM], ApiResponse::MISSING_PARAM);
        }
    }

    /*
     *  删除订单里的产品
     */
    public function deleteTourOrder(Request $request){
        $data = $request->all();
        $result=OrderManager::deleteOrderGoods($data);
        if ($result) {
            return ApiResponse::makeResponse(true, $result, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::MISSING_PARAM], ApiResponse::MISSING_PARAM);
        }
    }

}
