<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/19
 * Time: 14:35
 */

namespace App\Http\Controllers\Admin;

use App\Components\BannerManager;
use Illuminate\Http\Request;

class BannerController
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
        $datas = BannerManager::getAllBannerLists($search);
        $param=array(
            'admin'=>$admin,
            'datas'=>$datas
        );
        return view('admin.banner.index', $param);
    }
}