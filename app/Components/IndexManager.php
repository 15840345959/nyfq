<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/21
 * Time: 14:33
 */

namespace App\Components;

use App\Models\Banner;
use App\Models\BannerDetail;


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

    /*
     * 获取Banners的详情
     *
     * By zm
     *
     * 2017-12-21
     */
    public static function getBannnerById($id)
    {
        $banner = Banner::where('id','=',$id)->first();
        $banner_details=BannerDetail::where('banner_id','=',$id)
            ->orderBy('id','asc')->get();
        $banner["details"]=$banner_details;
        return $banner;
    }
}