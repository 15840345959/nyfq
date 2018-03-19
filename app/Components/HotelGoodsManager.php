<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/23
 * Time: 11:07
 */

namespace App\Components;


use App\Models\HotelGoods;
use App\Models\HotelGoodsImage;
use App\Models\HotelGoodsRooms;

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

    /*
     * 获取所有酒店信息
     *
     * By mtt
     *
     * 2018-3-19
     */
    public static function getHotelGoodsLists($search_word){
        $hotelGoodsLists = HotelGoods::where('name','like','%'.$search_word.'%')->orderby('id','desc')->get();
        return $hotelGoodsLists;
    }

    /*
     * 设置旅游定制酒店管理，用于添加和编辑
     *
     * By mtt
     *
     * 2018-3-19
     */
    public static function setHotelGoods($hotelGoods,$data){
        if (array_key_exists('name', $data)) {
            $hotelGoods->name = array_get($data, 'name');
        }
        if (array_key_exists('image', $data)) {
            $hotelGoods->image = array_get($data, 'image');
        }
        if (array_key_exists('primecost', $data)) {
            $hotelGoods->primecost = array_get($data, 'primecost');
        }
        if (array_key_exists('price', $data)) {
            $hotelGoods->price = array_get($data, 'price');
        }
        if (array_key_exists('sale', $data)) {
            $hotelGoods->sale = array_get($data, 'sale');
        }
        if (array_key_exists('unit', $data)) {
            $hotelGoods->unit = array_get($data, 'unit');
        }
        if (array_key_exists('address', $data)) {
            $hotelGoods->address = array_get($data, 'address');
        }
        if (array_key_exists('lon', $data)) {
            $hotelGoods->lon = array_get($data, 'lon');
        }
        if (array_key_exists('lat', $data)) {
            $hotelGoods->lat = array_get($data, 'lat');
        }
        if (array_key_exists('telephone', $data)) {
            $hotelGoods->telephone = array_get($data, 'telephone');
        }
        if (array_key_exists('facilities', $data)) {
            $hotelGoods->facilities = array_get($data, 'facilities');
        }
        if (array_key_exists('content', $data)) {
            $hotelGoods->content = array_get($data, 'content');
        }
        if (array_key_exists('policy', $data)) {
            $hotelGoods->policy = array_get($data, 'policy');
        }
        return $hotelGoods;
    }

    /*
     * 根据id查询旅游定制酒店图片信息
     *
     * By mtt
     *
     * 2018-3-19
     */
    public static function getHotelGoodsImage($id){
        $hotelGoodsImage = HotelGoodsImage::where('id',$id)->orderby('id','asc')->first();
        return $hotelGoodsImage;
    }

    /*
     * 根据hotel_goods_id获取图片信息
     *
     * By mtt
     *
     * 2018-3-19
     */
    public static function getHotelGoodsImages($hotel_goods_id){
        $hotelGoodsImages = HotelGoodsImage::where('hotel_goods_id',$hotel_goods_id)->get();
        return $hotelGoodsImages;
    }

    /*
     * 设置旅游定制酒店图片信息，用于添加、编辑
     *
     * By mtt
     *
     * 2018-3-19
     */
    public static function setHotelGoodsImage($hotelGoodsImage,$data){
        if (array_key_exists('image', $data)) {
            $hotelGoodsImage->image = array_get($data, 'image');
        }
        if (array_key_exists('hotel_goods_id', $data)) {
            $hotelGoodsImage->hotel_goods_id = array_get($data, 'hotel_goods_id');
        }
        if (array_key_exists('sort', $data)) {
            $hotelGoodsImage->sort = array_get($data, 'sort');
        }
        return $hotelGoodsImage;
    }

    /*
     * 根据hotel_goods_id获取酒店房间信息
     *
     * By mtt
     *
     * 2018-3-19
     */
    public static function getHotelRooms($hotel_goods_id){
        $hotelRooms = HotelGoodsRooms::where('hotel_goods_id',$hotel_goods_id)->get();
        return $hotelRooms;
    }

    /*
     * 根据level获取酒店相关信息
     *
     * By mtt
     *
     * 2018-3-19
     */
    public static function getHotelDetailsByLevel($hotelGoods,$level){
        //查询酒店信息根据id
        $hotelGoods -> hotel = self::getHotelGoodsById($hotelGoods->hotel_goods_id);
        //查询酒店图片根据hotel_goods_id
        $hotelGoods -> hotelGoodsImage = self::getHotelGoodsImages($hotelGoods->hotel_goods_id);
        return $hotelGoods;
    }

    /*
     * 获取所有酒店信息
     *
     * By mtt
     *
     * 2018-3-19
     */
    public static function getHotelGoods(){
        $hotelGoods = HotelGoods::orderby('id','desc')->get();
        return $hotelGoods;
    }

    /*
     * 根据id获取酒店房间信息
     *
     * By mtt
     *
     * 2018-3-19
     */
    public static function getHotelRoomsById($id){
        $hotelRooms = HotelGoodsRooms::where('id',$id)->first();
        return $hotelRooms;
    }

    /*
     * 设置酒店房间信息，用于添加、编辑
     *
     * By mtt
     *
     * 2018-3-19
     */
    public static function setHotelRooms($hotelRooms,$data){
        if (array_key_exists('hotel_goods_id', $data)) {
            $hotelRooms->hotel_goods_id = array_get($data, 'hotel_goods_id');
        }
        if (array_key_exists('name', $data)) {
            $hotelRooms->name = array_get($data, 'name');
        }
        if (array_key_exists('image', $data)) {
            $hotelRooms->image = array_get($data, 'image');
        }
        if (array_key_exists('primecost', $data)) {
            $hotelRooms->primecost = array_get($data, 'primecost');
        }
        if (array_key_exists('price', $data)) {
            $hotelRooms->price = array_get($data, 'price');
        }
        if (array_key_exists('sale', $data)) {
            $hotelRooms->sale = array_get($data, 'sale');
        }
        if (array_key_exists('unit', $data)) {
            $hotelRooms->unit = array_get($data, 'unit');
        }
        if (array_key_exists('content', $data)) {
            $hotelRooms->content = array_get($data, 'content');
        }
        if (array_key_exists('label', $data)) {
            $hotelRooms->label = array_get($data, 'label');
        }
        return $hotelRooms;
    }














}












