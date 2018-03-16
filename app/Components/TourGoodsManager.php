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
        //判断此用户是否对此产品添加过产品收藏
        $collection_data=array(
            'user_id'=>$data['user_id'],
            'goods_id'=>$data['id'],
            'goods_type'=>1
        );
        $tour_goods['collection']=CollectionManager::judgeCollection($collection_data)?true:false;
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
        $where=array(
            'id'=>$data['id'],
            'date'=>$data['date']
        );
        $tour_goods_calendar=TourGoodsCalendar::where($where)->first();
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

    /*
     * 查询所有旅游产品信息
     *
     * By mtt
     *
     * 2018-3-4
     */
    public static function getTourGoodsList($search_word){
        $tourGoods = TourGoods::where('name','like','%'.$search_word.'%')->orderby('id','desc')->get();
        return $tourGoods;
    }

    /*
     * 根据tour_goods_id获取旅游产品日期价格详情信息
     *
     * By mtt
     *
     * 2018-3-4
     */
    public static function getTourGoodsCalendarsByTourGoodsId($tour_goods_id){
        $tourGoodsCalendars = TourGoodsCalendar::where('tour_goods_id',$tour_goods_id)->get();
        return $tourGoodsCalendars;
    }

    /*
     * 根据产品获取旅游产品信息详情
     *
     * By mtt
     *
     * 2018-3-4
     */
    public static function getTourGoodsDetails($tourGoods,$level){
        //查询旅游产品信息
        $tourGoods -> tourGoods = self::getTourGoodsById($tourGoods->tour_goods_id);
        //旅游产品日期价格详情信息
        $tourGoods -> tourGoodsCalendars = self::getTourGoodsCalendarsByTourGoodsId($tourGoods->id);
        //查询旅游产品分类
        $tourGoods -> tourCategories = TourCategorieManager::getTourCategorieById($tourGoods->tour_category_id);
        //图片集信息
        $tourGoods -> tourGoodsImages=self::getTourGoodsImages($tourGoods->id);
        //路线详情
        $tourGoods->tourGoodsRoutes=self::getTourGoodsRoutes($tourGoods->id);
        //内容页详情
        $tourGoods->tourGoodsDetails=self::getTourGoodsContents($tourGoods->id);
        return $tourGoods;
    }

    /*
     * 设置旅游产品，用于添加，编辑
     *
     * By mtt
     *
     * 2018-3-4
     */
    public static function setTourGoods($tourGoods,$data){
        if (array_key_exists('name', $data)) {
            $tourGoods->name = array_get($data, 'name');
        }
        if (array_key_exists('title', $data)) {
            $tourGoods->title = array_get($data, 'title');
        }
        if (array_key_exists('image', $data)) {
            $tourGoods->image = array_get($data, 'image');
        }
        if (array_key_exists('content_image', $data)) {
            $tourGoods->content_image = array_get($data, 'content_image');
        }
        if (array_key_exists('drimecost', $data)) {
            $tourGoods->drimecost = array_get($data, 'drimecost');
        }
        if (array_key_exists('price', $data)) {
            $tourGoods->price = array_get($data, 'price');
        }
        if (array_key_exists('sale', $data)) {
            $tourGoods->sale = array_get($data, 'sale');
        }
        if (array_key_exists('unit', $data)) {
            $tourGoods->unit = array_get($data, 'unit');
        }
        if (array_key_exists('total', $data)) {
            $tourGoods->total = array_get($data, 'total');
        }
        if (array_key_exists('surplus', $data)) {
            $tourGoods->surplus = array_get($data, 'surplus');
        }
        if (array_key_exists('start_place', $data)) {
            $tourGoods->start_place = array_get($data, 'start_place');
        }
        if (array_key_exists('tour_category_id', $data)) {
            $tourGoods->tour_category_id = array_get($data, 'tour_category_id');
        }
        return $tourGoods;
    }

    /*
     * 根据id查询旅游产品信息
     *
     * By mtt
     *
     * 2018-3-5
     */
    public static function getTourGoodsesById($id){
        $tourGoodses = TourGoods::where('id',$id)->get();
        return $tourGoodses;
    }

    /*
     * 查询是所有旅游产品信息
     *
     * By mtt
     *
     * 2018-3-13
     */
    public static function getTourGoods(){
        $tourGoods = TourGoods::orderby('id','asc')->get();
        return $tourGoods;
    }

    /*
     * 根据id获取TourGoodsDetail
     *
     * By mtt
     *
     * 2018-3-6
     */
    public static function getTourGoodsDetailsById($id){
        $tourGoodsDetails = TourGoodsDetail::where('id',$id)->first();
        return $tourGoodsDetails;
    }

    /*
     * 设置旅游产品详情
     *
     * By mtt
     *
     * 2018-3-6
     */
    public static function setTourGoodsDetails($tourGoodsDetails,$data){
        if (array_key_exists('tour_goods_id', $data)) {
            $tourGoodsDetails->tour_goods_id = array_get($data, 'tour_goods_id');
        }
        if (array_key_exists('content', $data)) {
            $tourGoodsDetails->content = array_get($data, 'content');
        }
        if (array_key_exists('type', $data)) {
            $tourGoodsDetails->type = array_get($data, 'type');
        }
        if (array_key_exists('sort', $data)) {
            $tourGoodsDetails->sort = array_get($data, 'sort');
        }
        return $tourGoodsDetails;
    }

    /*
     * 根据id查询旅游产品图片信息
     *
     * By mtt
     *
     * 2018-3-13
     */
    public static function getTourGoodsImageById($id){
        $tourGoodsImage = TourGoodsImage::where('id',$id)->first();
        return $tourGoodsImage;
    }

    /*
     * 设置旅游产品信息，用于编辑
     *
     * By mtt
     *
     * 2018-3-13
     */
    public static function setTourGoodsImage($tourGoodsImage,$data){
        if (array_key_exists('tour_goods_id', $data)) {
            $tourGoodsImage->tour_goods_id = array_get($data, 'tour_goods_id');
        }
        if (array_key_exists('image', $data)) {
            $tourGoodsImage->image = array_get($data, 'image');
        }
        if (array_key_exists('sort', $data)) {
            $tourGoodsImage->sort = array_get($data, 'sort');
        }
        return $tourGoodsImage;
    }

    /*
     * 根据type获取旅游产品信息
     *
     * By mtt
     *
     * 2018-3-16
     */
    public static function getTourGoodsByType($type,$data){
        $offset=$data["offset"];
        $page=$data["page"];
        $tourGoods = TourGoods::where('type',$type)->orderby('sort','desc') ->offset($offset)->limit($page)->get();
        return $tourGoods;
    }


















}















