<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/2
 * Time: 11:16
 */

namespace App\Http\Controllers\Admin;


class TestController
{
    public function index(){
        return view('admin.test.index');
    }
}