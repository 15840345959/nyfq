<?php

namespace App\Http\Controllers\api;

use App\Components\CarGoodsManager;
use App\Http\Controllers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class carController extends Controller
{
    /*
     * 获取车导列表
     */
    public function getCar(Request $request){
        $data = $request->all();
        $hotelGoodsList=CarGoodsManager::getCarGoodsList($data);
        if ($hotelGoodsList) {
            return ApiResponse::makeResponse(true, $hotelGoodsList, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::MISSING_PARAM], ApiResponse::MISSING_PARAM);
        }
    }
}
