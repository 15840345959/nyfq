<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/23
 * Time: 11:07
 */

namespace App\Components;


use App\Models\HotelGoods;

class HotelGoodsManager
{
    /*
     * 获取酒店列表
     *
     * by Acker
     *
     * 2018-02-22
     *
     */
    public static function getHotelGoodsList($data)
    {
        $offset = $data["offset"];  //开始位置
        $page = $data["page"];        //数量
        $hotelGoodsList = HotelGoods::orderBy('id', 'desc')->offset($offset)->limit($page)->get();// 查询全部列表
        return $hotelGoodsList;
    }

    /*
     * 根据Id获取酒店产品信息
     *
     * by zm
     *
     * 2017-12-22
     *
     */
    public static function getHotelGoodsById($id)
    {
        //基本信息
        $hotel_goods = HotelGoods::where('id', $id)->first();
        return $hotel_goods;
    }

    /*
     * 根据条件获取酒店产品信息
     *
     * by zm
     *
     * 2017-01-08
     *
     */
    public static function getHotelGoodsWhereArray($data)
    {
        //基本信息
        $hotel_goods = HotelGoods::where($data)->first();
        return $hotel_goods;
    }
}