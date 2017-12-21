<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/21
 * Time: 14:30
 */

namespace App\Http\Controllers\API;

use App\Components\HomeManager;
use App\Components\IndexManager;
use App\Http\Controllers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /*
     * 获取首页Banners
     */
    public function getBanners(){
        $banners=IndexManager::getBannnerLists();
        if ($banners) {
            return ApiResponse::makeResponse(true, $banners, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::NO_USER], ApiResponse::NO_USER);
        }
    }
    /*
     * 获取Banner详情
     */
    public function getBannerDetail(Request $request){
        $data = $request->all();
        $id=$data['id'];
        $banner=IndexManager::getBannnerById($id);
        if ($banner) {
            return ApiResponse::makeResponse(true, $banner, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::NO_USER], ApiResponse::NO_USER);
        }
    }
    /*
     * 获取首页的动态栏目
     */
    public function getIndexMenus(){
        $menus=IndexManager::getIndexMenuLists(0);
        if ($menus) {
            return ApiResponse::makeResponse(true, $menus, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::NO_USER], ApiResponse::NO_USER);
        }
    }
    /*
     * 获取首页最新产品
     */
    public function getNewGoods(Request $request){
        $data = $request->all();
        $tour_goodses=IndexManager::getNewTourGoodes($data);
        if ($tour_goodses) {
            return ApiResponse::makeResponse(true, $tour_goodses, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::NO_USER], ApiResponse::NO_USER);
        }
    }
}