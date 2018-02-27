<?php

namespace App\Http\Controllers\api;

use App\Components\CustomizationManager;
use App\Components\PlanGoodsManager;
use App\Http\Controllers\ApiResponse;
use App\Models\Customization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class customizationController extends Controller
{
    /*
     * 获取成型套餐列表
     */
    public function getCustomization(Request $request)
    {
        $data = $request->all();
        $customization = PlanGoodsManager::getCustomizationList($data);
        if ($customization) {
            return ApiResponse::makeResponse(true, $customization, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::MISSING_PARAM], ApiResponse::MISSING_PARAM);
        }
    }
    /*
     * 获取成型套餐详情根据id
     */
    public function getByIdCustomization(Request $request)
    {
        $data = $request->all();
        $customization = CustomizationManager::getCustomizationByid($data['id']);
        if ($customization) {
            return ApiResponse::makeResponse(true, $customization, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::MISSING_PARAM], ApiResponse::MISSING_PARAM);
        }
    }
}
