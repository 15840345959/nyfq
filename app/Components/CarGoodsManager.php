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
}