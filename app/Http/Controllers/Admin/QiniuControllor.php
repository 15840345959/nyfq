<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/17
 * Time: 16:51
 */

namespace App\Http\Controllers\Admin;


class QiniuControllor
{
    const QN_ACCESSKEY="JXanCoTnAoyJd4WclS-zPhA8JmWooPTqvK5RCHXb";  //七牛accessKey
    const QN_SECRETKEY="ouc-dLEY42KijHeUaTzTBzFeM2Q1mKk_M_3vNpmT";  //七牛secretKey
    const QN_BUCKET="dsyy"; //七牛图片上传空间

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getQiniuToken(Request $request)
    {
//        $accessKey = 'JXanCoTnAoyJd4WclS-zPhA8JmWooPTqvK5RCHXb';
//        $secretKey = 'ouc-dLEY42KijHeUaTzTBzFeM2Q1mKk_M_3vNpmT';
        $accessKey = self::QN_ACCESSKEY;
        $secretKey = self::QN_SECRETKEY;

        $auth = new Auth($accessKey, $secretKey);

//        $bucket = 'dsyy';
        $bucket = self::QN_BUCKET;
        $upToken = $auth->uploadToken($bucket);

        return ApiResponse::makeResponse(true, $upToken, ApiResponse::SUCCESS_CODE);
    }
}