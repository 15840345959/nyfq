<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/9
 * Time: 11:02
 */

namespace App\Http\Controllers\API;

use App\Components\IntegralManager;
use App\Components\UserManager;
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
    /*
     * 获取用户积分明细列表
     */
    public function getIntegralDetaileLists(Request $request){
        $data = $request->all();
        $user_id=$data['user_id'];
        $integral_details=IntegralManager::getIntegralDetaileListsByUser($user_id);
        if ($integral_details) {
            return ApiResponse::makeResponse(true, $integral_details, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::MISSING_PARAM], ApiResponse::MISSING_PARAM);
        }
    }
    /*
     * 游客端——获取积分兑换历史
     */
    public function getIntegralHistoryListsForUser(Request $request){
        $data = $request->all();
        $user_id=$data['user_id'];
        $integral_histories=IntegralManager::getIntegralHistoryForUser($user_id);
        if ($integral_histories) {
            return ApiResponse::makeResponse(true, $integral_histories, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::MISSING_PARAM], ApiResponse::MISSING_PARAM);
        }
    }
    /*
     * 游客端——兑换积分商品
     */
    public function addIntegralHistory(Request $request){
        $data = $request->all();
        $integral_histories=IntegralManager::setIntegralStatusById($data);
        if ($integral_histories) {
            return ApiResponse::makeResponse(true, $integral_histories, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::MISSING_PARAM], ApiResponse::MISSING_PARAM);
        }
    }
    /*
     * 旅行社端——获取积分兑换历史
     */
    public function getIntegralHistoryListsForOrganization(Request $request){
        $data = $request->all();
        $user_id=$data['user_id'];
        $user=UserManager::getUserInfoById($user_id);
        if($user['type']==1){
            $integral_histories=IntegralManager::getIntegralHistoryForOrganization($user['organization_id']);
            if ($integral_histories) {
                return ApiResponse::makeResponse(true, $integral_histories, ApiResponse::SUCCESS_CODE);
            } else {
                return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::MISSING_PARAM], ApiResponse::MISSING_PARAM);
            }
        }
        else{
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::FAIL_USER_TYPE], ApiResponse::FAIL_USER_TYPE);
        }
    }
    /*
     * 旅行社端——修改兑换状态
     */
    public function updateIntegralStatusById(Request $request){
        $data = $request->all();
        $user_id=$data['user_id'];
        $user=UserManager::getUserInfoById($user_id);
        if($user['type']==1){
            $integral_histories=IntegralManager::setIntegralStatusById($data);
            if ($integral_histories) {
                return ApiResponse::makeResponse(true, $integral_histories, ApiResponse::SUCCESS_CODE);
            } else {
                return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::MISSING_PARAM], ApiResponse::MISSING_PARAM);
            }
        }
        else{
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::FAIL_USER_TYPE], ApiResponse::FAIL_USER_TYPE);
        }
    }
}