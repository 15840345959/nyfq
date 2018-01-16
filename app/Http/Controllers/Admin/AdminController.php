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
use App\Models\AD;
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
        $admin = $request->session()->get('admin');
        var_dump($admin);
//        $admins = UserManager::getAlladminByName();
//        return view('admin.admin.index', ['admin' => $admin, 'datas' => $admins]);
    }


    //删除管理员
    public function del(Request $request, $id)
    {
        if (is_numeric($id) !== true) {
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '合规校验失败，请检查参数管理员id$id']);
        }
        $admin = Admin::find($id);
        //非根管理员
        if (!($admin->role == '0')) {
            $admin->delete();
        }
        return redirect('/admin/admin/index');
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
        if (!($user->type == '2')&&!($user->admin == '1')) {
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '合规校验失败，只有管理员有修改权限']);
        }

//        //生成七牛token
//        $upload_token = QNManager::uploadToken();
        $param=array(
            'admin'=>$admin,
            'data'=>$user
        );
        return view('admin.admin.edit', $param);
    }

    //新建或编辑管理员->post
    public function editPost(Request $request)
    {
        $data = $request->all();
        //专门处理role
        if (array_key_exists('role', $data)) {
            $data['role'] = '0';
        }
        $admin = new Admin();
        //存在id是保存
        if (array_key_exists('id', $data)) {
            $admin = Admin::find($data['id']);
        }
        $admin = AdminManager::setAdmin($admin, $data);
        //如果不存在id代表新建，则默认设置密码
        if (!array_key_exists('id', $data)) {
            $admin->password = 'afdd0b4ad2ec172c586e2150770fbf9e';  //该password为Aa123456的码
        }
        $admin->save();
        return redirect('/admin/admin/index');
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
//        var_dump($data);
        $admin=UserManager::getUserInfoById($data['id']);
        $admin = AdminManager::setAdmin($admin, $data);
        $result=$admin->save();
        if($result){
            $user['nick_name']=$admin['nick_name'];
            $user['avatar']=$admin['avatar'];
            $user['id']=$admin['id'];
            $user['remember_token']=$admin['remember_token'];
            $request->session()->put('admin', $user);//写入session
            return redirect('/admin/admin/editMySelf')->with('success','修改成功');
        }
        else{
            return redirect('/admin/admin/editMySelf')->with('error','修改失败');
        }
//            $param=array(
//                'data'=>$admin
//            );
//        return view('admin.admin.editMySelf', $param);
    }

}