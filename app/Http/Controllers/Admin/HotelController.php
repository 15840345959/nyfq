<?php
/**
 * Created by PhpStorm.
 * User: mtt17
 * Date: 2018/3/19
 * Time: 11:07
 */

namespace App\Http\Controllers\Admin;


use App\Components\HotelGoodsManager;
use App\Components\QNManager;
use App\Components\Utils;
use App\Models\HotelGoods;
use App\Models\HotelGoodsImage;
use App\Models\HotelGoodsRooms;
use Illuminate\Http\Request;

class HotelController
{

    //旅游定制酒店管理首页
    public function index(Request $request){
        $data = $request->all();
        $admin = $request->session()->get('admin');
        if(array_key_exists('search_word',$data)){
            $search_word=$data['search_word'];
        }
        else{
            $search_word='';
        }
        $hotelGoodsLists = HotelGoodsManager::getHotelGoodsLists($search_word);
        return view('admin.madeTour.hotel.index',['admin' => $admin,'datas' => $hotelGoodsLists]);
    }

    //旅游定制酒店管理添加-get
    public function edit(Request $request){
        $data = $request->all();
        $hotelGoods = new HotelGoods();
        if(array_key_exists('id',$data)){
            $hotelGoods = HotelGoods::find($data['id']);
        }
        $admin = $request->session()->get('admin');
        //生成七牛token
        $upload_token = QNManager::uploadToken();
        return view('admin.madeTour.hotel.edit',['admin' => $admin, 'data' => $hotelGoods, 'upload_token' => $upload_token]);
    }

    //旅游定制酒店管理添加-post
    public function editPost(Request $request){
        $data = $request->all();
        $return = null;
        $hotelGoods = new HotelGoods();
        if(array_key_exists('id',$data) && !Utils::isObjNull($data['id'])){
            $hotelGoods = HotelGoods::find($data['id']);
        }
        if(!$hotelGoods){
            $hotelGoods = new HotelGoods();
        }
        $hotelGoods = HotelGoodsManager::setHotelGoods($hotelGoods,$data);
        $result = $hotelGoods -> save();
        if($result){
            $return['result'] = true;
            $return['msg'] = '添加成功';
        }else{
            $return['result'] = false;
            $return['msg'] = '添加失败';
        }
        return $return;
    }

    //旅游定制酒店管理删除酒店信息
    public function del(Request $request,$id){
        if (is_numeric($id) !== true) {
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '合规校验失败，请检查参数广告id$id']);
        }
        $return=null;
        $hotelGoods = HotelGoods::find($id);
        $result = $hotelGoods->delete();
        if($result){
            $return['result'] = true;
            $return['msg'] = '删除成功';
        }else{
            $return['result'] = false;
            $return['msg'] = '删除失败';
        }
        return $return;
    }

    //旅游定制酒店管理添加酒店图片get
    public function addImage(Request $request){
        $data = $request->all();
        $hotelGoods = new HotelGoods();
        if(array_key_exists('id',$data)){
            $hotelGoods = HotelGoods::find($data['id']);
            $hotelGoodsImage = HotelGoodsImage::where('hotel_goods_id',$data['id'])->orderby('sort','asc')->get();
            $hotelGoods['images'] = $hotelGoodsImage;
        }
        $admin = $request->session()->get('admin');
        //生成七牛token
        $upload_token = QNManager::uploadToken();
        return view('admin.madeTour.hotel.addImages', ['admin' => $admin, 'data' => $hotelGoods, 'upload_token' => $upload_token]);
    }

    //旅游定制酒店管理添加酒店图片post
    public function addImagePost(Request $request){
        $data = $request->all();
        $admin = $request->session()->get('admin');
        $return = null;
        if(array_key_exists('id',$data)){
            $hotelGoodsImage = HotelGoodsManager::getHotelGoodsImage($data['id']);
        }else{
            $hotelGoodsImage = new HotelGoodsImage();
        }
        $hotelGoodsImage = HotelGoodsManager::setHotelGoodsImage($hotelGoodsImage,$data);
        $result = $hotelGoodsImage->save();
        if($result){
            $return['result'] = true;
            $return['ret'] = HotelGoodsManager::getHotelGoodsImage($hotelGoodsImage->id);
            $return['msg'] = '添加成功';
        }else{
            $return['result'] = false;
            $return['msg'] = '添加失败';
        }
        return $return;
    }

    //旅游定制酒店管理删除酒店图片
    public function delHotelImage(Request $request,$id){
        $data = $request->all();
        $return = null;
        //判断
        if (is_numeric($id) !== true) {
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '合规校验失败，请检查参数广告id$id']);
        }
        //根据id查询旅游定制酒店管理酒店图片
        $hotelImage = HotelGoodsImage::find($id);
        $result = $hotelImage->delete();
        if($result){
            $return['result'] = true;
            $return['msg'] = '删除成功';
        }else{
            $return['result'] = false;
            $return['msg'] = '删除失败';
        }
        return $return;
    }

    //旅游定制酒店管理首页添加酒店房间get
    public function addHotelRoomsIndex(Request $request){
        $data = $request->all();
        $admin = $request->session()->get('admin');
        //生成七牛token
        $upload_token = QNManager::uploadToken();
        if(array_key_exists('id',$data)){
            //根据hotel_goods_id获取酒店房间信息
            $hotelRooms = HotelGoodsManager::getHotelRooms($data['id']);
            foreach ($hotelRooms as $hotelRoom){
                $hotelRoom = HotelGoodsManager::getHotelDetailsByLevel($hotelRoom,'0');
            }
            return view('admin.madeTour.hotel.addHotelRoomsIndex',['admin' => $admin,'datas' => $hotelRooms, 'upload_token' => $upload_token,'hotel_goods_id'=>$data['id']]);
        }else{
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '非法访问']);
        }
    }

    //旅游定制酒店管理添加、编辑酒店房间get
    public function editHotelRooms(Request $request){
        $data = $request->all();
        $hotelRooms = new HotelGoodsRooms();
        if(array_key_exists('id',$data)){
            $hotelRooms = HotelGoodsRooms::find($data['id']);
        }
        //获取所有的酒店房间信息
        $hotelGoods = HotelGoodsManager::getHotelGoods();
        $admin = $request->session()->get('admin');
        //生成七牛token
        $upload_token = QNManager::uploadToken();
        return view('admin.madeTour.hotel.addHotelRoomsEdit',['admin' => $admin, 'hotelGoods' => $hotelGoods,'data' => $hotelRooms, 'upload_token' => $upload_token]);
    }

    //旅游定制酒店管理添加、编辑酒店房间post
    public function editHotelRoomsPost(Request $request){
        $data = $request->all();
        $return = null;
        $hotelRooms = new HotelGoodsRooms();
        if(array_key_exists('id',$data) && !Utils::isObjNull($data["id"])){
            $hotelRooms = HotelGoodsManager::getHotelRoomsById($data['id']);
        }
        if(!$hotelRooms){
            $hotelRooms = new HotelGoodsRooms();
        }
        //设置酒店房间信息
        $hotelRooms = HotelGoodsManager::setHotelRooms($hotelRooms,$data);
        $result = $hotelRooms->save();
        if($result){
            $return['result'] = true;
            $return['msg'] = '添加成功';
        }else{
            $return['result'] = false;
            $return['msg'] = '添加失败';
        }
        return $return;
    }

    //旅游定制酒店管理删除酒店房间信息
    public function delHotelRooms(Request $request,$id){
        $data = $request->all();
        $return = null;
        //判断
        if (is_numeric($id) !== true) {
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '合规校验失败，请检查参数广告id$id']);
        }
        $hotelRooms = HotelGoodsRooms::find($id);
        $result = $hotelRooms->delete();
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





















