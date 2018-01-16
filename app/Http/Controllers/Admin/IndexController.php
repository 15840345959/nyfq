<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/13
 * Time: 17:00
 */

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Components\RequestValidator;

class IndexController
{
    //首页
    public function index(Request $request)
    {
        $admin = $request->session()->get('admin');
        $data=array(
            'admin'=>$admin
        );
        return view('admin.index.index', $data);
    }
    //错误页面
    public function error(Request $request)
    {
        $data = $request->all();
        return view('admin.index.error500', $data);
    }
    //欢迎页
    public function welcome(Request $request)
    {
        return view('admin.index.welcome');
    }
}