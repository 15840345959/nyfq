<?php
/**
 * Created by PhpStorm.
 * User: mtt17
 * Date: 2018/3/19
 * Time: 21:20
 */

namespace App\Http\Controllers\Admin;


use App\Components\CarGoodsManager;
use App\Components\QNManager;
use App\Components\Utils;
use App\Models\CarGoods;
use Illuminate\Http\Request;

class CarController
{

    //车导管理首页
    public function index(Request $request){
        $data = $request->all();
        $admin = $request->session()->get('admin');
        if(array_key_exists('search_word',$data)){
            $search_word=$data['search_word'];
        }
        else{
            $search_word='';
        }
        $carGoods = CarGoodsManager::getCarGoods($search_word);
        return view('admin.madeTour.car.index',['admin' => $admin,'datas' => $carGoods]);
    }

    //车导管理添加、编辑-get
    public function edit(Request $request){
        $data = $request->all();
        $carGoods = new CarGoods();
        if(array_key_exists('id',$data)){
            $carGoods = CarGoods::find($data['id']);
        }
        $admin = $request->session()->get('admin');
        //生成七牛token
        $upload_token = QNManager::uploadToken();
        return view('admin.madeTour.car.edit',['admin' => $admin, 'data' => $carGoods, 'upload_token' => $upload_token]);
    }

    //车导管理添加、编辑-post
    public function editPost(Request $request){
        $data = $request->all();
        $return = null;
        $carGoods = new CarGoods();
        if(array_key_exists('id',$data) && !Utils::isObjNull($data['id'])){
            $carGoods = CarGoods::find($data['id']);
        }
        if(!$carGoods){
            $carGoods = new CarGoods();
        }
        $carGoods = CarGoodsManager::setCarGoods($carGoods,$data);
        $result = $carGoods->save();
        if($result){
            $return['result'] = true;
            $return['msg'] = '添加成功';
        }else{
            $return['result'] = false;
            $return['msg'] = '添加失败';
        }
        return $return;
    }

    //车导管理-删除车导信息
    public function del(Request $request,$id){
        if (is_numeric($id) !== true) {
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '合规校验失败，请检查参数广告id$id']);
        }
        $return = null;
        $carGoods = CarGoods::find($id);
        $result = $carGoods->delete();
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

















