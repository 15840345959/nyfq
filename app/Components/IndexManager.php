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
use App\Models\Goods;
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
        $banner = Banner::where('id',$id)->first();
        $banner_details=BannerDetail::where('banner_id',$id)
            ->orderBy('sort','asc')->get();
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
        $tour_goodses=TourGoods::orderBy('sort','desc')
            ->offset($offset)->limit($page)->get();
        foreach ($tour_goodses as $tour_goods){
            $tour_goods['categorie']=self::getNewTourCategorie($tour_goods['tour_category_id']);
        }
        return $tour_goodses;
    }

    /*
     * 获取首页动态目录
     *
     * By zm
     *
     * 2017-12-21
     */
    public static function getIndexMenuLists($type){
        $where=array(
            'type'=>$type
        );
        $menus=TourCategorie::where($where)
            ->orderBy('sort','asc')->get();
        return $menus;
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
        $tour_categorie=TourCategorie::where('id',$id)->first();
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

    /*
     * 获取首页特价产品
     *
     * By zm
     *
     * 2018-01-08
     */
    public static function getIndexSpecialGoodes($data)
    {
        $offset=$data["offset"];
        $page=$data["page"];
        $goodses=Goods::orderBy('id','desc')->get();
        $goods_lists=array();
        foreach ($goodses as $key=>$goods){
            if($goods['goods_type']==1){
                $where=array(
                    "id"=>$goods['goods_id'],
                    "sale"=>1
                );
                if(TourGoodsManager::getTourGoodsWhereArray($where)){
                    $goods['goods_id']=TourGoodsManager::getTourGoodsWhereArray($where);
                    array_push($goods_lists,$goods);
                }
            }
            else if($goods['goods_type']==2){
                $where=array(
                    "id"=>$goods['goods_id'],
                    "sale"=>1
                );
                if(HotelGoodsManager::getHotelGoodsWhereArray($where)){
                    $goods['goods_id']=HotelGoodsManager::getHotelGoodsWhereArray($where);
                    array_push($goods_lists,$goods);
                }
            }
            else if($goods['goods_type']==3){
                $where=array(
                    "id"=>$goods['goods_id'],
                    "sale"=>1
                );
                if(PlanGoodsManager::getPlanGoodsWhereArray($where)){
                    $goods['goods_id']=PlanGoodsManager::getPlanGoodsWhereArray($where);
                    array_push($goods_lists,$goods);
                }
            }
            else if($goods['goods_type']==4){
                $where=array(
                    "id"=>$goods['goods_id'],
                    "sale"=>1
                );
                if(CarGoodsManager::getHotelGoodsWhereArray($where)){
                    $goods['goods_id']=CarGoodsManager::getHotelGoodsWhereArray($where);
                    array_push($goods_lists,$goods);
                }
            }
        }
        //如果数据库中的数据总数大于$page,在正常遍历完数据后实现循环输出
        $goods_lists_count=count($goods_lists);
        $goods_rows = array_slice($goods_lists, $offset, $page);
        $goods_rows_count=count($goods_rows);
        if($goods_rows_count<$page&&$goods_rows_count<$goods_lists_count){
            $goods_rows=self::loopData($goods_lists, $goods_rows, $offset, $page);
        }
        return $goods_rows;
    }

    /*
     * 循环数据
     *
     * By zm
     *
     * @param $lists 库表中的数据
     * @param $rows 应输出的数据
     * @param $offset 开始的位置
     * @param $page 输出的条数
     *
     * 2018-01-08
     */
    public static function loopData($lists,$rows,$offset,$page){
        if($offset<count($lists)){
            $sub_lists=array_slice($lists, 0, $page-count($rows));
            foreach ($sub_lists as $sub_list){
                array_push($rows,$sub_list);
            }
        }
        else{
//            $offset=$page-$offset%count($lists)+1;
            $base_count=($page-count($lists)%$page)+count($lists);  //得到第一个完全通过循环得到数据的起始位置
            if($offset==$base_count){
                $offset=$page-count($lists)%$page;
            }
            else{
                $base_offset=$page-count($lists)%$page;
                $base=($offset-$base_count)/$page;
                $offset=($base_offset+$page*$base)>$page?$base_offset+$page*$base-count($lists)*$base:$base_offset+$page*$base;
            }

            $sub_lists=array_slice($lists, $offset, $page-count($rows));
            foreach ($sub_lists as $sub_list){
                array_push($rows,$sub_list);
            }
            if(count($rows)<$page){
                $sub_lists=array_slice($lists, 0, $page-count($rows));
                foreach ($sub_lists as $sub_list){
                    array_push($rows,$sub_list);
                }
            }
        }
        return $rows;
    }

    /*
     * 搜索
     *
     * By zm
     *
     * 2018-01-12
     */
    public static function searchGoods($data){
        $offset=$data["offset"];
        $page=$data["page"];
        $search_name=$data['search_name'];
        $goodses=Goods::orderBy('id','desc')->get();
        $goods_lists=array();
        foreach ($goodses as $key=>$goods){
            if($goods['goods_type']==1){
                $where=array(
                    "id"=>$goods['goods_id']
                );
                if(TourGoodsManager::getTourGoodsWhereArray($where)){
                    $goods['goods_id']=TourGoodsManager::getTourGoodsWhereArray($where);
                    if(empty($search_name)){
                        array_push($goods_lists,$goods);
                    }
                    else if(stripos($goods['goods_id']['name'],$search_name)!==false){
                        array_push($goods_lists,$goods);
                    }
                }
            }
            else if($goods['goods_type']==2){
                $where=array(
                    "id"=>$goods['goods_id']
                );
                if(HotelGoodsManager::getHotelGoodsWhereArray($where)){
                    $goods['goods_id']=HotelGoodsManager::getHotelGoodsWhereArray($where);
                    if(empty($search_name)){
                        array_push($goods_lists,$goods);
                    }
                    else if(stripos($goods['goods_id']['name'],$search_name)!==false){
                        array_push($goods_lists,$goods);
                    }
                }
            }
            else if($goods['goods_type']==3){
                $where=array(
                    "id"=>$goods['goods_id']
                );
                if(PlanGoodsManager::getPlanGoodsWhereArray($where)){
                    $goods['goods_id']=PlanGoodsManager::getPlanGoodsWhereArray($where);
                    if(empty($search_name)){
                        array_push($goods_lists,$goods);
                    }
                    else if(stripos($goods['goods_id']['name'],$search_name)!==false){
                        array_push($goods_lists,$goods);
                    }
                }
            }
            else if($goods['goods_type']==4){
                $where=array(
                    "id"=>$goods['goods_id']
                );
                if(CarGoodsManager::getHotelGoodsWhereArray($where)){
                    $goods['goods_id']=CarGoodsManager::getHotelGoodsWhereArray($where);
                    if(empty($search_name)){
                        array_push($goods_lists,$goods);
                    }
                    else if(stripos($goods['goods_id']['name'],$search_name)!==false){
                        array_push($goods_lists,$goods);
                    }
                }
            }
        }
        $goods_rows = array_slice($goods_lists, $offset, $page);
        return $goods_rows;
    }

}