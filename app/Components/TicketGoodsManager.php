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
     * by Acker
     *
     * 2018-03-08
     *
     */
    public static function getTicketGoodsById($id){
        //基本信息
//        dd($id);
        $ticket_goods=TicketGoods::where('id',$id)->first();
//        dd($ticket_goods);
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

    /*
     * 获取抢票信息
     *
     * By mtt
     *
     * 2018-3-12
     */
    public static function getTicketGoodsList($data){
        $offset=$data["offset"];  //开始位置
        $page=$data["page"];        //数量
        $ticketGoodsList = TicketGoods::orderby('id','desc')->offset($offset)->limit($page)->get();//获取抢票信息
        return $ticketGoodsList;
    }

    /*
     * 查询所有抢票信息
     *
     * By mtt
     *
     * 2018-3-20
     */
    public static function getTicketGoods($search_word){
        $ticketGoods = TicketGoods::where('name','like','%'.$search_word.'%')->orderby('id','desc')->get();
        return $ticketGoods;
    }

    /*
     * 设置抢票商品，用于编辑、添加
     *
     * By mtt
     *
     * 2018-3-20
     */
    public static function setTicketGoods($ticketGoods,$data){
        if(array_key_exists('name',$data)){
            $ticketGoods -> name = array_get($data,'name');
        }
        if(array_key_exists('image',$data)){
            $ticketGoods -> image = array_get($data,'image');
        }
        if(array_key_exists('label',$data)){
            $ticketGoods -> label = array_get($data,'label');
        }
        if(array_key_exists('primecast',$data)){
            $ticketGoods -> primecast = array_get($data,'primecast');
        }
        if(array_key_exists('price',$data)){
            $ticketGoods -> price = array_get($data,'price');
        }
        if(array_key_exists('unit',$data)){
            $ticketGoods -> unit = array_get($data,'unit');
        }
        return $ticketGoods;
    }



}















