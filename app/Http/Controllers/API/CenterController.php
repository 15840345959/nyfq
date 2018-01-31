<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/8
 * Time: 18:43
 */

namespace App\Http\Controllers\API;

use App\Components\CollectionManager;
use App\Components\IntegralManager;
use App\Components\UserManager;
use App\Http\Controllers\ApiResponse;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class CenterController extends Controller
{

    /*
     * 查看收藏夹
     */
    public function getCollectionLists(Request $request){
        $data = $request->all();
        $user_id=$data['user_id'];
        $collections=CollectionManager::getCollectionListsByUserId($user_id);
        if ($collections) {
            $rows['count']=count($collections);
            $rows['collections']=$collections;
            return ApiResponse::makeResponse(true, $rows, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::MISSING_PARAM], ApiResponse::MISSING_PARAM);
        }
    }
    /*
     * 添加收藏
     */
    public function addCollectionGoods(Request $request){
        $data = $request->all();
        $collection=CollectionManager::addCollectionGoods($data);
        if ($collection) {
            return ApiResponse::makeResponse(true, $collection, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::MISSING_PARAM], ApiResponse::MISSING_PARAM);
        }
    }
    /*
     *  删除收藏夹里的产品
     */
    public function deleteCollectionLists(Request $request){
        $data = $request->all();
        $result=CollectionManager::deleteCollectionGoods($data);
        if ($result) {
            return ApiResponse::makeResponse(true, $result, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::MISSING_PARAM], ApiResponse::MISSING_PARAM);
        }
    }
    /*
     * 签到
     */
    public function addSign(Request $request){
        $data = $request->all();
        $user=IntegralManager::updateUserSign($data);
        if ($user) {
            return ApiResponse::makeResponse(true, $user, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::MISSING_PARAM], ApiResponse::MISSING_PARAM);
        }
    }
    /*
     * 我的邀请
     */
    public function getMyInvitation(Request $request){
        $data = $request->all();
        $users=UserManager::getMyInvitationById($data);
        if ($users) {
            return ApiResponse::makeResponse(true, $users, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::MISSING_PARAM], ApiResponse::MISSING_PARAM);
        }
    }
}