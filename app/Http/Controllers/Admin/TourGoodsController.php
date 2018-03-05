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










}










