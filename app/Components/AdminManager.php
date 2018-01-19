<?php

/**
 * Created by PhpStorm.
 * User: HappyQi
 * Date: 2017/9/28
 * Time: 10:30
 */

namespace App\Components;

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
            $admin->type = array_get($data, 'type');
        }
        if (array_key_exists('admin', $data)) {
            $admin->admin = array_get($data, 'admin');
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
    public static function login($telephone){
        $admin=User::where('telephone',$telephone)->where('type',2)->first();
        $user=[];
        if($admin){
            $user['id']=$admin['id'];
            $user['nick_name']=$admin['nick_name'];
            $user['avatar']=$admin['avatar'];
            $user['type']=$admin['type'];
            $user['admin']=$admin['admin'];
            $user['password']=$admin['password'];
        }
        return $user;
    }

    /*
     * 查询电话号码
     *
     * By zm
     *
     * 2018-01-17
     */
    public static function getAdminByTel($telephone){
        $admin=User::where('telephone',$telephone)->where('type',2)->first();
        $user=[];
        if($admin){
            $user['id']=$admin['id'];
            $user['nick_name']=$admin['nick_name'];
            $user['avatar']=$admin['avatar'];
            $user['type']=$admin['type'];
            $user['admin']=$admin['admin'];
            $user['password']=$admin['password'];
        }
        return $user;
    }

    /*
     * 根据user_id校验合法性，全部插入、更新、删除类操作需要使用中间件
     *
     * By zm
     *
     * 2018-01-13
     *
     */
    public static function ckeckAdminToken($id)
    {
        //根据id、remember_token获取用户信息
        $where=array(
            'id'=>$id,
        );
        $count = User::where($where)->count();
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
}