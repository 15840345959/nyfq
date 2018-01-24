<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/24
 * Time: 10:02
 */

namespace App\Http\Controllers\Admin;

use App\Components\CommentManager;
use App\Models\Comment;
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
    //删除
    public function del(Request $request, $id)
    {
        if (is_numeric($id) !== true) {
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '合规校验失败，请检查参数管理员id$id']);
        }
        $comment = Comment::find($id);
        $return=null;
        $result=$comment->delete();
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
    //审核评论
    public function examine(Request $request)
    {
        $data = $request->all();
        if(array_key_exists('id',$data)){
            $admin = $request->session()->get('admin');
            $return=null;
            $comment = CommentManager::examineCommentStatus($data);
            if($comment){
                $return['result']=true;
                $return['msg']='审核状态修改成功';
            }
            else{
                $return['result']=false;
                $return['msg']='审核状态修改失败';
            }
            return $return;
        }
        else{
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '非法访问']);
        }
    }
}