<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/23
 * Time: 11:06
 */

namespace App\Components;


use App\Models\Customization;
use App\Models\PlanGoods;

class PlanGoodsManager
{
    /*
     * 获取飞机票列表
     *
     * by Acker
     *
     * 2018-02-13
     *
     */
    public static function getPlaneGoodsList($data)
    {
        $airPlane = $data["offset"];  //开始位置
        $page = $data["page"];        //数量
        $plane_goodses = PlanGoods::orderBy('id', 'desc')->offset($airPlane)->limit($page)->get();// 查询全部列表
        return $plane_goodses;
    }

    /*
   * 获取成型套餐列表
   *
   * by Acker
   *
   * 2018-02-25
   *
   */
    public static function getCustomizationList($data)
    {
        $offset = $data["offset"];  //开始位置
        $page = $data["page"];        //数量
        $customization = Customization::orderBy('id', 'desc')->offset($offset)->limit($page)->get();// 查询全部列表
//        dd(json_encode($customization));
        return $customization;
    }

    /*
     * 根据Id获取飞机票产品信息
     *
     * by zm
     *
     * 2017-12-22
     *
     */
    public static function getPlanGoodsById($id)
    {
        //基本信息
        $plan_goods = PlanGoods::where('id', $id)->first();
        return $plan_goods;
    }

    /*
     * 根据条件获取飞机票产品信息
     *
     * by zm
     *
     * 2017-01-08
     *
     */
    public static function getPlanGoodsWhereArray($data)
    {
        //基本信息
        $plan_goods = PlanGoods::where($data)->first();
        return $plan_goods;
    }

    /*
     * 模糊查询分机票产品
     *
     * By mtt
     *
     * 2018-3-19
     */
    public static function getPlaneGoods($search_word){
        $planeGoods = PlanGoods::where('company','like','%'.$search_word.'%')->orderby('id','desc')->get();
        return $planeGoods;
    }

    /*
     * 设置飞机票信息，用于添加、编辑
     *
     * By mtt
     *
     * 2018-3-19
     */
    public static function setPlaneGoods($planeGoods,$data){
        if (array_key_exists('start_place', $data)) {
            $planeGoods->start_place = array_get($data, 'start_place');
        }
        if (array_key_exists('end_place', $data)) {
            $planeGoods->end_place = array_get($data, 'end_place');
        }
        if (array_key_exists('start_time', $data)) {
            $planeGoods->start_time = array_get($data, 'start_time');
        }
        if (array_key_exists('end_time', $data)) {
            $planeGoods->end_time = array_get($data, 'end_time');
        }
        if (array_key_exists('primecast', $data)) {
            $planeGoods->primecast = array_get($data, 'primecast');
        }
        if (array_key_exists('price', $data)) {
            $planeGoods->price = array_get($data, 'price');
        }
        if (array_key_exists('sale', $data)) {
            $planeGoods->sale = array_get($data, 'sale');
        }
        if (array_key_exists('unit', $data)) {
            $planeGoods->unit = array_get($data, 'unit');
        }
        if (array_key_exists('company', $data)) {
            $planeGoods->company = array_get($data, 'company');
        }
        return $planeGoods;
    }

    /*
     * 获取所有的飞机票信息
     *
     * By mtt
     *
     * 2018-3-20
     */
    public static function getPlane(){
        $plane = PlanGoods::orderby('id','asc')->get();
        return $plane;
    }

















}



















