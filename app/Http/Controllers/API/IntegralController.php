<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/9
 * Time: 11:02
 */

namespace App\Http\Controllers\API;

use App\Components\IntegralManager;
use App\Http\Controllers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IntegralController extends Controller
{
    /*
     * 获取积分商城列表
     */
    public function getIntegralLists(){
        $integral_goods=IntegralManager::IntegralGoodsLists();
        if ($integral_goods) {
            return ApiResponse::makeResponse(true, $integral_goods, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::MISSING_PARAM], ApiResponse::MISSING_PARAM);
        }
    }
}