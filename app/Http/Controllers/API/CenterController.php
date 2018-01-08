<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/8
 * Time: 18:43
 */

namespace App\Http\Controllers\API;

use App\Components\CollectionManager;
use App\Http\Controllers\ApiResponse;
use App\Http\Controllers\Controller;
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
            return ApiResponse::makeResponse(true, $collections, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::MISSING_PARAM], ApiResponse::MISSING_PARAM);
        }
    }
}