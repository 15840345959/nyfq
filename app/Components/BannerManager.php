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
        $banners = Banner::where('title'  , 'like', '%'.$search.'%')->orderBy('sort','desc')->get();
        return $banners;
    }


    /*
     * 配置Banner的参数
     *
     * By zm
     *
     * 2018-01-19
     *
     */
    public static function setBanner($banner, $data){
        if (array_key_exists('title', $data)) {
            $banner->title = array_get($data, 'title');
        }
        if (array_key_exists('type', $data)) {
            $banner->type = array_get($data, 'type');
        }
        if (array_key_exists('image', $data)) {
            $banner->image = array_get($data, 'image');
        }
        if (array_key_exists('sort', $data)) {
            $banner->sort = array_get($data, 'sort');
        }
        if (array_key_exists('link', $data)) {
            $banner->link = array_get($data, 'link');
        }
        return $banner;
    }


    /*
     * 通过id获得Banner
     *
     * By zm
     *
     * 2018-01-19
     *
     */
    public static function getBannerById($id){
        $banner=Banner::where('id',$id)->first();
        return $banner;
    }
}