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
            //判断此用户的点赞状态
            $comment['consent_status']=self::getGoodsCommentConsentByUser($comment['id'],$data['user_id']);
            //获取此条评论的有效点赞数
            $comment['consent_count']=self::countConsents($comment['id']);
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
     * 判断此用户是否为点过赞状态
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
        if($consent){
            if($consent['status']==1){
                return 1;
            }
            else{
                return 0;
            }
        }
        else{
            return 0;
        }
    }
    /*
     * 判断此用户是否有点赞记录
     *
     * by zm
     *
     * 2017-12-24
     *
     */
    public static function getGoodsCommentConsentWithUser($comment_id,$user_id){
        $where=array(
          'comment_id'=>$comment_id,
          'user_id'=>$user_id
        );
        $consent=CommentConsent::where($where)->first();
        return $consent;
    }
    /*
     * 用户对评论进行点赞（用于点赞和取消点赞）
     *
     * by zm
     *
     * 2017-12-24
     *
     */
    public static function addConsentWithUser($data){
        $comment_consent = self::getGoodsCommentConsentWithUser($data['comment_id'],$data['user_id']);
        if(!$comment_consent){
            //创建点赞
            $comment_consent = new CommentConsent();
        }
        else{
            //点赞或取消点赞
            if($comment_consent['status']==0){
                $data['status']=1;
            }
            else{
                $data['status']=0;
            }
        }
        $comment_consent = self::setCommentConsent($comment_consent, $data);
        $comment_consent->save();
        $comment_consent = self::getConsentById($comment_consent->id);

        return $comment_consent;
    }

    /*
     * 配置用户对评论进行点赞信息的参数（用于点赞和取消点赞）
     *
     * By zm
     *
     * 2017-12-24
     *
     */
    public static function setCommentConsent($comment_consent,$data){
        if (array_key_exists('comment_id', $data)) {
            $comment_consent->comment_id = array_get($data, 'comment_id');
        }
        if (array_key_exists('user_id', $data)) {
            $comment_consent->user_id = array_get($data, 'user_id');
        }
        if (array_key_exists('status', $data)) {
            $comment_consent->status = array_get($data, 'status');
        }
        return $comment_consent;
    }

    /*
     * 根据id获取用户的点赞信息
     *
     * By zm
     *
     * 2017-12-24
     */
    public static function getConsentById($id){
        $comment_consent = CommentConsent::where('id', $id)->first();
        return $comment_consent;
    }

    /*
     * 根据comment_id统计有效的点赞记录总数
     *
     * By zm
     *
     * 2017-12-24
     */
    public static function countConsents($comment_id){
        $where=array(
            'comment_id'=>$comment_id,
            'status'=>1
        );
        $count=CommentConsent::where($where)->count();
        return $count;
    }

    /*
     * 添加评论
     *
     * By zm
     *
     * 2017-12-24
     */
    public static function addComment($data){
        $comment=new Comment();
        $comment = self::setComment($comment, $data);
        $comment->save();
        $comment_id=$comment['id'];
        $comment = self::getCommentById($comment_id);
        if (array_key_exists('media', $data)) {
            //添加多媒体
            $comment['media']=self::addCommentMedia($data['media'],$comment_id);
        }
        return $comment;
    }

    /*
     * 配置添加评论的参数
     *
     * By zm
     *
     * 2017-12-24
     *
     */
    public static function setComment($comment,$data){
        if (array_key_exists('goods_id', $data)) {
            $comment->goods_id = array_get($data, 'goods_id');
        }
        if (array_key_exists('goods_type', $data)) {
            $comment->goods_type = array_get($data, 'goods_type');
        }
        if (array_key_exists('content', $data)) {
            $comment->content = array_get($data, 'content');
        }
        if (array_key_exists('user_id', $data)) {
            $comment->user_id = array_get($data, 'user_id');
        }
        if (array_key_exists('user_id', $data)) {
            $comment->user_id = array_get($data, 'user_id');
        }
        return $comment;
    }

    /*
     * 根据id获取评论信息
     *
     * By zm
     *
     * 2017-12-24
     */
    public static function getCommentById($id){
        $comment=Comment::where('id',$id)->get();
        return $comment;
    }

    /*
     * 添加评论图片或视频
     *
     * By zm
     *
     * 2017-12-24
     */
    public static function addCommentMedia($datas,$comment_id){
       foreach ($datas as $data){
           $data['comment_id']=$comment_id;
           $comment_image=new CommentImage();
           $comment_image = self::setCommentImage($comment_image, $data);
           $comment_image->save();
           $comment_image = self::getCommentImageById($comment_id);
           $data=$comment_image;
       }
       return $datas;
    }

    /*
     * 配置添加评论多媒体的参数
     *
     * By zm
     *
     * 2017-12-24
     *
     */
    public static function setCommentImage($comment_image,$data){
        if (array_key_exists('content', $data)) {
            $comment_image->content = array_get($data, 'content');
        }
        if (array_key_exists('type', $data)) {
            $comment_image->type = array_get($data, 'type');
        }
        if (array_key_exists('comment_id', $data)) {
            $comment_image->comment_id = array_get($data, 'comment_id');
        }
        return $comment_image;
    }

    /*
     * 根据id获取评论多媒体信息
     *
     * By zm
     *
     * 2017-12-24
     */
    public static function getCommentImageById($id){
        $comment_image=CommentImage::where('id',$id)->get();
        return $comment_image;
    }
}