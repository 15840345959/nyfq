<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/23
 * Time: 9:08
 */

namespace App\Components;

use App\Http\Controllers\ApiResponse;
use App\Models\Comment;
use App\Models\CommentImage;
use App\Models\CommentReplie;

class CommentManager
{

    /*
     * 获取产品的评论的总数
     *
     * by zm
     *
     * 2017-12-22
     *
     */
    public static function getGoodsCommentListsCount($data){
        $where=array(
            'goods_id'=>$data['goods_id'],
            'goods_type'=>$data['goods_type'],
            'examine'=>1
        );
        $count=Comment::where($where)->count();
        return $count;
    }
    /*
     * 获取产品的评论详情
     *
     * by zm
     *
     * 2017-12-22
     *
     */
    public static function getGoodsCommentLists($data){
        $where=array(
            'goods_id'=>$data['goods_id'],
            'goods_type'=>$data['goods_type'],
            'examine'=>1
        );
        $comments=Comment::where($where)->orderBy('id','desc')->get();
        foreach ($comments as $comment){
            //获取评论用户信息
            $comment['user_id']=UserManager::getUserInfoByIdWithToken($comment['user_id']);
            //获取评论的多媒体信息
            $comment['media']=self::getGoodsCommentImages($comment['id']);
            //获取评论的回复信息
            $comment['replies']=self::getGoodsCommentReplies($comment['id']);
            $replies=$comment['replies'];
            foreach ($replies as $replie){
                //获取回复的评论的用户信息
                $replie['user_id']=UserManager::getUserInfoByIdWithToken($replie['user_id']);
            }
            $comment['replies']=$replies;
        }
        return $comments;
    }
    /*
     * 获取评论的多媒体信息
     *
     * by zm
     *
     * 2017-12-22
     *
     */
    public static function getGoodsCommentImages($comment_id){
        $images=CommentImage::where('comment_id',$comment_id)->orderBy('id','asc')->get();
        return $images;
    }
    /*
     * 获取评论的回复信息
     *
     * by zm
     *
     * 2017-12-22
     *
     */
    public static function getGoodsCommentReplies($comment_id){
        $replies=CommentReplie::where('comment_id',$comment_id)->orderBy('id','asc')->get();
        return $replies;
    }
}