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

    /*
     * 查询车导信息
     *
     * By mtt
     *
     * 2018-3-20
     */
    public static function getCarGoods($search_word){
        $carGoods = CarGoods::where('name','like','%'.$search_word.'%')->orderby('id','desc')->get();
        return $carGoods;
    }

    /*
     * 设置车导信息，用于添加、编辑
     *
     * By mtt
     *
     * 2018-3-20
     */
    public static function setCarGoods($carGoods,$data){
        if (array_key_exists('name', $data)) {
            $carGoods->name = array_get($data, 'name');
        }
        if (array_key_exists('image', $data)) {
            $carGoods->image = array_get($data, 'image');
        }
        if (array_key_exists('address', $data)) {
            $carGoods->address = array_get($data, 'address');
        }
        if (array_key_exists('seat', $data)) {
            $carGoods->seat = array_get($data, 'seat');
        }
        if (array_key_exists('primecast', $data)) {
            $carGoods->primecast = array_get($data, 'primecast');
        }
        if (array_key_exists('price', $data)) {
            $carGoods->price = array_get($data, 'price');
        }
        if (array_key_exists('sale', $data)) {
            $carGoods->sale = array_get($data, 'sale');
        }
        if (array_key_exists('unit', $data)) {
            $carGoods->unit = array_get($data, 'unit');
        }
        return $carGoods;
    }











}











