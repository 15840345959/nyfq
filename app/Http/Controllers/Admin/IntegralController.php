<?php
/**
 * Created by PhpStorm.
 * User: mtt17
 * Date: 2018/3/20
 * Time: 14:25
 */

namespace App\Http\Controllers\Admin;


use App\Components\IntegralManager;
use App\Components\QNManager;
use App\Components\Utils;
use App\Models\IntegralGoods;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;

class IntegralController
{
    //积分商品首页
    public function index(Request $request){
        $data = $request->all();
        $admin = $request->session()->get('admin');
        if(array_key_exists('search_word',$data)){
            $search_word=$data['search_word'];
        }
        else{
            $search_word='';
        }
        $integralGoods = IntegralManager::getIntegralGoods($search_word);
        return view('admin.integral.goods.index',['admin' => $admin,'datas' => $integralGoods]);
    }

    //积分商品添加、编辑-get
    public function edit(Request $request){
        $data = $request->all();
        $integralGoods = new IntegralGoods();
        if(array_key_exists('id',$data)){
            $integralGoods = IntegralGoods::find($data['id']);
        }
        $admin = $request->session()->get('admin');
        $upload_token = QNManager::uploadToken();
        return view('admin.integral.goods.edit',['admin' => $admin,'data' => $integralGoods,'upload_token' => $upload_token]);
    }

    ////积分商品添加、编辑-post
    public function editPost(Request $request){
        $data = $request->all();
        $return = null;
        $integralGoods = new IntegralGoods();
        if(array_key_exists('id',$data) && !Utils::isObjNull($data['id'])){
            $integralGoods = IntegralGoods::find($data['id']);
        }
        if(!$integralGoods){
            $integralGoods = new IntegralGoods();
        }
        $integralGoods = IntegralManager::setIntegralGoods($integralGoods,$data);
        $result = $integralGoods -> save();
        if($result){
            $return['result'] = true;
            $return['msg'] = '添加成功';
        }else{
            $return['result'] = false;
            $return['msg'] = '添加失败';
        }
        return $return;
    }

    //积分商品-删除积分商品
    public function del(Request $request,$id){
        if(is_numeric($id) !== true){
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '合规校验失败，请检查参数积分商品id$id']);
        }
        $return = null;
        $integralGoods = IntegralGoods::find($id);
        $result = $integralGoods->delete();
        if($result){
            $return['result'] = true;
            $return['msg'] = '删除成功';
        }else{
            $return['result'] = false;
            $return['msg'] = '删除失败';
        }
        return $return;
    }

    //积分兑换历史
    public function historiesIndex(Request $request){
        $data = $request->all();
        $admin = $request->session()->get('admin');
        $integralHistories = IntegralManager::getIntegralHistories();
        foreach ($integralHistories as $integralHistory){
            $integralHistory = IntegralManager::getIntegralHistoriesByLevel($integralHistory,'0');
        }
        return view('admin.integral.histories.index',['admin' => $admin,'datas' => $integralHistories]);
    }

    //用户积分记录
    public function recordsIndex(Request $request){
        $data = $request->all();
        $admin = $request->session()->get('admin');
        $integralRecords = IntegralManager::getIntegralRecords();
        foreach ($integralRecords as $integralRecord){
            $integralRecord = IntegralManager::getIntegralRecordsByLevel($integralRecord,'0');
        }
        return view('admin.integral.records.index',['admin' => $admin,'datas' => $integralRecords]);
    }





}











