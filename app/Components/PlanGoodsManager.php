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
     * 获取飞机票列表
     *
     * by Acker
     *
     * 2018-02-13
     *
     */
    public static function getPlaneGoodsList($data)
    {
        $airPlane = $data["offset"];  //开始位置
        $page = $data["page"];        //数量
        $plane_goodses = PlanGoods::orderBy('id', 'desc')->offset($airPlane)->limit($page)->get();// 查询全部列表
        return $plane_goodses;
    }

    /*
     * 根据Id获取飞机票产品信息
     *
     * by zm
     *
     * 2017-12-22
     *
     */
    public static function getPlanGoodsById($id)
    {
        //基本信息
        $plan_goods = PlanGoods::where('id', $id)->first();
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
    public static function getPlanGoodsWhereArray($data)
    {
        //基本信息
        $plan_goods = PlanGoods::where($data)->first();
        return $plan_goods;
    }
}