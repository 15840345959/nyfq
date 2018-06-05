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
    Route::get('index/getBanners', 'API\IndexController@getBanners');
    //获取Banner的详细信息
    Route::get('index/getBannerDetail', 'API\IndexController@getBannerDetail')->middleware('CheckToken');
    //获取首页的动态栏目
    Route::get('index/getIndexMenus', 'API\IndexController@getIndexMenus');
    //获取最新产品
    Route::get('index/getNewGoods', 'API\IndexController@getNewGoods');
    //获取特价产品
    Route::get('index/getSpecialGoods', 'API\IndexController@getSpecialGoods');
    //搜索功能
    Route::get('index/search', 'API\IndexController@search')->middleware('CheckToken');

    //获取旅游产品的目的地
    Route::get('tour/getTourCategories', 'API\TourController@getTourCategories')->middleware('CheckToken');
    //获取旅游产品列表
    Route::get('tour/getTourGoodsLists', 'API\TourController@getTourGoodsLists')->middleware('CheckToken');
    //获取旅游产品的详细信息
    Route::get('tour/getTourGoodsDetail', 'API\TourController@getTourGoodsDetail');
    //根据产品类型获取旅游产品
    Route::get('tour/getTourGoods', 'API\TourController@getTourGoods');
    //根据旅游产品id获取产品日期
    Route::get('tour/getTourGoodsByTourGoodsId', 'API\TourController@getTourGoodsCalendarsByTourGoodsId');
    //根据旅游产品id获取产品日期
    Route::get('tour/getTourGoodsByGoodsIdAndDate', 'API\TourController@getTourGoodsCalendarsByTourGoodsIdAndDate');


    //获取产品的评论详情
    Route::get('comment/getGoodsCommentLists', 'API\CommentController@getGoodsCommentLists');
    //获取所有评论的详情
    Route::get('comment/getAllCommentLists', 'API\CommentController@getAllCommentLists')->middleware('CheckToken');
    //用户对评论进行点赞
    Route::post('comment/addConsent', 'API\CommentController@addConsent')->middleware('CheckToken');
    //添加评论
    Route::post('comment/addComment', 'API\CommentController@addComment')->middleware('CheckToken');
    //添加评论回复
    Route::post('comment/addCommentReplie', 'API\CommentController@addCommentReplie')->middleware('CheckToken');
    //删除评论回复
    Route::post('comment/delCommentReplie', 'API\CommentController@delCommentReplie')->middleware('CheckToken');

    //查看收藏夹
    Route::get('center/getCollectionLists', 'API\CenterController@getCollectionLists')->middleware('CheckToken');
    //添加收藏
    Route::post('center/addCollectionGoods', 'API\CenterController@addCollectionGoods')->middleware('CheckToken');
    //删除收藏夹里的产品
    Route::post('center/deleteCollectionLists', 'API\CenterController@deleteCollectionLists')->middleware('CheckToken');
    //签到
    Route::post('center/addSign', 'API\CenterController@addSign')->middleware('CheckToken');
    //我的邀请
    Route::get('center/getMyInvitation', 'API\CenterController@getMyInvitation')->middleware('CheckToken');
    //邀请其他用户
    Route::get('center/addInvitation', 'API\CenterController@addInvitation')->middleware('CheckToken');

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

    //所有产品下单接口
    Route::post('order/order', 'API\OrderController@order')->middleware('CheckToken');
    //查询订单接口
    Route::get('order/getTourOrder', 'API\OrderController@getTourOrder')->middleware('CheckToken');
    //根据user_id和goods_type获取订单信息
    Route::get('order/getOrders', 'API\OrderController@getOrdersByUserIdAndGoodsTye')->middleware('CheckToken');
    //删除订单接口
    Route::get('order/deleteTourOrder', 'API\OrderController@deleteTourOrder')->middleware('CheckToken');

    //旅游定制——机票
    Route::get('airplane/getTicket', 'API\airplaneController@getTicket')->middleware('CheckToken');
    //旅游定制——酒店
    Route::get('hotel/getHotel', 'API\hotelController@getHotel')->middleware('CheckToken');
    //旅游定制——车导
    Route::get('car/getCar', 'API\carController@getCar')->middleware('CheckToken');
    //旅游定制——成型套餐
    Route::get('Customization/getCustomization', 'API\customizationController@getCustomization')->middleware('CheckToken');
    //旅游定制——根据id成型套餐
    Route::get('Customization/getByIdCustomization', 'API\customizationController@getByIdCustomization')->middleware('CheckToken');

    //获取抢票商品信息
    Route::get('ticket/getTicketGoods', 'API\TicketGoodsController@getTicketGoodsList');

    //根据路行社id获取路行社信息
    Route::get('organizations/getOrganizations', 'API\OrganizationsController@getOrganizations');//根据id获取旅行社信息





});