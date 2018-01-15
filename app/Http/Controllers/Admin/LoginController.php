<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/10
 * Time: 14:18
 */

namespace App\Http\Controllers\Admin;
use App\Components\AdminManager;
use Illuminate\Http\Request;
use App\Components\RequestValidator;


class LoginController
{
    //首页
    public function Login(Request $request)
    {
        $msg="";
        return view('admin.login.login',['msg' => $msg]);
    }

    //登录验证
    public function LoginDo(Request $request){
        $data = $request->all();
//        var_dump($data);
        //参数校验
        $requestValidationResult = RequestValidator::validator($request->all(), [
            'telephone' => 'required',
            'password' => 'required',
        ]);
        if ($requestValidationResult !== true) {
            return view('admin.login.login', '请输入手机号和密码');
        }
        $telephone = $data['telephone'];
        $password = $data['password'];
        $remember_token = $data['_token'];

        $admin = AdminManager::login($telephone,$password,$remember_token);
        //登录失败
        if ($admin == null) {
            return view('admin.login.login', ['msg' => '手机号或密码错误']);
        }
        $request->session()->put('admin', $admin);//写入session
        return redirect('/admin/index');//跳转至后台首页
    }
}