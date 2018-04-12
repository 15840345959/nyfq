<?php
/**
 * Created by PhpStorm.
 * User: mtt17
 * Date: 2018/3/19
 * Time: 17:55
 */

namespace App\Http\Controllers\Admin;


use App\Components\GoodsesManager;
use App\Components\PlanGoodsManager;
use App\Components\QNManager;
use App\Components\Utils;
use App\Models\Goods;
use App\Models\PlanGoods;
use Illuminate\Http\Request;

class PlaneController
{

    //旅游定制管理-飞机票管理首页
    public function index(Request $request){
        $data = $request->all();
        $admin = $request->session()->get('admin');
        if(array_key_exists('search_word',$data)){
            $search_word=$data['search_word'];
        }
        else{
            $search_word='';
        }
        $planeGoods = PlanGoodsManager::getPlaneGoods($search_word);
        return view('admin.madeTour.plane.index',['admin' => $admin,'datas' => $planeGoods]);
    }

    //新建或编辑产品get
    public function edit(Request $request){
        $data = $request->all();
        $planeGoods = new PlanGoods();
        if(array_key_exists('id',$data)){
            $planeGoods = PlanGoods::find($data['id']);
        }
        $admin = $request->session()->get('admin');
        //生成七牛token
        $upload_token = QNManager::uploadToken();
        return view('admin.madeTour.plane.edit',['admin' => $admin, 'data' => $planeGoods, 'upload_token' => $upload_token]);
    }

    //新建或编辑产品post
    public function editPost(Request $request){
        $data = $request->all();
        $return = null;
        $planeGoods = new PlanGoods();
        if(array_key_exists('id',$data) && !Utils::isObjNull($data['id'])){
            $planeGoods = PlanGoods::find($data['id']);
        }
        if(!$planeGoods){
            $planeGoods = new PlanGoods();
        }
        $planeGoods = PlanGoodsManager::setPlaneGoods($planeGoods,$data);
        $result = $planeGoods->save();
        if($result){
            //查产品汇总表中是否存在数据
            $goods = GoodsesManager::getByGoodsId($planeGoods->id);
            if(!$goods){
            //操作旅游产品汇总表
            $goods = new Goods();
            $goods -> goods_id = $planeGoods->id;
//            dd($result['id']);
            $goods -> goods_type = '3';
            $goods -> save();
            }else{

            }
            $return['result'] = true;
            $return['msg'] = '添加成功';
        }else{
            $return['result'] = false;
            $return['msg'] = '添加失败';
        }
        return $return;
    }

    //删除飞机票产品
    public function del(Request $request,$id){
        if (is_numeric($id) !== true) {
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '合规校验失败，请检查参数广告id$id']);
        }
        $planeGoods = PlanGoods::find($id);
        $return=null;
        $result = $planeGoods->delete();
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











