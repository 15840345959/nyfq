<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/23
 * Time: 9:08
 */

namespace App\Components;

use App\Http\Controllers\ApiResponse;
use App\Models\CarGoods;
use App\Models\Comment;
use App\Models\CommentConsent;
use App\Models\CommentImage;
use App\Models\CommentReplie;
use App\Models\TourGoods;

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
    public static function getGoodsCommentListsCount($data=null){
        if($data){
            $where=array(
                'goods_id'=>$data['goods_id'],
                'goods_type'=>$data['goods_type'],
                'examine'=>1
            );
            $count=Comment::where($where)->count();
        }
        else{
            $count=Comment::where('examine',1)->count();
        }
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
        $offset=$data["offset"];
        $page=$data["page"];
        if(array_key_exists('goods_id', $data)&&array_key_exists('goods_type', $data)){
            $where=array(
                'goods_id'=>$data['goods_id'],
                'goods_type'=>$data['goods_type'],
                'examine'=>1
            );
            $comments=Comment::where($where)->orderBy('id','desc')
                ->offset($offset)->limit($page)->get();
        }
        else{
            $comments=Comment::where('examine',1)->orderBy('id','desc')
                ->offset($offset)->limit($page)->get();
            foreach ($comments as $comment){
                if($comment['goods_id']&&$comment['goods_type']){
                    $goods_id=$comment['goods_id'];
                    $goods_type=$comment['goods_type'];
                    if($goods_type==1){
                        $comment['goods']=TourGoodsManager::getTourGoodsById($goods_id);
                        $comment['goods']['tour_category_id']=IndexManager::getNewTourCategorie($comment['goods']['tour_category_id']);
                    }
                    else if($goods_type==2){
                        $comment['goods']=HotelGoodsManager::getHotelGoodsById($goods_id);
                    }
                    else if($goods_type==3){
                        $comment['goods']=PlanGoodsManager::getPlanGoodsById($goods_id);
                    }
                    else if($goods_type==4){
                        $comment['goods']=CarGoodsManager::getCarGoodsById($goods_id);
                    }
                    else if($goods_type==5){
                        $comment['goods']=TicketGoodsManager::getTicketGoodsById($goods_id);
                    }
                    else{
                        $comment['goods']=[];
                    }
                }
                else{
                    $comment['goods']=[];
                }
            }
        }
        foreach ($comments as $comment){
            //判断此用户是否点过赞
            $comment['consent_user_id']=self::getGoodsCommentConsentByUser($comment['id'],$data['user_id']);
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
    /*
     * 判断此用户是否点过赞
     *
     * by zm
     *
     * 2017-12-24
     *
     */
    public static function getGoodsCommentConsentByUser($comment_id,$user_id){
        $where=array(
          'comment_id'=>$comment_id,
          'user_id'=>$user_id
        );
        $consent=CommentConsent::where($where)->first();
        $consent=$consent?true:false;
        return $consent;
    }
}