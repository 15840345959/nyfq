<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/23
 * Time: 10:59
 */

namespace App\Components;


use App\Models\CarGoods;

class CarGoodsManager
{
    /*
     * 获取车导列表
     *
     * by Acker
     *
     * 2018-02-22
     *
     */
    public static function getCarGoodsList($data){
        $offset=$data["offset"];  //开始位置
        $page=$data["page"];        //数量
        $CarGoodsList=CarGoods::orderBy('id','desc')->offset($offset)->limit($page)->get();// 查询全部列表
        return $CarGoodsList;
    }
    /*
     * 根据Id获取车导产品信息
     *
     * by zm
     *
     * 2017-12-22
     *
     */
    public static function getCarGoodsById($id){
        //基本信息
        $car_goods=CarGoods::where('id',$id)->first();
        return $car_goods;
    }

    /*
     * 根据条件获取车导产品信息
     *
     * by zm
     *
     * 2017-01-08
     *
     */
    public static function getHotelGoodsWhereArray($data){
        //基本信息
        $car_goods=CarGoods::where($data)->first();
        return $car_goods;
    }
}