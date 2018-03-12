<?php
/**
 * Created by PhpStorm.
 * User: mtt17
 * Date: 2018/3/12
 * Time: 11:09
 */

namespace App\Http\Controllers\api;


use App\Components\TicketGoodsManager;
use App\Http\Controllers\ApiResponse;
use Illuminate\Http\Request;

class TicketGoodsController
{
    //获取所有抢票信息
    public function getTicketGoodsList(Request $request){
        $data = $request->all();
        $ticketGoodsList = TicketGoodsManager::getTicketGoodsList($data);
        if($ticketGoodsList){
            return ApiResponse::makeResponse(true,$ticketGoodsList,ApiResponse::SUCCESS_CODE);
        }else{
            return ApiResponse::makeResponse(false,ApiResponse::$errorMassage[ApiResponse::MISSING_PARAM],ApiResponse::MISSING_PARAM);
        }
    }




}



