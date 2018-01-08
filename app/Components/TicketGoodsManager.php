<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/23
 * Time: 11:15
 */

namespace App\Components;


use App\Models\TicketGoods;

class TicketGoodsManager
{
    /*
     * 根据Id获取抢票产品信息
     *
     * by zm
     *
     * 2017-12-22
     *
     */
    public static function getTicketGoodsById($id){
        //基本信息
        $ticket_goods=TicketGoods::where('id',$id)->first();
        return $ticket_goods;
    }

    /*
     * 根据条件获取抢票产品信息
     *
     * by zm
     *
     * 2017-01-08
     *
     */
    public static function getTicketGoodsWhereArray($data){
        //基本信息
        $ticket_goods=TicketGoods::where($data)->first();
        return $ticket_goods;
    }
}