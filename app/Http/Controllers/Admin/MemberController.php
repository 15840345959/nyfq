<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/23
 * Time: 16:04
 */

namespace App\Http\Controllers\Admin;

use App\Components\OrganizationManager;
use App\Components\UserManager;
use App\Models\Organization;
use App\User;
use Illuminate\Http\Request;

class MemberController
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
        if(array_key_exists('organization_id',$data)){
            $organization_id=$data['organization_id'];
        }
        else{
            $organization_id='';
        }
        $users = UserManager::getAllMembersByName($search,$organization_id);
        $organizations=OrganizationManager::getAllOrganizationLists('');
        $param=array(
            'admin'=>$admin,
            'datas'=>$users,
            'organizations'=>$organizations
        );
        return view('admin.member.index', $param);
    }

    //查看会员详情
    public function edit(Request $request){
        $data = $request->all();
        $admin = $request->session()->get('admin');
        $member=UserManager::getUserInfoById($data['id']);
        $member['organization']=Organization::find($member['organization_id']);
        $member['share']=UserManager::getUserInfoById($member['share_user']);
        $param=array(
            'admin'=>$admin,
            'data'=>$member,
        );
        return view('admin.member.edit', $param);
    }
}