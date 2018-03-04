<?php
/**
 * Created by PhpStorm.
 * User: mtt17
 * Date: 2018/3/2
 * Time: 15:16
 */

namespace App\Http\Controllers\Admin;



use App\Components\QNManager;
use App\Components\TourCategorieManager;
use App\Http\Controllers\ApiResponse;
use App\Models\TourCategorie;
use App\Components\Utils;
use Illuminate\Http\Request;

class tourCategoriesController
{
    //旅游产品分类首页
    public function index(Request $request){
        $data = $request->all();
        $admin = $request->session()->get('admin');
        if(array_key_exists('search_word',$data)){
            $search_word=$data['search_word'];
        }
        else{
            $search_word='';
        }
        $tourCategories = TourCategorieManager::getAllTourCategoriesLists($search_word);
        return view('admin.product.tourCategories.index',['admin' => $admin,'datas' => $tourCategories]);
    }

    //新建或编辑产品get
    public function edit(Request $request){
        $data = $request->all();
        $tourCategories = new TourCategorie();
        if(array_key_exists('id', $data)){
            $tourCategories = TourCategorie::find($data['id']);
        }
        $admin = $request->session()->get('admin');
        //生成七牛token
        $upload_token = QNManager::uploadToken();
        return view('admin.product.tourCategories.edit',['admin' => $admin, 'data' => $tourCategories, 'upload_token' => $upload_token]);
    }

    //新建或编辑产品post
    public function editPost(Request $request){
        $data = $request->all();
        $tourCategories = new TourCategorie();
        if(array_key_exists('id', $data) && !Utils::isObjNull($data['id'])){
            $tourCategories = TourCategorie::find($data['id']);
        }
        if(!$tourCategories){
            $tourCategories = new TourCategorie();
        }
        $tourCategories = TourCategorieManager::setTourCategories($tourCategories,$data);
        $tourCategories->save();
        return ApiResponse::makeResponse(true,$tourCategories,ApiResponse::SUCCESS_CODE);
    }

    //删除产品分类
    public function del(Request $request,$id){
        if (is_numeric($id) !== true) {
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '合规校验失败，请检查参数广告id$id']);
        }
        $tourCategories = TourCategorie::find($id);
        $return=null;
        $result = $tourCategories->delete();
        if($result){
            $return['result']=true;
            $return['msg']='删除成功';
        }
        else{
            $return['result']=false;
            $return['msg']='删除失败';
        }
        return $return;
    }












}








