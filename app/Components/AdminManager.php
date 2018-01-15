<?php

/**
 * Created by PhpStorm.
 * User: HappyQi
 * Date: 2017/9/28
 * Time: 10:30
 */

namespace App\Components;

use App\Models\AD;
use App\User;
use Qiniu\Auth;

class AdminManager
{

    /*
     * 设置管理员信息，用于编辑
     *
     * By TerryQi
     *
     */
    public static function setAdmin($admin, $data)
    {
        if (array_key_exists('nick_name', $data)) {
            $admin->nick_name = array_get($data, 'nick_name');
        }
        if (array_key_exists('avatar', $data)) {
            $admin->avatar = array_get($data, 'avatar');
        }
        if (array_key_exists('telephone', $data)) {
            $admin->telephone = array_get($data, 'telephone');
        }
        if (array_key_exists('password', $data)) {
            $admin->password = array_get($data, 'password');
        }
        if (array_key_exists('type', $data)) {
            $admin->role = array_get($data, 'type');
        }
        return $admin;
    }

    /*
     * 后台登录
     *
     * By zm
     *
     * 2018-01-13
     */
    public static function login($telephone, $password,$remember_token){
        $where=array(
            'telephone'=>$telephone,
            'password'=>$password,
            'type'=>2
        );
        $admin=User::where($where)->first();
        if($admin){
            if(empty($admin['remember_token'])){
                $admin['remember_token']=$remember_token;
                $admin->save();
            }
        }
        $user['nick_name']=$admin['nick_name'];
        $user['avatar']=$admin['avatar'];
        $user['id']=$admin['id'];
        $user['remember_token']=$admin['remember_token'];
        return $user;
    }

    /*
     * 根据user_id和remember_token校验合法性，全部插入、更新、删除类操作需要使用中间件
     *
     * By zm
     *
     * 2018-01-13
     *
     */
    public static function ckeckAdminToken($id, $remember_token)
    {
        //根据id、remember_token获取用户信息
        $where=array(
            'id'=>$id,
            'remember_token'=>$remember_token
        );
        $count = User::where($where)->count();
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
}