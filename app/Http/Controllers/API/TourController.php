<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/22
 * Time: 16:45
 */

namespace App\Http\Controllers\API;

use App\Components\TourCategorieManager;
use App\Http\Controllers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class TourController extends Controller
{
    /*
     * 获取旅游产品的目的地
     */
    public function getTourCategories(Request $request){
        $data = $request->all();
        $type=$data['type'];
        $categories=TourCategorieManager::getCategorieLists($type);
        if ($categories) {
            return ApiResponse::makeResponse(true, $categories, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::NO_USER], ApiResponse::NO_USER);
        }
    }
}