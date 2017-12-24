<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


//用户类路由
Route::group(['prefix' => '', 'middleware' => ['BeforeRequest']], function () {
    // 示例接口
    Route::get('test', 'API\TestController@test');

    //获取七牛token
    Route::get('user/getQiniuToken', 'API\UserController@getQiniuToken');

    //根据id获取用户信息
    Route::get('user/getById', 'API\UserController@getUserById');
    //根据id获取用户信息带token
    Route::get('user/getByIdWithToken', 'API\UserController@getUserInfoByIdWithToken')->middleware('CheckToken');
    //根据code获取openid
    Route::get('user/getXCXOpenId', 'API\UserController@getXCXOpenId');
    //登录/注册
    Route::post('user/login', 'API\UserController@login');
    //更新用户信息
    Route::post('user/updateById', 'API\UserController@updateUserById')->middleware('CheckToken');
    //解密encryptedData
    Route::post('user/encryptedData', 'API\UserController@encryptedData');
    //新建用户
    Route::get('user/createUser', 'API\UserController@createUser');

    //获取首页Banner
    Route::get('index/getBanners', 'API\IndexController@getBanners');
    //获取Banner的详细信息
    Route::get('index/getBannerDetail', 'API\IndexController@getBannerDetail');
    //获取首页的动态栏目
    Route::get('index/getIndexMenus', 'API\IndexController@getIndexMenus');
    //获取最新
    Route::get('index/getNewGoods', 'API\IndexController@getNewGoods');

    //获取旅游产品的目的地
    Route::get('tour/getTourCategories', 'API\TourController@getTourCategories');
    //获取旅游产品列表
    Route::get('tour/getTourGoodsLists', 'API\TourController@getTourGoodsLists');
    //获取旅游产品的详细信息
    Route::get('tour/getTourGoodsDetail', 'API\TourController@getTourGoodsDetail');

    //获取产品的评论详情
    Route::get('comment/getGoodsCommentLists', 'API\CommentController@getGoodsCommentLists');
    //获取所有评论的详情
    Route::get('comment/getAllCommentLists', 'API\CommentController@getAllCommentLists');
    //用户对评论进行点赞
    Route::post('comment/addConsent', 'API\CommentController@addConsent');

});