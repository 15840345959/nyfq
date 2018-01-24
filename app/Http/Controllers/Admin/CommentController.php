<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/24
 * Time: 10:02
 */

namespace App\Http\Controllers\Admin;

use App\Components\CommentManager;
use Illuminate\Http\Request;

class CommentController
{
    //首页
    public function index(Request $request)
    {
        $data = $request->all();
        $admin = $request->session()->get('admin');
        if(!array_key_exists('search',$data)){
            $data['search']="";
        }
        $comments = CommentManager::getAllCommentLists($data);
        $param=array(
            'admin'=>$admin,
            'datas'=>$comments
        );
        return view('admin.comment.index', $param);
    }
    //查看评论详情
    public function edit(Request $request)
    {
        $data = $request->all();
        if(array_key_exists('id',$data)){
            $admin = $request->session()->get('admin');
            $comment = CommentManager::getAllCommentDetailById($data);
            $param=array(
                'admin'=>$admin,
                'data'=>$comment
            );
            return view('admin.comment.edit', $param);
        }
        else{
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '非法访问']);
        }
    }
}