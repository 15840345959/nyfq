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
        $param=array(
            'msg'=>'',
        );
        return view('admin.login.login',$param);
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

        $admin = AdminManager::login($telephone);
        //登录失败
        if ($admin == null) {
            return view('admin.login.login', ['msg' => '手机号错误']);
        }
        else{
            if($password!=$admin['password']){
                return view('admin.login.login', ['msg' => '密码错误']);
            }
            else{
                unset($admin['password']);
            }
        }
        $request->session()->put('admin', $admin);//写入session
//        var_dump($request->session()->get('admin'));
        return redirect('/admin/index');//跳转至后台首页
    }

    //退出登录
    public function loginout(Request $request){
        $request->session()->forget('admin');
        $request->session()->flush();
        return redirect('/admin/login');//跳转至后台首页
    }
}