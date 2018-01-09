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
     * 游客端——获取积分兑换历史
     *
     * by zm
     *
     * 2018-01-09
     *
     */
    public static function getIntegralHistoryForUser($user_id){
        $integral_histories=IntegralHistory::where('user_id',$user_id)->orderBy('id','desc')->get();
        foreach ($integral_histories as $integral_history){
            $integral_history['goods_id']=self::getIntegralGoodsById($integral_history['goods_id']);
        }
        return $integral_histories;
    }

    /*
     * 旅行社端——获取积分兑换历史
     *
     * by zm
     *
     * 2018-01-09
     *
     */
    public static function getIntegralHistoryForOrganization($organization_id){
        $integral_histories=IntegralHistory::where('organization_id',$organization_id)->orderBy('id','desc')->get();
        foreach ($integral_histories as $integral_history){
            $integral_history['user_id']=UserManager::getUserInfoById($integral_history['user_id']);
            $integral_history['goods_id']=self::getIntegralGoodsById($integral_history['goods_id']);
        }
        return $integral_histories;
    }

    /*
     * 根据Id获取积分商城产品信息
     *
     * by zm
     *
     * 2018-01-09
     *
     */
    public static function getIntegralGoodsById($id){
        //基本信息
        $integral_goods=IntegralGoods::where('id',$id)->first();
        return $integral_goods;
    }

    /*
     * 旅行社端——修改兑换状态
     *
     * by zm
     *
     * 2018-01-09
     *
     */
    public static function setIntegralStatusById($id){
        //基本信息
        $integral=IntegralHistory::where('id',$id)->first();
        $data['status']=1;
        $integral = self::setIntegralHistoryStatus($integral, $data);
        $integral->save();
        $integral = IntegralHistory::where('id',$id)->first();
        return $integral;
    }

    /*
     * 根据Id获取积分兑换历史详情
     *
     * by zm
     *
     * 2018-01-09
     *
     */
    public static function getIntegralHistoryById($id){
        //基本信息
        $integral_history=IntegralHistory::where('id',$id)->first();
        return $integral_history;
    }
    
    /*
     * 配置修改兑换积分商品的状态的参数
     *
     * By zm
     *
     * 2018-01-09
     *
     */
    public static function setIntegralHistoryStatus($integral_goods,$data){
        if (array_key_exists('status', $data)) {
            $integral_goods->status = array_get($data, 'status');
        }
        return $integral_goods;
    }
}