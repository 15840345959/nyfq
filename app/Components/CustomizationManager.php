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

}