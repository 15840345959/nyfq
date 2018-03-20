<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/23
 * Time: 10:59
 */

namespace App\Components;

use App\Models\Customization;

class CustomizationManager
{
    /*
     * 根据Id获取成型套餐
     *
     * by zm
     *
     * 2017-12-22
     *
     */
    public static function getCustomizationByid($id)
    {
        $customization = Customization::where('id', $id)->first();
        if ($customization['airplane_id']) {
            $customization['airplane'] = PlanGoodsManager::getPlanGoodsById($customization['airplane_id']);
        }
        if ($customization['hotel_id']) {
            $customization['hotel'] = HotelGoodsManager::getHotelGoodsById($customization['hotel_id']);
        }
        if ($customization['car_id']) {
            $customization['car'] = CarGoodsManager::getCarGoodsById($customization['car_id']);
        }
//        dd($customization);
        return $customization;
    }

    /*
     * 获取旅游定制套餐信息
     *
     * By mtt
     *
     * 2018-3-20
     */
    public static function getCustomizationList($search_word){
        $customization = Customization::where('name','like','%'.$search_word.'%')->orderby('id','desc')->get();
        return $customization;
    }

    /*
     * 根据level查询旅游定制套餐数据
     *
     * By mtt
     *
     * 2018-3-20
     */
    public static function getCustomizationByLevel($customization,$level){
        //获取飞机票信息
        $customization -> plane = PlanGoodsManager::getPlanGoodsById($customization->airplane_id);
        //获取酒店信息
        $customization -> hotel = HotelGoodsManager::getHotelGoodsById($customization->hotel_id);
        //酒店图片信息
        $customization -> hotelImage = HotelGoodsManager::getHotelGoodsImages($customization->hotel->id);
        //酒店房间信息
        $customization -> hotelRooms = HotelGoodsManager::getHotelRooms($customization->hotel->id);
        //获取车导信息
        $customization -> car = CarGoodsManager::getCarGoodsById($customization->car_id);
        return $customization;
    }

    /*
     * 设置成型套餐，用于编辑、添加
     *
     * By mtt
     *
     * 2018-3-20
     */
    public static function setCustomization($customization,$data){
        if (array_key_exists('name', $data)) {
            $customization->name = array_get($data, 'name');
        }
        if (array_key_exists('desc', $data)) {
            $customization->desc = array_get($data, 'desc');
        }
        if (array_key_exists('airplane_id', $data)) {
            $customization->airplane_id = array_get($data, 'airplane_id');
        }
        if (array_key_exists('hotel_id', $data)) {
            $customization->hotel_id = array_get($data, 'hotel_id');
        }
        if (array_key_exists('car_id', $data)) {
            $customization->car_id = array_get($data, 'car_id');
        }
        return $customization;
    }














}