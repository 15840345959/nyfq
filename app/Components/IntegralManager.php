<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/9
 * Time: 11:05
 */

namespace App\Components;


use App\Models\IntegralGoods;
use App\Models\IntegralHistory;
use App\Models\IntegralRecord;

class IntegralManager
{
    /*
     * 获取积分商城的可兑换产品
     *
     * by zm
     *
     * 2018-01-09
     *
     */
    public static function IntegralGoodsLists(){
        $where=array(
            'status'=>1,
            'delete'=>0
        );
        $integral_goods=IntegralGoods::where($where)->get();
        return $integral_goods;
    }

    /*
     * 获取用户积分明细列表
     *
     * by zm
     *
     * 2018-01-09
     *
     */
    public static function getIntegralDetaileListsByUser($user_id){
        $integral_details=IntegralRecord::where('user_id',$user_id)->orderBy('id','desc')->get();
        return $integral_details;
    }

    /*
     * 客户端——获取积分兑换历史
     *
     * by zm
     *
     * 2018-01-09
     *
     */
    public static function getIntegralHistoryForUser($user_id){
        $integral_histories=IntegralHistory::where('user_id',$user_id)->orderBy('id','desc')->get();
        foreach ($integral_histories as $integral_historie){
            $integral_historie['goods_id']=self::getIntegralGoodsById($integral_historie['goods_id']);
        }
        return $integral_histories;
    }

    /*
     * 根据Id获取积分商城产品信息
     *
     * by zm
     *
     * 2017-12-22
     *
     */
    public static function getIntegralGoodsById($id){
        //基本信息
        $integral_goods=IntegralGoods::where('id',$id)->first();
        return $integral_goods;
    }
}