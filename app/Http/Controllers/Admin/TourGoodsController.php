<?php
/**
 * Created by PhpStorm.
 * User: mtt17
 * Date: 2018/3/4
 * Time: 13:05
 */

namespace App\Http\Controllers\Admin;


use App\Components\QNManager;
use App\Components\TourCategorieManager;
use App\Components\TourGoodsManager;
use App\Components\Utils;
use App\Http\Controllers\ApiResponse;
use App\Models\TourGoods;
use App\Models\TourGoodsDetail;
use App\Models\TourGoodsImage;
use App\Models\TourGoodsRoute;
use Illuminate\Http\Request;

class TourGoodsController
{

    //旅游产品首页
    public function index(Request $request){
        $data = $request->all();
        $admin = $request->session()->get('admin');
        if(array_key_exists('search_word',$data)){
            $search_word=$data['search_word'];
        }
        else{
            $search_word='';
        }
        $tourGoodses = TourGoodsManager::getTourGoodsList($search_word);
        foreach ($tourGoodses as $tourGoods){
            $tourGoods = TourGoodsManager::getTourGoodsDetails($tourGoods,'0');
        }
//        dd($tourGoodses);
        return view('admin.product.tourGoods.index',['admin' => $admin,'datas' => $tourGoodses]);
    }

    //添加旅游产品get
    public function add(Request $request){
        $data = $request->all();
        $admin = $request->session()->get('admin');
        $tourGoods = new TourGoods();
        if(array_key_exists('id',$data)){
            $tourGoods = TourGoodsManager::getTourGoodsById($data['id']);
        }
        //获取旅游产品分类
        $tourCategories = TourCategorieManager::getTourCategories();
        //生成七牛token
        $upload_token = QNManager::uploadToken();
        return view('admin.product.tourGoods.add',['admin' => $admin,'tourCategories' => $tourCategories,'data' => $tourGoods, 'upload_token' => $upload_token]);
    }

    //添加旅游产品post
    public function addPost(Request $request){
        $data = $request->all();
        $tourGoods = new TourGoods();
        if(array_key_exists('id', $data) && !Utils::isObjNull($data['id'])){
            $tourGoods = TourGoods::find($data['id']);
        }
        if(!$tourGoods){
            $tourGoods = new TourGoods();
        }
        $tourGoods = TourGoodsManager::setTourGoods($tourGoods,$data);
        $tourGoods->save();
        return ApiResponse::makeResponse(true,$tourGoods,ApiResponse::SUCCESS_CODE);
    }

    //删除旅游产品
    public static function del(Request $request,$id){
        //判断
        if (is_numeric($id) !== true) {
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '合规校验失败，请检查参数广告id$id']);
        }
        //根据id查询旅游产品
        $tourGoods = TourGoods::find($id);
        $return = null;
        $result = $tourGoods->delete();
        if($result){
            $return['result'] = true;
            $return['msg'] = '删除成功';
        }else{
            $return['result'] = false;
            $return['msg'] = '删除失败';
        }
        return $return;
    }

    //查看旅游产品详情
    public function getTourGoodsDetails(Request $request){
        $data = $request->all();
        $admin = $request->session()->get('admin');
        //生成七牛token
        $upload_token = QNManager::uploadToken();
        if(array_key_exists('id',$data)){
            $tourGoodsDetails = TourGoodsManager::getTourGoodsesById($data['id']);
            foreach ($tourGoodsDetails as $tourGoodsDetail){
                $tourGoodsDetail = TourGoodsManager::getTourGoodsDetails($tourGoodsDetail,'1');
            }
            return view('admin.product.tourGoods.tourGoodsDetails',['admin' => $admin,'datas' => $tourGoodsDetails, 'upload_token' => $upload_token]);
        }else{
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '非法访问']);
        }
    }

    //编辑商品详情get
    public function edit(Request $request){
        $data = $request->all();
        $tourGoods = new TourGoods();
        if(array_key_exists('id',$data)){
            $tourGoods = TourGoodsManager::getTourGoodsById($data['id']);
            $tourGoodsDetails = TourGoodsDetail::where('tour_goods_id',$data['id'])->orderby('sort','asc')->get();
            $tourGoods['details'] = $tourGoodsDetails;
        }else{
            $tourGoods = new TourGoods();
        }
        //获取旅游产品分类
        $tourCategories = TourCategorieManager::getTourCategories();
        $admin = $request->session()->get('admin');
        //生成七牛token
        $upload_token = QNManager::uploadToken();
        return view('admin.product.tourGoods.edit',['admin' => $admin,'tourCategories' => $tourCategories,'data' => $tourGoods, 'upload_token' => $upload_token]);
    }

    //编辑旅游产品post
    public function editPost(Request $request){
        $data = $request->all();
        $admin = $request->session()->get('admin');
        $return = null;
        $tourGoods = new TourGoods();
        if (array_key_exists("id", $data) && !Utils::isObjNull($data["id"])) {
            $tourGoods = TourGoods::find($data['id']);
        }
        if(!$tourGoods){
            $tourGoods = new TourGoods();
        }
        $tourGoods = TourGoodsManager::setTourGoods($tourGoods,$data);
        $result = $tourGoods->save();
        if($result){
            $return['result'] = true;
            $return['msg'] = '编辑旅游产品成功';
        }else{
            $return['result'] = false;
            $return['msg'] = '编辑旅游产品失败';
        }
        return $return;
    }

    //编辑旅游产品详情Post
    public function editTourGoodsDetails(Request $request){
        $data = $request->all();
        $admin = $request->session()->get('admin');
        $return=null;
        if(array_key_exists('id',$data)){
            $tourGoods_details = TourGoodsManager::getTourGoodsDetailsById($data['id']);
        }else{
            $tourGoods_details = new TourGoodsDetail();
        }
        $tourGoods_details = TourGoodsManager::setTourGoodsDetails($tourGoods_details,$data);
        $result = $tourGoods_details->save();
        if($result){
            $return['result'] = true;
            $return['ret'] = TourGoodsManager::getTourGoodsDetailsById($tourGoods_details->id);
            $return['msg'] = '编辑旅游产品详情成功';
        }else{
            $return['result'] = false;
            $return['msg'] = '编辑旅游产品详情失败';
        }
        return $return;
    }

    //删除旅游产品详情
    public function delTourGoodsDetails(Request $request,$id){
        $data = $request->all();
        $return = null;
        //判断
        if (is_numeric($id) !== true) {
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '合规校验失败，请检查参数广告id$id']);
        }
        //查询旅游产品详情
        $tourGoods_details = TourGoodsDetail::find($id);
        $result = $tourGoods_details->delete();
        if($result){
            $return['result'] = true;
            $return['msg'] = '删除成功';
        }else{
            $return['result'] = false;
            $return['msg'] = '删除失败';
        }
        return $return;
    }

    //添加旅游产品图片get
    public function addImage(Request $request){
        $data = $request->all();
        $tourGoods = new TourGoods();
        if (array_key_exists('id', $data)) {
            $tourGoods =  TourGoods::find($data['id']);
            $tourGoodsImage = TourGoodsImage::where('tour_goods_id',$data['id'])->orderby('sort','asc')->get();
            $tourGoods['images'] = $tourGoodsImage;
        }
        $admin = $request->session()->get('admin');
        //生成七牛token
        $upload_token = QNManager::uploadToken();
        return view('admin.product.tourGoods.addImages', ['admin' => $admin, 'data' => $tourGoods, 'upload_token' => $upload_token]);
    }

    //添加产品图片post
    public function addImagePost(Request $request){
        $data = $request->all();
        $admin = $request->session()->get('admin');
        $return = null;
        if(array_key_exists('id',$data)){
            $tourGoodsImage = TourGoodsManager::getTourGoodsImageById($data['id']);
        }else{
            $tourGoodsImage = new TourGoodsImage();
        }
        $tourGoodsImage = TourGoodsManager::setTourGoodsImage($tourGoodsImage,$data);
        $result = $tourGoodsImage -> save();
        if($result){
            $return['result'] = true;
            $return['ret'] = TourGoodsManager::getTourGoodsImageById($tourGoodsImage->id);
            $return['msg'] = '添加成功';
        }else{
            $return['result'] = false;
            $return['msg'] = '添加失败';
        }
        return $return;
    }

    //删除旅游产品图片
    public function delTourGoodsImage(Request $request,$id){
        $data = $request->all();
        $return = null;
        //判断
        if (is_numeric($id) !== true) {
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '合规校验失败，请检查参数广告id$id']);
        }
        //根据id查询旅游产品图片
        $tourGoodsImage = TourGoodsImage::find($id);
        $result = $tourGoodsImage->delete();
        if($result){
            $return['result'] = true;
            $return['msg'] = '删除成功';
        }else{
            $return['result'] = false;
            $return['msg'] = '删除失败';
        }
        return $return;
    }

    //产品管理首页添加旅游产品线路get
    public function addRoutes(Request $request){
        $data = $request->all();
        $admin = $request->session()->get('admin');
        //生成七牛token
        $upload_token = QNManager::uploadToken();
        if(array_key_exists('id',$data)){
            $tourGoodsRoutes = TourGoodsManager::getTourGoodsRoutes($data['id']);
//            dd($tourGoodsRoutes);
            foreach ($tourGoodsRoutes as $tourGoodsRoute){
                $tourGoodsRoute = TourGoodsManager::getTourGoodsDetails($tourGoodsRoute,'2');
            }
            return view('admin.product.tourGoods.addRoutesIndex',['admin' => $admin,'datas' => $tourGoodsRoutes, 'upload_token' => $upload_token,'tour_goods_id'=>$data['id']]);
        }else{
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '非法访问']);
        }
    }

    //路线管理首页添加、编辑旅游产品线路get
    public function editRoutes(Request $request){
        $data = $request->all();
        $tourGoodsRoute = new TourGoodsRoute();
        if(array_key_exists('id', $data)){
            $tourGoodsRoute = TourGoodsRoute::find($data['id']);
        }
        //获取旅游产品信息
        $tourGoods = TourGoodsManager::getTourGoods();
        $admin = $request->session()->get('admin');
        //生成七牛token
        $upload_token = QNManager::uploadToken();
        return view('admin.product.tourGoods.addRoutesEdit',['admin' => $admin, 'tourGoods' => $tourGoods,'data' => $tourGoodsRoute, 'upload_token' => $upload_token]);
    }

    //路线管理首页添加、编辑旅游产品线路post
    public function editRoutesPost(Request $request){
        $data = $request->all();
        $return = null;
        $tourGoodsRoutes = new TourGoodsRoute();
        if(array_key_exists('id',$data) && !Utils::isObjNull($data["id"])){
            $tourGoodsRoutes = TourGoodsManager::getTourGoodsRoutesById($data['id']);
        }
        if (!$tourGoodsRoutes) {
            $tourGoodsRoutes = new TourGoodsRoute();
        }
        $tourGoodsRoutes = TourGoodsManager::setTourGoodsRoutes($tourGoodsRoutes,$data);
        $result = $tourGoodsRoutes->save();
        if($result){
            $return['result'] = true;
            $return['msg'] = '添加成功';
        }else{
            $return['result'] = false;
            $return['msg'] = '添加失败';
        }
        return $return;
    }

    //删除旅游产品路线
    public function delRoutes(Request $request,$id){
        $data = $request->all();
        $return = null;
        //判断
        if (is_numeric($id) !== true) {
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '合规校验失败，请检查参数广告id$id']);
        }
        $tourGoodsRoutes = TourGoodsRoute::find($id);
        $result = $tourGoodsRoutes->delete();
        if($result){
            $return['result'] = true;
            $return['msg'] = '删除成功';
        }else{
            $return['result'] = false;
            $return['msg'] = '删除失败';
        }
        return $return;
    }












}










