<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/19
 * Time: 14:37
 */

namespace App\Components;


use App\Models\Banner;

class BannerManager
{

    /*
     * 模糊查询Banner列表
     *
     * By zm
     *
     * 2018-01-19
     *
     */
    public static function getAllBannerLists($search)
    {
        $banners = Banner::where('title'  , 'like', '%'.$search.'%')->orderBy('id','asc')->get();
        return $banners;
    }
}