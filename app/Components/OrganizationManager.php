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
}