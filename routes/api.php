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
    Route::get('user/getQiniuToken', 'API\UserController@getQiniuToken')->middleware('CheckToken');

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
    Route::get('index/getBanners', 'API\IndexController@getBanners')->middleware('CheckToken');
    //获取Banner的详细信息
    Route::get('index/getBannerDetail', 'API\IndexController@getBannerDetail')->middleware('CheckToken');
    //获取首页的动态栏目
    Route::get('index/getIndexMenus', 'API\IndexController@getIndexMenus')->middleware('CheckToken');
    //获取最新产品
    Route::get('index/getNewGoods', 'API\IndexController@getNewGoods')->middleware('CheckToken');
    //获取特价产品
    Route::get('index/getSpecialGoods', 'API\IndexController@getSpecialGoods')->middleware('CheckToken');

    //获取旅游产品的目的地
    Route::get('tour/getTourCategories', 'API\TourController@getTourCategories')->middleware('CheckToken');
    //获取旅游产品列表
    Route::get('tour/getTourGoodsLists', 'API\TourController@getTourGoodsLists')->middleware('CheckToken');
    //获取旅游产品的详细信息
    Route::get('tour/getTourGoodsDetail', 'API\TourController@getTourGoodsDetail')->middleware('CheckToken');

    //获取产品的评论详情
    Route::get('comment/getGoodsCommentLists', 'API\CommentController@getGoodsCommentLists')->middleware('CheckToken');
    //获取所有评论的详情
    Route::get('comment/getAllCommentLists', 'API\CommentController@getAllCommentLists')->middleware('CheckToken');
    //用户对评论进行点赞
    Route::post('comment/addConsent', 'API\CommentController@addConsent')->middleware('CheckToken');
    //添加评论
    Route::post('comment/addComment', 'API\CommentController@addComment')->middleware('CheckToken');
    //添加评论回复
    Route::post('comment/addCommentReplie', 'API\CommentController@addCommentReplie')->middleware('CheckToken');

    //查看收藏夹
    Route::get('center/getCollectionLists', 'API\CenterController@getCollectionLists')->middleware('CheckToken');
    //删除收藏夹里的产品
    Route::post('center/deleteCollectionLists', 'API\CenterController@deleteCollectionLists')->middleware('CheckToken');
    //签到
    Route::post('center/addSign', 'API\CenterController@addSign')->middleware('CheckToken');

    //获取积分商城列表
    Route::get('integral/getIntegralLists', 'API\IntegralController@getIntegralLists')->middleware('CheckToken');
    //获取用户积分明细列表
    Route::get('integral/getIntegralDetaileLists', 'API\IntegralController@getIntegralDetaileLists')->middleware('CheckToken');
    //游客端——获取积分兑换历史
    Route::get('integral/getIntegralHistoryListsForUser', 'API\IntegralController@getIntegralHistoryListsForUser')->middleware('CheckToken');
    //游客端——兑换积分商品
    Route::post('integral/addIntegralHistory', 'API\IntegralController@addIntegralHistory')->middleware('CheckToken');
    //旅行社端——获取积分兑换历史
    Route::get('integral/getIntegralHistoryListsForOrganization', 'API\IntegralController@getIntegralHistoryListsForOrganization')->middleware('CheckToken');
    //旅行社端——修改兑换状态
    Route::post('integral/updateIntegralStatusById', 'API\IntegralController@updateIntegralStatusById')->middleware('CheckToken');
});