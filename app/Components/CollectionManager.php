<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/8
 * Time: 18:46
 */

namespace App\Components;


use App\Models\Collection;

class CollectionManager
{
    /*
     * 根据用户编号获取收藏夹列表
     *
     * by zm
     *
     * 2018-01-08
     *
     */
    public static function getCollectionListsByUserId($user_id){
        $goodses=Collection::where('user_id',$user_id)->orderBy('id','desc')->get();
        foreach ($goodses as $goods){
            if($goods['goods_type']==1){
                $goods['goods_id']=TourGoodsManager::getTourGoodsById($goods['goods_id']);
            }
            else if($goods['goods_type']==2){
                $goods['goods_id']=HotelGoodsManager::getHotelGoodsById($goods['goods_id']);
            }
            else if($goods['goods_type']==3){
                $goods['goods_id']=PlanGoodsManager::getPlanGoodsById($goods['goods_id']);
            }
            else if($goods['goods_type']==4){
                $goods['goods_id']=CarGoodsManager::getCarGoodsById($goods['goods_id']);
            }
        }
        return $goodses;
    }

    /*
     * 删除收藏夹里的产品
     *
     * by zm
     *
     * 2018-01-08
     *
     */
    public static function deleteCollectionGoods($data){
        foreach ($data['id'] as $id){
            $result=Collection::where('id',$id)->delete();
        }
        return $result?true:false;
    }
}