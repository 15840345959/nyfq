<?php
/**
 * Created by PhpStorm.
 * User: 佟子青本地账户
 * Date: 2018/1/26
 * Time: 17:35
 */

namespace App\Components;

use App\Models\Orders;
use App\Models\TourGoods;
use App\Models\User;
//use Illuminate\Contracts\Logging\Log;

class OrderManager
{
    /*
     * 添加订单
     *
     * by Acker
     *
     * 2018-02-13
     *
     */
    public static function addOrders($data)
    {
        $goods_type = $data['goods_type'];
        if ($goods_type == 0) {
            $Orders = self::addTourOrders($data);
            return $Orders;
        } else if ($goods_type == 1) {
            $Orders = self::addAirplaneOrders($data);
            return $Orders;
        }
//        LOG:info("orders : " . json_encode($Orders));
    }

    /*
     * 添加机票订单
     *
     * by Acker
     *
     * 2018-02-13
     *
     */
    public static function addAirplaneOrders($data)
    {
        $goods_id = $data['goods_id'];
        $plan_goods = PlanGoodsManager::getPlanGoodsById($goods_id);
        $Orders = new Orders();
        $data['status'] = 3;
        $Orders = self::setOrder($Orders, $data);
        $Orders->save();
        $Orders["plan_goods"] = $plan_goods;
        return $Orders;
    }

    /*
     * 添加旅游订单
     *
     * by Acker
     *
     * 2018-02-13
     *
     */
    public static function addTourOrders($data)
    {

        $goods_id = $data['goods_id'];
        $tour_goods = TourGoods::where('id', $goods_id)->first(); //旅游信息
        if ($tour_goods->surplus > 0) {
            $Orders = new Orders();
            $data['status'] = 1;
            $Orders = self::setOrder($Orders, $data);
//            $Orders->status = 1;
            $Orders->save();
            $tour_goods->surplus = $tour_goods->surplus - 1;
            $tour_goods->save();
            $Orders["tour_goods"] = $tour_goods;
            $Orders["surplus"] = true;
        } else {
            $Orders["surplus"] = false;
        }

        return $Orders;
    }

    /*
     * 查询所有订单
     *
     * by Acker
     *
     * 2018-01-31
     *
     */
    public static function getAllOrders($data)
    {
        $orders = Orders::all();
        foreach ($orders as $order) {
            $goods_id = $order->goods_id;
            $user_id = $order->user_id;
            $tour_goods = TourGoods::where('id', $goods_id)->first(); //旅游信息
            $user = User::where('id', $user_id)->first(); //用户信息
            $order['tour_goods'] = $tour_goods;
            $order['user'] = $user;
        }
//        LOG:info("orders111 : " .$orders);
        return $orders;
    }

    /*
     * 根据用户编号获取订单列表
     *
     * by Acker
     *
     * 2018-01-30
     *
     */
    public static function getUserIdListsByUserId($user_id)
    {
        $Orders = Orders::where('user_id', $user_id)->orderBy('id', 'desc')->get();
        foreach ($Orders as $order) {
            if ($order['goods_type'] == 1) {
                $order['goods_id'] = TourGoodsManager::getTourGoodsById($order['goods_id']);
            } else if ($order['goods_type'] == 2) {
                $order['goods_id'] = HotelGoodsManager::getHotelGoodsById($order['goods_id']);
            } else if ($order['goods_type'] == 3) {
                $order['goods_id'] = PlanGoodsManager::getPlanGoodsById($order['goods_id']);
            } else if ($order['goods_type'] == 4) {
                $order['goods_id'] = CarGoodsManager::getCarGoodsById($order['goods_id']);
            }
        }
//        LOG:info("orders " . $Orders);
        return $Orders;
    }

    /*
     * 删除订单里的产品
     *
     * by Acker
     *
     * 2018-01-30
     *
     */
    public static function deleteOrderGoods($data)
    {
        $id = $data['id'];
        $result = Orders::where('id', $id)->delete();
        LOG:
        info("Acker :" . $result);
        return $result ? true : false;
    }

    /*
     * 根据id获取订单信息
     *
     * By Acker
     *
     * 2018-01-27
     */
    public static function getOrderById($id)
    {
        $order = Orders::where('id', $id)->get();
        return $order;
    }

    /*
     * 配置添加订单的参数
     *
     * By Acker
     *
     * 2018-01-27
     *
     */
    public static function setOrder($Orders, $data)
    {
        if (array_key_exists('goods_id', $data)) {
            $Orders->goods_id = array_get($data, 'goods_id');
        }
        if (array_key_exists('goods_type', $data)) {
            $Orders->goods_type = array_get($data, 'goods_type');
        }
        if (array_key_exists('primecost', $data)) {
            $Orders->primecost = array_get($data, 'primecost');
        }
        if (array_key_exists('price', $data)) {
            $Orders->price = array_get($data, 'price');
        }
        if (array_key_exists('count', $data)) {
            $Orders->count = array_get($data, 'count');
        }
        if (array_key_exists('tel', $data)) {
            $Orders->tel = array_get($data, 'tel');
        }
        if (array_key_exists('name', $data)) {
            $Orders->name = array_get($data, 'name');
        }
        if (array_key_exists('status', $data)) {
            $Orders->status = array_get($data, 'status');
        }
        if (array_key_exists('content', $data)) {
            $Orders->content = array_get($data, 'content');
        }
        if (array_key_exists('user_id', $data)) {
            $Orders->user_id = array_get($data, 'user_id');
        }
        if (array_key_exists('start_time', $data)) {
            $Orders->start_time = array_get($data, 'start_time');
        }
//        LOG:info("Orders :" .json_encode($Orders));
        return $Orders;
    }
}