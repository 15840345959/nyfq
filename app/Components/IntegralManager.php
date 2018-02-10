<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/9
 * Time: 11:05
 */

namespace App\Components;


use App\Models\IntegralGoods;
use App\Models\IntegralHistory;
use App\Models\IntegralRecord;
use Illuminate\Support\Facades\Log;

class IntegralManager
{
    const SIGN_INTEGRAL = 10;    //签到所获得的积分
    const INVITATION_INTEGRAL = 20;    //友情好友所获得的积分
    const COMMENT_INTEGRAL = 50;    //发表评论审核通过后所获得的积分

    /*
     * 获取积分商城的可兑换产品
     *
     * by zm
     *
     * 2018-01-09
     *
     */
    public static function IntegralGoodsLists()
    {
        $where = array(
            'status' => 1
        );
        $integral_goods = IntegralGoods::where($where)->get();
        return $integral_goods;
    }

    /*
     * 获取用户积分明细列表
     *
     * by zm
     *
     * 2018-01-09
     *
     */
    public static function getIntegralDetaileListsByUser($user_id)
    {
        $integral_details = IntegralRecord::where('user_id', $user_id)->orderBy('id', 'desc')->get();
        return $integral_details;
    }

    /*
     * 游客端——获取积分兑换历史
     *
     * by zm
     *
     * 2018-01-09
     *
     */
    public static function getIntegralHistoryForUser($user_id)
    {
        $integral_histories = IntegralHistory::where('user_id', $user_id)->orderBy('id', 'desc')->get();
        return $integral_histories;
    }

    /*
     * 旅行社端——获取积分兑换历史
     *
     * by zm
     *
     * 2018-01-09
     *
     */
    public static function getIntegralHistoryForOrganization($organization_id)
    {
        $integral_histories = IntegralHistory::where('organization_id', $organization_id)->orderBy('id', 'desc')->get();
        return $integral_histories;
    }

    /*
     * 根据Id获取积分商城产品信息
     *
     * by zm
     *
     * 2018-01-09
     *
     */
    public static function getIntegralGoodsById($id)
    {
        //基本信息
        $integral_goods = IntegralGoods::where('id', $id)->first();
        return $integral_goods;
    }

    /*
     * 旅行社端——修改兑换状态
     *
     * by zm
     *
     * 2018-01-09
     *
     */
    public static function setIntegralStatusById($data)
    {
        $integral = self::getIntegralHistoryById($data['id']);
        $data['status'] = 1;
        $integral = self::setIntegralHistoryStatus($integral, $data);
        $integral->save();
        $integral = self::getIntegralHistoryById($integral->id);
        return $integral;
    }

    /*
     * 游客端——添加积分兑换历史
     *
     * by Acker
     *
     * 2018-02-08
     *
     */
    public static function addIntegral($data)
    {
        $integral = new IntegralHistory();  //创建积分记录
        $user = UserManager::getUserInfoById($data['user_id']); //获取用户
        $data['organization_id'] = $user['organization_id'];  //用户旅行社编号
        $integral_goods = IntegralManager::getIntegralGoodsById($data['goods_id']); //兑换积分商品
        $data['goods_name'] = $integral_goods['name'];    //商品名字
        $data['goods_price'] = $integral_goods['price'];  //商品价格
        $data['goods_image'] = $integral_goods['image'];  //商品图片
        $integral = self::setIntegralHistoryStatus($integral, $data);  //设置兑换历史
        $integral->save();  //保存兑换历史
        $integral = self::getIntegralHistoryById($integral->id);  //取出兑换历史
        $datas['integral'] = $integral;   //兑换历史存入datas
        if ($integral) {   //如有有兑换历史
            $goods = self::getIntegralGoodsById($data['goods_id']);  //兑换积分商品
            $user->integral = $user->integral - $goods->price;  //用户积分减去兑换商品积分
            $user->save();  //保存
            $datas['user'] = $user; //用户记录存入datas
            $param['type'] = 0;    //添加积分类型
            $param['content'] = '兑换' . $goods['name'] . ' -' . $goods['price'];  //前端提示语
            $param['user_id'] = $data['user_id'];  //用户id
            $integral_record = self::addIntegralRecord($param);  //添加积分记录
            if ($integral_record) {  //如有有积分记录
                $datas['integral_record'] = $integral_record;  // 用户记录存入datas
            }
        }
        return $datas;
    }

    /*
     * 根据Id获取积分兑换历史详情
     *
     * by zm
     *
     * 2018-01-09
     *
     */
    public static function getIntegralHistoryById($id)
    {
        //基本信息
        $integral_history = IntegralHistory::where('id', $id)->first();
        return $integral_history;
    }

    /*
     * 配置添加/修改兑换积分商品历史的状态的参数
     *
     * By zm
     *
     * 2018-01-09
     *
     */
    public static function setIntegralHistoryStatus($integral_goods, $data)
    {
        if (array_key_exists('goods_id', $data)) {
            $integral_goods->goods_id = array_get($data, 'goods_id');
        }
        if (array_key_exists('user_id', $data)) {
            $integral_goods->user_id = array_get($data, 'user_id');
        }
        if (array_key_exists('status', $data)) {
            $integral_goods->status = array_get($data, 'status');
        }
        if (array_key_exists('organization_id', $data)) {
            $integral_goods->organization_id = array_get($data, 'organization_id');
        }
        if (array_key_exists('goods_name', $data)) {
            $integral_goods->goods_name = array_get($data, 'goods_name');
        }
        if (array_key_exists('goods_price', $data)) {
            $integral_goods->goods_price = array_get($data, 'goods_price');
        }
        if (array_key_exists('goods_image', $data)) {
            $integral_goods->goods_image = array_get($data, 'goods_image');
        }
        return $integral_goods;
    }

    /*
     * 按用户编号添加积分记录
     */
    public static function addIntegralRecord($data)
    {
        if ($data['type'] == 1) {
            $content = '签到 +' . self::SIGN_INTEGRAL;
        } else if ($data['type'] == 2) {
            $content = '邀请好友成功 +' . self::INVITATION_INTEGRAL;
        } else if ($data['type'] == 3) {
            $content = '发表评论并审核通过 +' . self::COMMENT_INTEGRAL;
        } else {
            $content = $data['content'];
        }
        $data['content'] = $content;   //提示语
        $integral_record = new IntegralRecord();
        $integral_record = self::setIntegralRecord($integral_record, $data);
        $integral_record->save();
        $integral_record = self::getIntegralRecordById($integral_record->id);
        return $integral_record;
    }


    /*
     * 根据Id获取积分记录详情
     *
     * by zm
     *
     * 2018-01-09
     *
     */
    public static function getIntegralRecordById($id)
    {
        //基本信息
        $integral_record = IntegralRecord::where('id', $id)->first();
        return $integral_record;
    }

    /*
     * 配置添加积分记录的参数
     *
     * By zm
     *
     * 2018-01-09
     *
     */
    public static function setIntegralRecord($integral_record, $data)
    {
        if (array_key_exists('user_id', $data)) {
            $integral_record->user_id = array_get($data, 'user_id');
        }
        if (array_key_exists('content', $data)) {
            $integral_record->content = array_get($data, 'content');
        }
        if (array_key_exists('type', $data)) {
            $integral_record->type = array_get($data, 'type');
        }
        return $integral_record;
    }

    /*
     * 签到
     *
     * By zm
     *
     * 2018-01-10
     *
     */
    public static function updateUserSign($data)
    {
        /////获取最后一次的签到信息
        $sign_time = self::getLastSign($data['user_id']);
        $sign_created_time = date('Y-m-d', strtotime($sign_time['created_at']));
        $nowtime = date("Y-m-d", time());
//        Log::info('sign_created_time is ' . json_encode($sign_created_time));
        $sign_status = $sign_created_time == $nowtime;
        $user = UserManager::getUserInfoById($data['user_id']);
        if (!$sign_status) {
            $data['sign'] = $user['sign'] + 1;
            $data['integral'] = $user['integral'] + self::SIGN_INTEGRAL;
            $user = UserManager::setUser($user, $data);
            $user->save();
            $datas['user'] = $user;

            $param['type'] = 1;
            $param['user_id'] = $data['user_id'];
            $integral_record = self::addIntegralRecord($param);
            if ($integral_record) {
                $datas['integral_record'] = $integral_record;
            }
        }
        $sign = array(
            'sign' => $user['sign'],
            'status' => $sign_status
        );
        $user['sign'] = $sign;
        ////////////////
        return $user;
    }
    /*
     * 添加邀请
     *
     * By Acker
     *
     * 2018-02-08
     */
    public static function addInvitation($data)
    {
        $user = UserManager::getUserInfoById($data['user_id']);
        $share_user = UserManager::getUserInfoById($data['share_user']);
//        LOG:info("user  :" . json_encode(isset($user->share_user)));
        if ($user['share_user'] === 0) {
            $share_user_data['integral'] = $share_user['integral'] + self::INVITATION_INTEGRAL; //分享者加20积分
            $user = UserManager::setUser($user,$data);  //用户表存入分享人
            $share_user = UserManager::setUser($share_user,$share_user_data);  // 分享人积分增加
            $user->save();
            $share_user->save();
            $datas['user'] = $user; //用户记录存入datas
            $datas['$share_user'] = $share_user; //分享人信息存入datas
            $param['type'] = 2;    //添加积分类型
            $param['content'] = '邀请'.$user['nick_name'].'成功。';  //积分记录
            $param['user_id'] = $share_user['id'];  //分享人id
            $integral_record = self::addIntegralRecord($param);  //添加积分记录
            if ($integral_record) {  //如有有积分记录
                $datas['integral_record'] = $integral_record;  // 用户记录存入datas
            }
            return $datas;
        }
        return $user;
    }

    /*
     * 邀请好友成功后获得积分
     *
     * By zm
     *
     * 2018-01-10
     *
     */
    public static function updateShareUserIntegral($user_id)
    {
        $user = UserManager::getUserInfoByIdWithToken($user_id);
        $data['integral'] = $user['integral'] + self::INVITATION_INTEGRAL;
        $user = UserManager::setUser($user, $data);
        $user->save();
        $datas['user'] = $user;

        $param['type'] = 2;
        $param['user_id'] = $user_id;
        $integral_record = self::addIntegralRecord($param);
        if ($integral_record) {
            $datas['integral_record'] = $integral_record;
        }
        return $datas;
    }

    /*
     * 邀请好友成功后获得积分
     *
     * By zm
     *
     * 2018-01-10
     *
     */
    public static function getLastSign($user_id)
    {
        $where = array(
            'user_id' => $user_id,
            'type' => 1
        );
        $sign = IntegralRecord::where($where)->orderBy('id', 'desc')->first();
        return $sign;
    }
}