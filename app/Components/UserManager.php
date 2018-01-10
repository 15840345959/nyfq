<?php

/**
 * Created by PhpStorm.
 * User: HappyQi
 * Date: 2017/9/28
 * Time: 10:30
 */

namespace App\Components;

use App\Models\User;

class UserManager
{

    /*
     * 根据id获取用户信息，带token
     *
     * By TerryQi
     *
     * 2017-09-28
     */
    public static function getUserInfoByIdWithToken($id)
    {
        $user = User::where('id', '=', $id)->first();
        return $user;
    }

    /*
     * 根据id获取用户信息
     *
     * By TerryQi
     *
     * 2017-09-28
     */
    public static function getUserInfoById($id)
    {
        $user = self::getUserInfoByIdWithToken($id);
        if ($user) {
            $user->token = null;
            $user->remember_token = null;
            $user->password = null;
        }
        return $user;
    }

    /*
     * 根据user_code和token校验合法性，全部插入、更新、删除类操作需要使用中间件
     *
     * By TerryQi
     *
     * 2017-09-14
     *
     * 返回值
     *
     */
    public static function ckeckToken($id, $token)
    {
        //根据id、token获取用户信息
        $count = User::where('id', '=', $id)->where('token', '=', $token)->count();
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * 用户登录
     *
     * By TerryQi
     *
     * 2017-09-28
     */
    public static function login($data)
    {
        //获取account_type，后续进行登录类型判断
        $account_type = $data['account_type'];
        // 判断小程序，按照类型查询
        if ($account_type === 'xcx') {
            $user = self::getUserByXCXOpenId($data['open_id']);
            //存在用户即返回用户信息
            if ($user != null) {
                return $user;
            }
        }
        //不存在即新建用户
        return self::register($data);
    }

    /*
     * 配置用户信息，用于更新用户信息和新建用户信息
     *
     * By TerryQi
     *
     * 2017-09-28
     *
     */
    public static function setUser($user, $data)
    {
        if (array_key_exists('nick_name', $data)) {
            $user->nick_name = array_get($data, 'nick_name');
        }
        if (array_key_exists('password', $data)) {
            $user->password = array_get($data, 'password');
        }
        if (array_key_exists('open_id', $data)) {
            $user->open_id = array_get($data, 'open_id');
        }
        if (array_key_exists('telephone', $data)) {
            $user->telephone = array_get($data, 'telephone');
        }
        if (array_key_exists('id_card', $data)) {
            $user->id_card = array_get($data, 'id_card');
        }
        if (array_key_exists('avatar', $data)) {
            $user->avatar = array_get($data, 'avatar');
        }
        if (array_key_exists('gender', $data)) {
            $user->gender = array_get($data, 'gender');
        }
        if (array_key_exists('organization_id', $data)) {
            $user->organization_id = array_get($data, 'organization_id');
        }
        if (array_key_exists('share_user', $data)) {
            $user->share_user = array_get($data, 'share_user');
        }
        if (array_key_exists('email', $data)) {
            $user->email = array_get($data, 'email');
        }
        if (array_key_exists('passport', $data)) {
            $user->passport = array_get($data, 'passport');
        }
        if (array_key_exists('sign', $data)) {
            $user->sign = array_get($data, 'sign');
        }
        if (array_key_exists('integral', $data)) {
            $user->integral = array_get($data, 'integral');
        }
        if (array_key_exists('background', $data)) {
            $user->background = array_get($data, 'background');
        }
        return $user;
    }

    /*
     * 注册用户
     *
     * By TerryQi
     *
     * 2017-09-28
     *
     */
    public static function register($data)
    {
        //创建用户信息
        $user = new User;
        //account是必填项目
        if (array_key_exists('account_type', $data)) {
            $user->account_type = array_get($data, 'account_type');
        } else {
            return null;
        }
        $user = self::setUser($user, $data);
        $user->token = self::getGUID();
        $user->save();
        $user = self::getUserInfoByIdWithToken($user->id);

        ////判断是否有分享人
        if($user['share_user']){
            IntegralManager::updateShareUserIntegral($user['share_user']);
        }
        ////////////////////

        return $user;
    }

    /*
     * 更新用户信息
     *
     * By TerryQi
     *
     * 2017-09-28
     *
     */
    public static function updateUser($data)
    {
        //配置用户信息
        $user = self::getUserInfoByIdWithToken($data['id']);
        $user = self::setUser($user, $data);
        $user->save();
        return $user;
    }


    /*
     * 根据用户openid获取用户信息
     *
     * By TerryQi
     *
     * 2017-09-28
     */
    public static function getUserByXCXOpenId($openid)
    {
        $user = User::where('open_id', '=', $openid)->first();
        return $user;
    }


    // 生成guid
    /*
     * 生成uuid全部用户相同，uuid即为token
     *
     */
    public static function getGUID()
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((double)microtime() * 10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));

            $uuid = substr($charid, 0, 8)
                . substr($charid, 8, 4)
                . substr($charid, 12, 4)
                . substr($charid, 16, 4)
                . substr($charid, 20, 12);
            return $uuid;
        }
    }
}