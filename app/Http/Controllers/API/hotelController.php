<?php

namespace App\Http\Controllers\api;

use App\Components\HotelGoodsManager;
use App\Http\Controllers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class hotelController extends Controller
{
    /*
     * 获取机票列表
     */
    public function getHotel(Request $request){
        $data = $request->all();
        $hotelGoodsList=HotelGoodsManager::getHotelGoodsList($data);
        if ($hotelGoodsList) {
            return ApiResponse::makeResponse(true, $hotelGoodsList, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::MISSING_PARAM], ApiResponse::MISSING_PARAM);
        }
    }
}
