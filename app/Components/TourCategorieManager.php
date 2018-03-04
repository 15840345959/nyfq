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

    /*
     * 查询所有旅游产品分类信息
     *
     * By mtt
     *
     * 2018-3-2
     */
    public static function getTourCategories(){
        $tourCategories = TourCategorie::orderby('sort','desc')->get();
        return $tourCategories;
    }

    /*
     * 设置旅游产品分类信息，用于编辑
     *
     * By mtt
     *
     * 2018-3-2
     */
    public static function setTourCategories($tourCategories,$data){
        if (array_key_exists('name', $data)) {
            $tourCategories->name = array_get($data, 'name');
        }
        if (array_key_exists('sort', $data)) {
            $tourCategories->sort = array_get($data, 'sort');
        }
        if (array_key_exists('image', $data)) {
            $tourCategories->image = array_get($data, 'image');
        }
        if (array_key_exists('type', $data)) {
            $tourCategories->type = array_get($data, 'type');
        }
        return $tourCategories;
    }

    /*
     * 模糊查询产品分类
     *
     * By mtt
     *
     * 2018-3-4
     */
    public static function getAllTourCategoriesLists($search_word){
        $tourCategories = TourCategorie::where('name','like','%'.$search_word.'%')->orderby('sort','desc')->get();
        return $tourCategories;
    }












}













