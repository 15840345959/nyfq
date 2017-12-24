<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/23
 * Time: 9:05
 */

namespace App\Http\Controllers\API;

use App\Components\CommentManager;
use App\Http\Controllers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class CommentController extends Controller
{
    /*
     * 获取产品的评论详情
     */
    public function getGoodsCommentLists(Request $request){
        $data = $request->all();
        $comments['count']=CommentManager::getGoodsCommentListsCount($data);
        $comments['lists']=CommentManager::getGoodsCommentLists($data);
        if ($comments) {
            return ApiResponse::makeResponse(true, $comments, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::MISSING_PARAM], ApiResponse::MISSING_PARAM);
        }
    }
    /*
     * 获取所有评论的详情
     */
    public function getAllCommentLists(Request $request){
        $data = $request->all();
        $comments['count']=CommentManager::getGoodsCommentListsCount();
        $comments['lists']=CommentManager::getGoodsCommentLists($data);
        if ($comments) {
            return ApiResponse::makeResponse(true, $comments, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::MISSING_PARAM], ApiResponse::MISSING_PARAM);
        }
    }
    /*
     * 用户对评论进行点赞
     */
    public function addConsent(Request $request){
        $data = $request->all();
        $consents=CommentManager::addConsentWithUser($data);
        if ($consents) {
            return ApiResponse::makeResponse(true, $consents, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::MISSING_PARAM], ApiResponse::MISSING_PARAM);
        }
    }
    /*
     * 添加评论
     */
    public function addComment(Request $request){
        $data = $request->all();
        $comment=CommentManager::addComment($data);
        if ($comment) {
            return ApiResponse::makeResponse(true, $comment, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::MISSING_PARAM], ApiResponse::MISSING_PARAM);
        }
    }
}