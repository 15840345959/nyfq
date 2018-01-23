<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/21
 * Time: 11:39
 */

namespace App\Components;

use App\Http\Controllers\ApiResponse;
use App\Models\Organization;


class OrganizationManager
{
    /*
     * 查询旅行社信息
     *
     * by zm
     *
     * 2017-12-21
     *
     */
    public static function getOrganizationInfo($id)
    {
        if ($id==0) {
            return '南洋风情小程序';
        } else {
            $organization=Organization::where('id','=',$id)->first();
            return $organization['name'];
        }
    }


    /*
     * 模糊查询旅行社列表
     *
     * By zm
     *
     * 2018-01-23
     *
     */
    public static function getAllOrganizationLists($search)
    {
        $organizations = Organization::where('name'  , 'like', '%'.$search.'%')->orderBy('id','asc')->get();
        return $organizations;
    }


    /*
     * 根据id获取旅行社信息
     *
     * By zm
     *
     * 2018-01-23
     *
     */
    public static function getOrganizationById($id)
    {
        $organization = Organization::where('id', $id)->first();
        return $organization;
    }


    /*
     * 配置旅行社的参数
     *
     * By zm
     *
     * 2018-01-23
     *
     */
    public static function setOrganization($organization, $data){
        if (array_key_exists('name', $data)) {
            $organization->name = array_get($data, 'name');
        }
        if (array_key_exists('image', $data)) {
            $organization->image = array_get($data, 'image');
        }
        if (array_key_exists('address', $data)) {
            $organization->address = array_get($data, 'address');
        }
        if (array_key_exists('lon', $data)) {
            $organization->lon = array_get($data, 'lon');
        }
        if (array_key_exists('lat', $data)) {
            $organization->lat = array_get($data, 'lat');
        }
        return $organization;
    }
}