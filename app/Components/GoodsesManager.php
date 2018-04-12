<?php
/**
 * Created by PhpStorm.
 * User: mtt17
 * Date: 2018/4/12
 * Time: 17:45
 */

namespace App\Components;


use App\Models\Goods;

class GoodsesManager
{
    /*
     * 根据id获取信息
     *
     * By mttt
     *
     * 2018-4-12
     */
    public static function getByGoodsId($goods_id){
        $goods = Goods::where('goods_id',$goods_id)->first();
        return $goods;
    }

}