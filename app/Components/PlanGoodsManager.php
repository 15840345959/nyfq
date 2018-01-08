<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/23
 * Time: 11:06
 */

namespace App\Components;


use App\Models\PlanGoods;

class PlanGoodsManager
{
    /*
     * 根据Id获取飞机票产品信息
     *
     * by zm
     *
     * 2017-12-22
     *
     */
    public static function getPlanGoodsById($id){
        //基本信息
        $plan_goods=PlanGoods::where('id',$id)->first();
        return $plan_goods;
    }

    /*
     * 根据条件获取飞机票产品信息
     *
     * by zm
     *
     * 2017-01-08
     *
     */
    public static function getPlanGoodsWhereArray($data){
        //基本信息
        $plan_goods=PlanGoods::where($data)->first();
        return $plan_goods;
    }
}