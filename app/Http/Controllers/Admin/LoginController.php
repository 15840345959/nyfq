<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/10
 * Time: 14:18
 */

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;


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
        var_dump($data);
    }
}