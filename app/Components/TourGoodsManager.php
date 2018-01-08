<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/21
 * Time: 15:39
 */

namespace App\Components;


use App\Models\TourGoods;
use App\Models\TourGoodsCalendar;
use App\Models\TourGoodsDetail;
use App\Models\TourGoodsImage;
use App\Models\TourGoodsRoute;

class TourGoodsManager
{
    /*
     * 获取旅游产品的详细信息
     *
     * by zm
     *
     * 2017-12-22
     *
     */
    public static function getTourGoodsDetail($data){
        $id=$data['id'];
        //基本信息
        $tour_goods=TourGoods::where('id',$id)->first();
        //目的地信息
        $tour_goods["tour_category_id"]=TourCategorieManager::getTourCategorieById($id);
        //图片集信息
        $tour_goods['image_lists']=self::getTourGoodsImages($id);
        //通过日期时间获取当前的价格等信息
        $tour_goods['calendar']=self::getTourGoodsCalendar($data);
        //路线详情
        $tour_goods['routes']=self::getTourGoodsRoutes($id);
        //内容页详情
        $tour_goods['contents']=self::getTourGoodsContents($id);
        return $tour_goods;
    }

    /*
     * 获取旅游产品的图片集
     *
     * by zm
     *
     * 2017-12-22
     *
     */
    public static function getTourGoodsImages($tour_goods_id){
        $tour_goods_images=TourGoodsImage::where('tour_goods_id',$tour_goods_id)
            ->orderBy('sort','desc')->get();
        return $tour_goods_images;
    }

    /*
     * 获取旅游产品的路线详情
     *
     * by zm
     *
     * 2017-12-22
     *
     */
    public static function getTourGoodsRoutes($tour_goods_id){
        $tour_goods_routes=TourGoodsRoute::where('tour_goods_id',$tour_goods_id)
            ->orderBy('id','asc')->get();
        return $tour_goods_routes;
    }

    /*
     * 通过日期时间获取当前的价格等信息
     *
     * by zm
     *
     * 2017-12-22
     *
     */
    public static function getTourGoodsCalendar($data){
        $tour_goods_calendar=TourGoodsCalendar::where($data)->first();
        return $tour_goods_calendar;
    }

    /*
     * 获取旅游产品的内容页详情
     *
     * by zm
     *
     * 2017-12-22
     *
     */
    public static function getTourGoodsContents($id){
        $tour_goods_contents=TourGoodsDetail::where('tour_goods_id',$id)
            ->orderBy('id','asc')->get();
        return $tour_goods_contents;
    }


    /*
     * 根据Id获取旅游产品信息
     *
     * by zm
     *
     * 2017-12-22
     *
     */
    public static function getTourGoodsById($id){
        //基本信息
        $tour_goods=TourGoods::where('id',$id)->first();
        return $tour_goods;
    }


    /*
     * 根据条件旅游产品信息
     *
     * by zm
     *
     * 2017-01-08
     *
     */
    public static function getTourGoodsWhereArray($data){
        //基本信息
        $tour_goods=TourGoods::where($data)->first();
        return $tour_goods;
    }
}