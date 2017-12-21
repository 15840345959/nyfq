<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/21
 * Time: 14:33
 */

namespace App\Components;

use App\Models\Banner;


class IndexManager
{

    /*
     * 获取Banners
     *
     * By zm
     *
     * 2017-12-21
     */
    public static function getBannnerLists()
    {
        $banners = Banner::orderBy('sort','desc')->get();
        return $banners;
    }
}