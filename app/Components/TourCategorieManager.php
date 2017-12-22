<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/22
 * Time: 16:53
 */

namespace App\Components;

use App\Models\TourCategorie;

class TourCategorieManager
{
    /*
     * 获取旅游产品的目的地
     *
     * by zm
     *
     * 2017-12-22
     *
     */
    public static function getCategorieLists($type){
        $categories = TourCategorie::where('type',$type)
            ->orderBy('sort','desc')->get();
        return $categories;
    }

}