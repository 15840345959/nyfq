<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/22
 * Time: 17:38
 */

namespace App\Http\Controllers\Admin;

use App\Components\OrganizationManager;
use App\Components\UserManager;
use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController
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
        $datas = OrganizationManager::getAllOrganizationLists($search);
        $param=array(
            'admin'=>$admin,
            'datas'=>$datas
        );
        return view('admin.organization.index', $param);
    }
    //删除
    public function del(Request $request, $id)
    {
        if (is_numeric($id) !== true) {
            return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '合规校验失败，请检查参数管理员id$id']);
        }
        $organization = Organization::find($id);
        $return=null;
        $result=$organization->delete();
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
    //新建或编辑旅行社
    public function edit(Request $request){
        $data = $request->all();
        $admin = $request->session()->get('admin');
        if (array_key_exists('id', $data)) {
            $organization = OrganizationManager::getOrganizationById($data['id']);
        }
        else{
            $organization = new Organization();
        }
        $param=array(
            'admin'=>$admin,
            'data'=>$organization
        );
        return view('admin.organization.edit', $param);
    }
    //新建或编辑旅行社执行
    public function editDo(Request $request){
        $data = $request->all();
        $admin = $request->session()->get('admin');
        $return=null;
        if(empty($data['id'])){
            $organization=new Organization();
        }
        else{
            $organization = OrganizationManager::getOrganizationById($data['id']);
        }
        $organization = OrganizationManager::setOrganization($organization,$data);
        $result=$organization->save();

        if($result){
            $return['result']=true;
            $return['msg']='编辑旅行社成功';
        }
        else{
            $return['result']=false;
            $return['msg']='编辑旅行社失败';
        }
        return $return;
    }
    //首页
    public function admin(Request $request)
    {
        $data = $request->all();
        $admin = $request->session()->get('admin');
        if(array_key_exists('search',$data)){
            $search=$data['search'];
        }
        else{
            $search='';
        }
        $datas = UserManager::getAllOrganizationAdminByName($search,$data['organization_id']);
        $param=array(
            'admin'=>$admin,
            'datas'=>$datas
        );
        return view('admin.organization.index', $param);
    }
}