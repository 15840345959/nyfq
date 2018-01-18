<?php
/**
 * 首页控制器
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/20 0020
 * Time: 20:15
 */

namespace App\Http\Controllers\Admin;

use App\Components\AdminManager;
use App\Components\UserManager;
use App\Http\Controllers\ApiResponse;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use App\Libs\ServerUtils;
use App\Components\RequestValidator;
use Illuminate\Support\Facades\Redirect;


class AdminController
{
    //首页
    public function index(Request $request)
    {
        $data = $request->all();
        $admin = $request->session()->get('admin');
        if(array_key_exists('search',$data)){
            $search=$data['search'];
        }
        else{
            $search='';
        }
        $admins = UserManager::getAlladminByName($search);
        $param=array(
            'admin'=>$admin,
            'datas'=>$admins
        );
        return view('admin.admin.index', $param);
    }


    //删除管理员
    public function del(Request $request, $id)
    {
        if (is_numeric($id) !== true) {
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '合规校验失败，请检查参数管理员id$id']);
        }
        $user = User::find($id);
        $return=null;
        //非根管理员
        if ($user['admin'] == '0') {
            $result=$user->delete();
            if($result){
                $return['result']=true;
                $return['msg']='删除成功';
            }
            else{
                $return['result']=false;
                $return['msg']='删除失败，高级管理员无法删除';
            }
        }
        else{
            $return['result']=false;
            $return['msg']='删除失败';
        }
        return $return;
    }


    //新建或编辑管理员-get
    public function edit(Request $request)
    {
        $data = $request->all();
        $user = new User();
        if (array_key_exists('id', $data)) {
            $user = UserManager::getUserInfoById($data['id']);
        }
        $admin = $request->session()->get('admin');
        //只有根管理员有修改权限
        if (($admin['type'] == '2')&&($admin['admin'] == '1')) {
//        //生成七牛token
//        $upload_token = QNManager::uploadToken();
            $param=array(
                'admin'=>$admin,
                'data'=>$user
            );
            return view('admin.admin.edit', $param);
        }
        else{
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '合规校验失败，只有管理员有修改权限']);
        }
    }
    public function editDo(Request $request)
    {
        $data = $request->all();
//        var_dump($data);
        $return=null;
        //存在id是保存
        if (empty($data['id'])) {
            $user = new User();
            //如果不存在id代表新建，则默认设置密码
            $data['password']='afdd0b4ad2ec172c586e2150770fbf9e';  //Aa123456
            $data['type']=2;
            //查询电话号码是否唯一
            $admin_chenck=UserManager::getUserInfoByTel($data['telephone']);
            if($admin_chenck){
                $return['result']=false;
                $return['msg']='添加管理员失败,此电话号码已被注册';
            }
            else{
                $user = AdminManager::setAdmin($user, $data);
                $result=$user->save();
                if($result){
                    $return['result']=true;
                    $return['msg']='添加管理员成功';
                }
                else{
                    $return['result']=false;
                    $return['msg']='添加管理员失败';
                }
            }
        }
        else{
            $user = UserManager::getUserInfoById($data['id']);
            //查询电话号码是否唯一
            $result=AdminManager::getAdminByTel($data['telephone']);
            if($data['telephone']!=$user['telephone']&&$result){
                $return['result']=false;
                $return['msg']='编辑管理员失败,此电话号码已被注册';
            }
            else{
                $user = AdminManager::setAdmin($user, $data);
                $result=$user->save();
                if($result){
                    $return['result']=true;
                    $return['msg']='编辑管理员成功';
                }
                else{
                    $return['result']=false;
                    $return['msg']='编辑管理员失败';
                }
            }
        }
        $admin = $request->session()->get('admin');
        $param=array(
            'return'=>$return,
            'data'=>$data,
            'admin'=>$admin
        );
        return view('admin.admin.edit',$param);
    }

    //新建或编辑自己的信息-get
    public function editMySelf(Request $request)
    {
        $admin = $request->session()->get('admin');
        $user = UserManager::getUserInfoById($admin['id']);
        $param=array(
            'data'=>$user
        );
        return view('admin.admin.editMySelf', $param);
    }

    //新建或编辑自己的信息-post
    public function editMySelfPost(Request $request)
    {
        $data = $request->all();
        if(empty($data['password'])){
            $admin=UserManager::getUserInfoById($data['id']);
            unset($data['password']);
            unset($data['new_password']);
            unset($data['confirm_password']);
            //查询电话号码是否唯一
            if($data['telephone']!=$admin['telephone']){
                $result=AdminManager::getAdminByTel($admin['telephone']);
                if($result){
                    return redirect('/admin/admin/editMySelf')->with('error','个人基本信息修改失败,此电话号码已被注册');
                }
            }
            $admin = AdminManager::setAdmin($admin, $data);
            $result=$admin->save();
            if($result){
                $user['nick_name']=$admin['nick_name'];
                $user['avatar']=$admin['avatar'];
                $user['id']=$admin['id'];
                $user['remember_token']=$admin['remember_token'];
                $user['type']=$admin['type'];
                $user['admin']=$admin['admin'];
                $request->session()->put('admin', $user);//写入session
                return redirect('/admin/admin/editMySelf')->with('success','个人基本信息修改成功');
            }
            else{
                return redirect('/admin/admin/editMySelf')->with('error','个人基本信息修改失败');
            }
        }
        else{
            $admin=UserManager::getUserInfoByIdWithToken($data['id']);
            unset($data['nick_name']);
            unset($data['telephone']);
            if($data['password']!= $admin['password']){
                return redirect('/admin/admin/editMySelf')->with('error','密码修改失败，原密码输入错误');
            }
            else{
                $data['password']=$data['new_password'];
                unset($data['new_password']);
                unset($data['confirm_password']);
                $admin = AdminManager::setAdmin($admin, $data);
                $result=$admin->save();
                if($result){
                    return redirect('/admin/admin/editMySelf')->with('success','密码修改成功');
                }
                else{
                    return redirect('/admin/admin/editMySelf')->with('error','密码修改失败');
                }
            }
        }

    }
}