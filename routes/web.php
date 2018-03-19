<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//登录
Route::get('/admin/login', 'Admin\LoginController@login');        //登录
Route::post('/admin/login', 'Admin\LoginController@loginDo');   //post登录请求
Route::get('/admin/loginout', 'Admin\LoginController@loginout');  //注销
Route::group(['prefix' => 'admin', 'middleware' => ['admin.login']], function () {

    //首页
    Route::get('/', 'Admin\IndexController@index');       //首页
    Route::get('/index', 'Admin\IndexController@index');  //首页
    Route::get('/welcome', 'Admin\IndexController@welcome');  //欢迎页

    Route::get('/dashboard/index', 'Admin\IndexController@index');    //首页

    //错误页面
    Route::get('/error/500', 'Admin\IndexController@error');  //错误页面

    //管理员管理
    Route::get('/admin/index', 'Admin\AdminController@index');  //管理员管理首页
    Route::post('/admin/index', 'Admin\AdminController@index');  //搜索管理员
    Route::get('/admin/del/{id}', 'Admin\AdminController@del');  //删除管理员
    Route::get('/admin/edit', 'Admin\AdminController@edit');  //新建或编辑管理员
    Route::post('/admin/edit', 'Admin\AdminController@editDo');  //新建或编辑管理员
    Route::get('/admin/editMySelf', ['as' => 'editMySelf', 'uses' => 'Admin\AdminController@editMySelf']);  //新建或编辑管理员
    Route::post('/admin/editMySelf', 'Admin\AdminController@editMySelfDo');  //新建或编辑管理员
    Route::post('/admin/testPassword', 'Admin\AdminController@testPassword');  //新建或编辑管理员

    //Banner管理
    Route::get('/banner/index', 'Admin\BannerController@index');  //Banner管理首页
    Route::post('/banner/index', 'Admin\BannerController@index');  //搜索管理员
    Route::get('/banner/add', 'Admin\BannerController@add');  //新建Banner
    Route::post('/banner/add', 'Admin\BannerController@addDo');  //新建Banner
    Route::get('/banner/del/{id}', 'Admin\BannerController@del');  //删除Banner
    Route::get('/banner/edit', 'Admin\BannerController@edit');  //编辑Banner
    Route::post('/banner/edit', 'Admin\BannerController@editDo');  //编辑Banner
    Route::get('/bannerdetail/del/{id}', 'Admin\BannerController@delDetail');  //删除Banner详情信息
    Route::post('/bannerdetail/edit', 'Admin\BannerController@editDoDetail');  //编辑Banner详情信息

    //旅行社管理
    Route::get('/organization/index', 'Admin\OrganizationController@index');  //旅行社管理首页
    Route::post('/organization/index', 'Admin\OrganizationController@index');  //搜索旅行社
    Route::get('/organization/edit', 'Admin\OrganizationController@edit');  //新建或编辑旅行社
    Route::post('/organization/edit', 'Admin\OrganizationController@editDo');  //新建或编辑旅行社
    Route::get('/organization/del/{id}', 'Admin\OrganizationController@del');  //删除旅行社
    Route::get('/organization/admin', 'Admin\OrganizationController@admin');  //旅行社管理员管理首页
    Route::get('/organization/adminSearch', 'Admin\OrganizationController@admin');  //搜索旅行社管理员
    Route::get('/organization/delAdmin/{id}', 'Admin\OrganizationController@delAdmin');  //删除旅行社管理员
    Route::get('/organization/editAdmin', 'Admin\OrganizationController@editAdmin');  //新建或编辑旅行社管理员
    Route::get('/organization/editAdminSearch', 'Admin\OrganizationController@editAdmin');  //搜索旅行社备选管理员
    Route::post('/organization/editAdmin', 'Admin\OrganizationController@editAdminDo');  //新建或编辑旅行社管理员

    //会员管理
    Route::get('/member/index', 'Admin\MemberController@index');  //会员管理首页
    Route::get('/member/edit', 'Admin\MemberController@edit');  //查看会员详情

    //评论管理
    Route::get('/comment/index', 'Admin\CommentController@index');  //评论管理首页
    Route::get('/comment/edit', 'Admin\CommentController@edit');  //查看评论详情
    Route::post('/comment/examine', 'Admin\CommentController@examine');  //审核评论
    Route::get('/comment/del/{id}', 'Admin\CommentController@del');  //删除评论

    //订单管理
    Route::get('/orders/index', 'Admin\ordersController@index');  //订单管理首页
    Route::get('/orders/orderDetails', 'Admin\ordersController@getOrderDetails');  //查看订单详情
    Route::get('/orders/setStatus/{id}', 'Admin\ordersController@setOrderStatus');  //设置订单状态

    //产品分类管理
    Route::get('/product/tourCategories/index', 'Admin\tourCategoriesController@index');  //产品分类管理首页
    Route::get('/product/tourCategories/edit', 'Admin\tourCategoriesController@edit');  //产品分类管理新建或编辑get
    Route::post('/product/tourCategories/edit', 'Admin\tourCategoriesController@editPost');  //产品分类管理新建或编辑post
    Route::get('/product/tourCategories/del/{id}', 'Admin\tourCategoriesController@del');  //删除产品分类
    Route::post('/product/tourCategories/index', 'Admin\tourCategoriesController@index');  //产品分类搜索

    //旅游产品管理
    Route::get('/product/tourGoods/index', 'Admin\TourGoodsController@index');  //产品管理首页
    Route::post('/product/tourGoods/index', 'Admin\TourGoodsController@index');  //产品管理搜索
    Route::get('/product/tourGoods/add', 'Admin\TourGoodsController@add');  //添加产品get
    Route::post('/product/tourGoods/add', 'Admin\TourGoodsController@addPost');  //添加产品post
    Route::get('/product/tourGoods/del/{id}', 'Admin\TourGoodsController@del');  //删除旅游产品
    Route::get('/product/tourGoods/tourGoodsDetails', 'Admin\TourGoodsController@getTourGoodsDetails');  //查看旅游产品详情
    Route::get('/product/tourGoods/edit', 'Admin\TourGoodsController@edit');  //编辑旅游产品get
    Route::post('/product/tourGoods/edit', 'Admin\TourGoodsController@editPost');  //编辑旅游产品post
    Route::post('/product/tourGoods/editTourGoodsDetails', 'Admin\TourGoodsController@editTourGoodsDetails');  //编辑旅游产品详情post
    Route::get('/product/tourGoods/delTourGoodsDetails/{id}', 'Admin\TourGoodsController@delTourGoodsDetails');  //删除旅游产品详情信息
    Route::get('/product/tourGoods/addImage', 'Admin\TourGoodsController@addImage');  //添加旅游产品图片get
    Route::post('/product/tourGoods/addImage', 'Admin\TourGoodsController@addImagePost');  //添加旅游产品图片post
    Route::get('/product/tourGoods/delTourGoodsImage/{id}', 'Admin\TourGoodsController@delTourGoodsImage');  //删除旅游产品图片
    Route::get('/product/tourGoods/addRoutes', 'Admin\TourGoodsController@addRoutes');  //添加旅游产品路线首页
    Route::get('/product/tourGoods/editRoutes', 'Admin\TourGoodsController@editRoutes');  //旅游产品路线编辑和添加get
    Route::post('/product/tourGoods/editRoutes', 'Admin\TourGoodsController@editRoutesPost');  //旅游产品路线编辑和添加post
    Route::get('/product/tourGoods/delRoutes/{id}', 'Admin\TourGoodsController@delRoutes');  //删除旅游产品路线
    Route::get('/product/tourGoods/addCalendars', 'Admin\TourGoodsController@addCalendars');  //添加旅游产品日期价格详情信息首页
    Route::get('/product/tourGoods/editCalendars', 'Admin\TourGoodsController@editCalendars');  //旅游产品日期价格详情信息编辑和添加get
    Route::post('/product/tourGoods/editCalendars', 'Admin\TourGoodsController@editCalendarsPost');  //旅游产品日期价格详情信息编辑和添加post
    Route::get('/product/tourGoods/delCalendars/{id}', 'Admin\TourGoodsController@delCalendars');  //删除旅游产品日期价格详情信息

    //旅游定制管理-酒店管理
    Route::get('/madeTour/hotel/index', 'Admin\HotelController@index');  //旅游定制-酒店管理
    Route::post('/madeTour/hotel/index', 'Admin\HotelController@index');  //旅游定制-酒店管理搜索
    Route::get('/madeTour/hotel/edit', 'Admin\HotelController@edit');  //旅游定制-酒店管理-添加，编辑get
    Route::post('/madeTour/hotel/edit', 'Admin\HotelController@editPost');  //旅游定制-酒店管理-添加，编辑post
    Route::get('/madeTour/hotel/del/{id}', 'Admin\HotelController@del');  //旅游定制-酒店管理-删除
    Route::get('/madeTour/hotel/addImage', 'Admin\HotelController@addImage');  //旅游定制-酒店管理-添加图片-get
    Route::post('/madeTour/hotel/addImage', 'Admin\HotelController@addImagePost');  //旅游定制-酒店管理-添加图片-post
    Route::get('/madeTour/hotel/delHotelImage/{id}', 'Admin\HotelController@delHotelImage');  //旅游定制-酒店管理-删除图片
    Route::get('/madeTour/hotel/addHotelRoomsIndex', 'Admin\HotelController@addHotelRoomsIndex');  //旅游定制酒店管理首页添加酒店房间get
    Route::get('/madeTour/hotel/editHotelRooms', 'Admin\HotelController@editHotelRooms');  //旅游定制酒店管理添加、编辑酒店房间get
    Route::post('/madeTour/hotel/editHotelRooms', 'Admin\HotelController@editHotelRoomsPost');  //旅游定制酒店管理添加、编辑酒店房间post
    Route::get('/madeTour/hotel/delHotelRooms/{id}', 'Admin\HotelController@delHotelRooms');  //旅游定制-酒店管理-删除酒店房间信息

    //旅游定制管理-分机票管理
    Route::get('/madeTour/plane/index', 'Admin\PlaneController@index');  //旅游定制-分机票管理
    Route::post('/madeTour/plane/index', 'Admin\PlaneController@index');  //旅游定制-分机票管理搜索
    Route::get('/madeTour/plane/edit', 'Admin\PlaneController@edit');  //旅游定制-分机票管理-添加，编辑get
    Route::post('/madeTour/plane/edit', 'Admin\PlaneController@editPost');  //旅游定制-分机票管理-添加，编辑post
    Route::get('/madeTour/plane/del/{id}', 'Admin\PlaneController@del');  //旅游定制-酒店管理-删除酒店房间信息





});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
