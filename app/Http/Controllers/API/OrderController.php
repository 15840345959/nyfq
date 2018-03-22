<?php

namespace App\Http\Controllers\API;

use App\Components\OrderManager;
use App\Components\RequestValidator;
use App\Http\Controllers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /*
     * 所有产品下单
     */
    public function order(Request $request)
    {
        $data = $request->all();
        $TourOrder = OrderManager::addOrders($data);
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
        //合规校验types
        $requestValidationResult = RequestValidator::validator($request->all(), [
            'user_id' => 'required',
        ]);
        if ($requestValidationResult !== true) {
            return ApiResponse::makeResponse(false, $requestValidationResult, ApiResponse::MISSING_PARAM);
        }
        $orders = OrderManager::getOrderByUserId($data['user_id']);
        foreach ($orders as $order){
            $order = OrderManager::getOrderDetailsByLevel($order,'0');
        }
        if ($orders) {
            return ApiResponse::makeResponse(true, $orders, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::MISSING_PARAM], ApiResponse::MISSING_PARAM);
        }
    }

    /*
     *  删除订单里的产品
     */
    public function deleteTourOrder(Request $request)
    {
        $data = $request->all();
        $result = OrderManager::deleteOrderGoods($data);
        if ($result) {
            return ApiResponse::makeResponse(true, $result, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::MISSING_PARAM], ApiResponse::MISSING_PARAM);
        }
    }

    //根据user_id和goods_type获取订单信息
    public function getOrdersByUserIdAndGoodsTye(Request $request){
        $data = $request->all();
        //合规校验types
        $requestValidationResult = RequestValidator::validator($request->all(), [
            'user_id' => 'required',
            'goods_type' => 'required',
        ]);
        if ($requestValidationResult !== true) {
            return ApiResponse::makeResponse(false, $requestValidationResult, ApiResponse::MISSING_PARAM);
        }
        $orders = OrderManager::getOrderByUserIdAndgoods_type($data['user_id'],$data['goods_type']);
        foreach ($orders as $order){
            $order = OrderManager::getOrderDetails($order);
        }
        if ($orders) {
            return ApiResponse::makeResponse(true, $orders, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::MISSING_PARAM], ApiResponse::MISSING_PARAM);
        }
    }

}
