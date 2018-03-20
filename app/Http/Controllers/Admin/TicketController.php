<?php
/**
 * Created by PhpStorm.
 * User: mtt17
 * Date: 2018/3/20
 * Time: 17:00
 */

namespace App\Http\Controllers\Admin;


use App\Components\QNManager;
use App\Components\TicketGoodsManager;
use App\Components\Utils;
use App\Models\TicketGoods;
use Illuminate\Http\Request;

class TicketController
{
    //抢票管理首页
    public function index(Request $request){
        $data = $request->all();
        $admin = $request->session()->get('admin');
        if(array_key_exists('search_word',$data)){
            $search_word=$data['search_word'];
        }
        else{
            $search_word='';
        }
        $ticketGoods = TicketGoodsManager::getTicketGoods($search_word);
        return view('admin.ticket.index',['admin' => $admin,'datas' => $ticketGoods]);
    }

    //抢票管理添加、编辑-get
    public function edit(Request $request){
        $data = $request->all();
        $ticketGoods = new TicketGoods();
        if(array_key_exists('id',$data)){
            $ticketGoods = TicketGoods::find($data['id']);
        }
        $admin = $request->session()->get('admin');
        $upload_token = QNManager::uploadToken();
        return view('admin.ticket.edit',['admin' => $admin,'data' => $ticketGoods,'upload_token' => $upload_token]);
    }

    //抢票管理添加、编辑-post
    public function editPost(Request $request){
        $data = $request->all();
        $return = null;
        $ticketGoods = new TicketGoods();
        if(array_key_exists('id',$data) && !Utils::isObjNull($data['id'])){
            $ticketGoods = TicketGoods::find($data['id']);
        }
        if(!$ticketGoods){
            $ticketGoods = new TicketGoods();
        }
        $ticketGoods = TicketGoodsManager::setTicketGoods($ticketGoods,$data);
        $result = $ticketGoods -> save();
        if($result){
            $return['result'] = true;
            $return['msg'] = '添加成功';
        }else{
            $return['result'] = false;
            $return['mag'] = '添加失败';
        }
        return $return;
    }

    //抢票管理删除
    public function del(Request $request,$id){
        if(is_numeric($id) !== true){
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '合规校验失败，请检查参数积分商品id$id']);
        }
        $return = null;
        $ticketGoods = TicketGoods::find($id);
        $result = $ticketGoods->delete();
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






