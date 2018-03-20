<?php
/**
 * Created by PhpStorm.
 * User: mtt17
 * Date: 2018/3/20
 * Time: 10:26
 */

namespace App\Http\Controllers\Admin;


use App\Components\CarGoodsManager;
use App\Components\CustomizationManager;
use App\Components\HotelGoodsManager;
use App\Components\PlanGoodsManager;
use App\Components\QNManager;
use App\Components\Utils;
use App\Models\CarGoods;
use App\Models\Customization;
use Illuminate\Http\Request;

class CustomizationController
{

    //旅游定制套餐首页
    public function index(Request $request){
        $data = $request->all();
        $admin = $request->session()->get('admin');
        if(array_key_exists('search_word',$data)){
            $search_word=$data['search_word'];
        }
        else{
            $search_word='';
        }
        $customizations = CustomizationManager::getCustomizationList($search_word);
        foreach ($customizations as $customization){
            $customization = CustomizationManager::getCustomizationByLevel($customization,'0');
        }
        return view('admin.madeTour.customization.index',['admin' => $admin,'datas' => $customizations]);
    }

    //新建或编辑-get
    public function edit(Request $request){
        $data = $request->all();
        $customizations = new Customization();
        if(array_key_exists('id',$data)){
            $customizations = Customization::find($data['id']);
        }
        //获取酒店信息
        $hotel = HotelGoodsManager::getHotelGoods();
        //获取飞机票信息
        $plane = PlanGoodsManager::getPlane();
        //获取车导信息
        $car = CarGoodsManager::getCar();
        $admin = $request->session()->get('admin');
        //生成七牛token
        $upload_token = QNManager::uploadToken();
        return view('admin.madeTour.customization.edit',['admin' => $admin, 'data' => $customizations,'hotel' => $hotel,'plane' => $plane,'car' => $car, 'upload_token' => $upload_token]);
    }

    //新建或编辑-post
    public function editPost(Request $request){
        $data = $request->all();
        $return = null;
        $customizations = new Customization();
        if(array_key_exists('id',$data) && !Utils::isObjNull($data['id'])){
            $customizations = Customization::find($data['id']);
        }
        if(!$customizations){
            $customizations = new Customization();
        }
        $customizations = CustomizationManager::setCustomization($customizations,$data);
        $result = $customizations->save();
        if($result){
            $return['result'] = true;
            $return['msg'] = '添加成功';
        }else{
            $return['result'] = false;
            $return['msg'] = '添加失败';
        }
        return $return;
    }

    //删除成型套餐
    public function del(Request $request,$id){
        if (is_numeric($id) !== true) {
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '合规校验失败，请检查参数广告id$id']);
        }
        $return = null;
        $customizations = Customization::find($id);
        $result = $customizations->delete();
        if($result){
            $return['result'] = true;
            $return['msg'] = '删除成功';
        }else{
            $return['result'] = false;
            $retun['msg'] = '删除失败';
        }
        return $return;
    }







}









