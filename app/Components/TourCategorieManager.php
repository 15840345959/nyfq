<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/22
 * Time: 16:53
 */

namespace App\Components;

use App\Models\TourCategorie;
use App\Models\TourGoods;

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

    /*
     * 按id获取旅游产品的目的地信息
     *
     * By zm
     *
     * 2017-12-21
     */
    public static function getTourCategorieById($id)
    {
        $tour_categorie=TourCategorie::where('id',$id)->first();
        return $tour_categorie;
    }

    /*
     * 获取旅游产品列表
     *
     * by zm
     *
     * by Acker alter 02-13
     *
     * 2017-12-22
     *
     */
    public static function getTourGoodsLists($data){
        $offset=$data["offset"];
        $page=$data["page"];
        if($data['tour_category_id']){   //如果有类别id
            $tour_category_id=$data["tour_category_id"];
            $tour_goodses=TourGoods::where('tour_category_id',$tour_category_id)->orderBy('sort','desc')
                ->offset($offset)->limit($page)->get();   //查询该类别下列表
        }
        else{
            $tour_goodses=TourGoods::orderBy('sort','desc')->offset($offset)->limit($page)->get();  //查询全部
        }
        foreach ($tour_goodses as $tour_goods){
            $tour_goods['categorie']=self::getTourCategorieById($tour_goods['tour_category_id']);
        }
        return $tour_goodses;
    }
}