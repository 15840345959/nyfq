<?php
/**
 * Created by PhpStorm.
 * User: mtt17
 * Date: 2018/3/4
 * Time: 13:05
 */

namespace App\Http\Controllers\Admin;


use App\Components\QNManager;
use App\Components\RequestValidator;
use App\Components\TourCategorieManager;
use App\Components\TourGoodsManager;
use App\Components\Utils;
use App\Http\Controllers\ApiResponse;
use App\Models\Goods;
use App\Models\TourCategorie;
use App\Models\TourGoods;
use App\Models\TourGoodsCalendar;
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
        $result = $tourGoods->save();
        if($result){
            //操作旅游产品汇总表
            $goods = new Goods();
            $goods -> goods_id = $tourGoods->id;
//            dd($result['id']);
            $goods -> goods_type = '1';
            $goods -> save();
        }
        return ApiResponse::makeResponse(true,$result,ApiResponse::SUCCESS_CODE);
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

    //产品管理首页添加旅游产品日期价格get
    public function addCalendars(Request $request){
        $data = $request->all();
        $admin = $request->session()->get('admin');
        //生成七牛token
        $upload_token = QNManager::uploadToken();
        if(array_key_exists('id',$data)){
            //获取旅游产品日期价格详情信息
            $tourGoodsCalendars = TourGoodsManager::getTourGoodsCalendarsByTourGoodsId($data['id']);
            foreach ($tourGoodsCalendars as $tourGoodsCalendar){
                $tourGoodsCalendar = TourGoodsManager::getTourGoodsDetails($tourGoodsCalendar,'3');
            }
            return view('admin.product.tourGoods.addCalendarsIndex',['admin' => $admin,'datas' => $tourGoodsCalendars, 'upload_token' => $upload_token,'tour_goods_id'=>$data['id']]);
        }else{
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '非法访问']);
        }
    }

    //产品管理添加、编辑旅游产品日期价格get
    public function editCalendars(Request $request){
        $data = $request->all();
        $tourGoodsCalendars = new TourGoodsCalendar();
        if(array_key_exists('id', $data)){
            $tourGoodsCalendars = TourGoodsCalendar::find($data['id']);
        }
        //获取旅游产品信息
        $tourGoods = TourGoodsManager::getTourGoods();
        $admin = $request->session()->get('admin');
        //生成七牛token
        $upload_token = QNManager::uploadToken();
        return view('admin.product.tourGoods.addCalendarsEdit',['admin' => $admin, 'tourGoods' => $tourGoods,'data' => $tourGoodsCalendars, 'upload_token' => $upload_token]);
    }

    //产品管理添加、编辑旅游产品日期价格post
    public function editCalendarsPost(Request $request){
        $data = $request->all();
        $return = null;
        $tourGoodsCalendars = new TourGoodsCalendar();
        if(array_key_exists('id',$data)){
            $tourGoodsCalendars = TourGoodsManager::getTourGoodsCalendarsById($data['id']);
        }
        if(!$tourGoodsCalendars){
            $tourGoodsCalendars = new TourGoodsCalendar();
        }
        $tourGoodsCalendars = TourGoodsManager::setTourGoodsCalendars($tourGoodsCalendars,$data);
        $result = $tourGoodsCalendars->save();
        if($result){
            $return['result'] = true;
            $return['msg'] = '添加成功';
        }else{
            $return['result'] = false;
            $return['msg'] = '添加失败';
        }
        return $return;
    }

    //产品管理批量添加旅游产品日期价格get
    public function editMoreCalendars(Request $request){
        $data = $request->all();
        $tourGoodsCalendars = new TourGoodsCalendar();
        if(array_key_exists('id', $data)){
            $tourGoodsCalendars = TourGoodsCalendar::find($data['id']);
        }
        //获取旅游产品信息
        $tourGoods = TourGoodsManager::getTourGoods();
        $admin = $request->session()->get('admin');
        //生成七牛token
        $upload_token = QNManager::uploadToken();
        return view('admin.product.tourGoods.addMoreCalendarsEdit',['admin' => $admin, 'tourGoods' => $tourGoods,'data' => $tourGoodsCalendars, 'upload_token' => $upload_token]);
    }

    //产品管理批量添加旅游产品日期价格post
    public function editMoreCalendarsPost(Request $request){
        $data = $request->all();
        $return = null;
        if(array_key_exists('date_start',$data)&&array_key_exists('date_end',$data)){
            if($data['date_start']==$data['date_end']){
                $data['date']=$data['date_start'];
                $tourGoodsCalendars = new TourGoodsCalendar();
                if(array_key_exists('id',$data)){
                    $tourGoodsCalendars = TourGoodsManager::getTourGoodsCalendarsById($data['id']);
                }
                if(!$tourGoodsCalendars){
                    $tourGoodsCalendars = new TourGoodsCalendar();
                }
                $tourGoodsCalendars = TourGoodsManager::setTourGoodsCalendars($tourGoodsCalendars,$data);
                $result = $tourGoodsCalendars->save();
                if($result){
                    $return['result'] = true;
                    $return['msg'] = '添加成功';
                }else{
                    $return['result'] = false;
                    $return['msg'] = '添加失败';
                }
            }
            else{
                $add_count=0;
                $count=self::diffBetweenTwoDays($data['date_end'],$data['date_start']);
                for($i=1;$i<=$count;$i++){
                    $data['date']=date("Y-m-d",strtotime("+".$i." day",strtotime($data['date_start'])));
                    $tourGoodsCalendars = new TourGoodsCalendar();
                    if(array_key_exists('id',$data)){
                        $tourGoodsCalendars = TourGoodsManager::getTourGoodsCalendarsById($data['id']);
                    }
                    if(!$tourGoodsCalendars){
                        $tourGoodsCalendars = new TourGoodsCalendar();
                    }
                    $tourGoodsCalendars = TourGoodsManager::setTourGoodsCalendars($tourGoodsCalendars,$data);
                    $result = $tourGoodsCalendars->save();
                    if($result){
                        $add_count++;
                    }
                }
                if($add_count==$count){
                    $return['result'] = true;
                    $return['msg'] = '添加成功';
                }
                else{
                    $return['result'] = false;
                    $return['msg'] = '部分信息添加失败';
                }
            }
        }
        else{
            $return['result'] = false;
            $return['msg'] = '参数错误';
        }
        return $return;
    }

    //删除旅游产品路线
    public function delCalendars(Request $request,$id){
        $data = $request->all();
        $return = null;
        //判断
        if (is_numeric($id) !== true) {
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '合规校验失败，请检查参数广告id$id']);
        }
        $tourCalendars = TourGoodsCalendar::find($id);
        $result = $tourCalendars->delete();
        if($result){
            $return['result'] = true;
            $return['msg'] = '删除成功';
        }else{
            $return['result'] = false;
            $return['msg'] = '删除失败';
        }
        return $return;
    }

        /*
        * 获取旅游产品的二维码
        *
        * By mtt
        *
        * 2018-05-14
        */
        public function ewm(Request $request){
            $data = $request->all();
            $admin = $request->session()->get('admin');
//        dd($data);
            //合规校验
            $requestValidationResult = RequestValidator::validator($request->all(), [
                'id' => 'required',
            ]);
            if ($requestValidationResult !== true) {
                return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '合规校验失败，请检查参数' . $requestValidationResult]);
            }
            $filename = 'tourGoods_' . $data['id'] . '.png';
            //判断文件是否存在
            if (file_exists(public_path('img/') . $filename)) {
//            dd("file exists");
            } else {
                $app = app('wechat.mini_program');
                $response = $app->app_code->get('pages/travelDetails/travelDetails?travelid=' . $data['id']);
                $response->saveAs(public_path('img'), 'tourGoods_' . $data['id'] . '.png');
            }
            return view('admin.product.tourGoods.ewm', ['admin' => $admin, 'filename' => $filename]);
        }

    /*
     * 判断两个日期相差的天数
     *
     * By zm
     *
     * 2018-05-31
     */
    public function diffBetweenTwoDays($day1, $day2)
    {
        $second1 = strtotime($day1);
        $second2 = strtotime($day2);

        if ($second1 < $second2) {
            $tmp = $second2;
            $second2 = $second1;
            $second1 = $tmp;
        }
        return ($second1 - $second2) / 86400;
    }









}










