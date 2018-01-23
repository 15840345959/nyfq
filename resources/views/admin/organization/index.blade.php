@extends('admin.layouts.app')

@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 旅行社管理 <span
                class="c-gray en">&gt;</span> 旅行社列表 <a class="btn btn-success radius r btn-refresh"
                                                       style="line-height:1.6em;margin-top:3px"
                                                       href="javascript:location.replace(location.href);" title="刷新"
                                                       onclick="location.replace('{{URL::asset('/admin/organization/index')}}');">
            <i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="text-c">
        <form action="{{URL::asset('/admin/organization/index')}}" method="post" class="form-horizontal">
            {{csrf_field()}}
            <input id="search" name="search" type="text" class="input-text" style="width:450px" placeholder="旅行社名称">
            <button type="submit" class="btn btn-success" id="" name="">
                <i class="Hui-iconfont">&#xe665;</i> 搜索
            </button>
        </form>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <a class="btn btn-primary radius" onclick="organization_edit('添加旅行社','{{URL::asset('/admin/organization/edit')}}')" href="javascript:;">
                <i class="Hui-iconfont">&#xe600;</i> 添加旅行社
            </a>
        </span>
        <span class="r">共有数据：<strong>{{count($datas)}}</strong> 条</span> </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort" id="table-sort">
            <thead>
            <tr class="text-c">
                <th width="80">ID</th>
                <th>旅行社名称</th>
                <th>地址</th>
                <th width="150">更新时间</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($datas as $data)
                <tr class="text-c">
                    <td>{{$data['id']}}</td>
                    <td class="text-l">{{$data['name']}}</td>
                    <td class="text-l">{{$data['address']}}</td>
                    <td>{{$data['updated_at']}}</td>
                    <td class="td-manage">
                        <a title="管理员管理" href="javascript:;" onclick="organization_admin('管理员管理','{{URL::asset('/admin/organization/admin')}}?organization_id={{$data['id']}}')" class="ml-5" style="text-decoration:none">
                            <i class="Hui-iconfont">&#xe62c;</i>
                        </a>
                        <a title="编辑" href="javascript:;" onclick="organization_edit('旅行社编辑','{{URL::asset('/admin/organization/edit')}}?id={{$data['id']}}',{{$data['id']}})" class="ml-5" style="text-decoration:none">
                            <i class="Hui-iconfont">&#xe6df;</i>
                        </a>
                        <a title="删除" href="javascript:;" onclick="organization_del(this,'{{$data['id']}}')" class="ml-5" style="text-decoration:none">
                            <i class="Hui-iconfont">&#xe6e2;</i>
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
    /*旅行社-管理员管理*/
    function organization_admin(title, url, id) {
        // console.log("organization_admin url:" + url);
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }

    /*旅行社-添加或编辑*/
    function organization_edit(title, url, id) {
        // console.log("organization_edit url:" + url);
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }

    /*旅行社-删除*/
    function organization_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            //进行后台删除
            var param = {
                id: id,
                _token: "{{ csrf_token() }}"
            }
            delOrganization('{{URL::asset('')}}', param, function (ret) {
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