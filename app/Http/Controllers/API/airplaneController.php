<?php

namespace App\Http\Controllers\api;

use App\Components\PlanGoodsManager;
use App\Http\Controllers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class airplaneController extends Controller
{
    /*
     * 获取机票列表
     */
    public function getTicket(Request $request){
        $data = $request->all();
        $tour_goodses=PlanGoodsManager::getPlaneGoodsList($data);
        if ($tour_goodses) {
            return ApiResponse::makeResponse(true, $tour_goodses, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::MISSING_PARAM], ApiResponse::MISSING_PARAM);
        }
    }
}
