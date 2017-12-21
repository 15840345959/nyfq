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
use App\Models\TourCategorie;
use App\Models\TourGoods;


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

    /*
     * 获取首页最新旅游产品
     *
     * By zm
     *
     * 2017-12-21
     */
    public static function getNewTourGoodes($data)
    {
        $offset=$data["offset"];
        $page=$data["page"];
        $tour_goodses=TourGoods::orderBy('id','desc')
            ->offset($offset)->limit($page)->get();
        foreach ($tour_goodses as $tour_goods){
            $tour_goods['categorie']=self::getNewTourCategorie($tour_goods['tour_category_id']);
        }
        return $tour_goodses;
    }

    /*
     * 获取旅游产品的目的地信息
     *
     * By zm
     *
     * 2017-12-21
     */
    public static function getNewTourCategorie($id)
    {
        $tour_categorie=TourCategorie::where('id','=',$id)->first();
        if($tour_categorie){
            $type=$tour_categorie['type'];
            if($type==0){
                $tour_categorie['type']="跟团游";
            }
            else if($type==1){
                $tour_categorie['type']="小包团";
            }
            else if($type==2){
                $tour_categorie['type']="自定义套餐";
            }
        }
        return $tour_categorie;
    }

}