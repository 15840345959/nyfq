@extends('admin.layouts.app')

@section('content')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 旅行社管理 <span class="c-gray en">&gt;</span>{{$organization['name']}}管理员列表 <a class="btn btn-success radius btn-refresh r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" onclick="location.replace('{{URL::asset('/admin/organization/admin')}}?organization_id={{$organization_id}}');" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="text-c">
        <form action="{{URL::asset('/admin/organization/adminSearch')}}" method="get" class="form-horizontal">
            {{csrf_field()}}
            <input id="organization_id" name="organization_id" type="hidden" value="{{$organization_id}}">
            <input id="search" name="search" type="text" class="input-text" style="width:450px" placeholder="旅行社管理员名称/电话">
            <button type="submit" class="btn btn-success" id="" name="">
                <i class="Hui-iconfont">&#xe665;</i> 搜索
            </button>
        </form>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <a class="btn btn-primary radius" onclick="organizationAdmin_edit('添加旅行社管理员','{{URL::asset('/admin/organization/editAdmin')}}?organization_id={{$organization_id}}')" href="javascript:;">
                <i class="Hui-iconfont">&#xe600;</i> 添加旅行社管理员
            </a>
            <a href="javascript:void(0)" onclick="layer_close()">
                <input class="btn btn-primary-outline radius" type="button" value="返回">
            </a>
        </span>
        {{--<span class="r">共有数据：<strong>{{count($datas)}}</strong> 条</span> --}}
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort" id="table-sort">
            <thead>
            <tr class="text-c">
                <th width="80">ID</th>
                <th>头像</th>
                <th>旅行社管理员</th>
                <th>电话</th>
                <th width="150">更新时间</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($datas as $data)
                <tr class="text-c">
                    <td>{{$data['id']}}</td>
                    <td>
                        <img src="{{ $data['avatar'] ? $data['avatar'].'?imageView2/1/w/200/h/200/interlace/1/q/75|imageslim' : URL::asset('/img/default_headicon.png')}}"
                             class="img-rect-30 radius-5">
                    </td>
                    <td class="text-l">{{$data['nick_name']}}</td>
                    @if($data['telephone'])
                        <td>{{$data['telephone']}}</td>
                    @else
                        <td>暂未设置</td>
                    @endif
                    <td>{{$data['updated_at']}}</td>
                    <td class="td-manage">
                        <a title="移除旅行社管理员" href="javascript:;" onclick="organizationAdmin_del(this,'{{$data['id']}}')" class="ml-5" style="text-decoration:none">
                            <input class="btn btn-danger radius" type="button" value="移除">
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
    $('.table-sort').dataTable({
        "aaSorting": [[ 1, "desc" ]],//默认第几个排序
        "bStateSave": true,//状态保存
        "pading":false,
        "searching" : false, //去掉搜索框
        "bLengthChange": false,   //去掉每页显示多少条数据方法
        "aoColumnDefs": [
            //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
            {"orderable":false,"aTargets":[0,5]}// 不参与排序的列
        ]
    });

    /*旅行社管理员-添加或编辑*/
    function organizationAdmin_edit(title, url, organization_id) {
        console.log("organizationAdmin_edit url:" + url);
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }

    /*旅行社管理员-删除*/
    function organizationAdmin_del(obj,id){
        layer.confirm('确认要移除旅行社管理员吗？',function(index){
            //进行后台删除
            var param = {
                id: id,
                _token: "{{ csrf_token() }}"
            }
            delOrganizationAdmin('{{URL::asset('')}}', param, function (ret) {
                if (ret.result == true) {
                    $(obj).parents("tr").remove();
                    layer.msg(ret.msg, {icon: 1, time: 1000});
                } else {
                    layer.msg(ret.msg, {icon: 2, time: 1000})
                }
            })
        });
    }


</script>
@endsection