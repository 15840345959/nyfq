@extends('admin.layouts.app')

@section('content')

    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span
                class="c-gray en">&gt;</span> 管理员列表 <a class="btn btn-success radius r btn-refresh"
                                                       style="line-height:1.6em;margin-top:3px"
                                                       href="javascript:location.replace(location.href);" title="刷新"
                                                       onclick="location.replace('{{URL::asset('/admin/admin/index')}}');"><i
                    class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
        <div class="text-c">
            <form action="{{URL::asset('/admin/admin/index')}}" method="post" class="form-horizontal">
                {{csrf_field()}}
                <input id="search" name="search" type="text" class="input-text" style="width:450px"
                       placeholder="管理员名称\手机号码">
                <button type="submit" class="btn btn-success" id="" name="">
                    <i class="Hui-iconfont">&#xe665;</i> 搜索
                </button>
            </form>
        </div>
        @if($admin['admin']==1)
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                 <a href="javascript:;" onclick="admin_add('添加管理员','{{URL::asset('/admin/admin/edit')}}')"
                    class="btn btn-primary radius">
                     <i class="Hui-iconfont">&#xe600;</i> 添加管理员
                 </a>
            </span>
            <span class="r">共有数据：<strong>{{$datas->count()}}</strong> 条</span>
        </div>
        @endif
        <table class="table table-border table-bordered table-bg">
            <thead>
            <tr>
                <th scope="col" colspan="9">管理员列表</th>
            </tr>
            <tr class="text-c">
                <th width="40">ID</th>
                {{--<th width="50">头像</th>--}}
                <th width="150">名称</th>
                <th width="90">手机</th>
                <th width="50">角色</th>
                <th width="130">加入时间</th>
                @if($admin['admin']==1)
                <th width="100">操作</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($datas as $data)
                <tr class="text-c">
                    <td>{{$data['id']}}</td>
                    {{--<td>--}}
                        {{--<img src="{{ $data['avatar'] ? $data['avatar'].'?imageView2/1/w/200/h/200/interlace/1/q/75|imageslim' : URL::asset('/img/default_headicon.png')}}"--}}
                             {{--class="img-rect-30 radius-5">--}}
                    {{--</td>--}}
                    <td>{{$data['nick_name']}}</td>
                    <td>{{$data['telephone']}}</td>
                    <td>{{$data->admin == "0" ? "普通管理员" : "超级管理员"}}</td>
                    <td>{{$data->created_at}}</td>
                    @if($admin['admin']==1)
                    <td class="td-manage">
                        <a title="编辑" href="javascript:;" onclick="admin_edit('管理员编辑','{{URL::asset('/admin/admin/edit')}}?id={{$data['id']}}',{{$data['id']}})"  class="ml-5" style="text-decoration:none">
                            <i class="Hui-iconfont">&#xe6df;</i>
                        </a>
                        @if($data['admin']==0)
                            <a title="删除" href="javascript:;" onclick="admin_del(this,'{{$data['id']}}')" class="ml-5" style="text-decoration:none">
                                <i class="Hui-iconfont">&#xe6e2;</i>
                            </a>
                        @else
                            <span class="ml-5">
                                <i class="Hui-iconfont no_click">&#xe6e2;</i>
                            </span>
                        @endif
                    </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection

@section('script')
    <script type="text/javascript">

        $(function () {

        });

        /*
         参数解释：
         title	标题
         url		请求的url
         id		需要操作的数据id
         w		弹出层宽度（缺省调默认值）
         h		弹出层高度（缺省调默认值）
         */
        /*管理员-增加*/
        function admin_add(title, url) {
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }
        /*管理员-删除*/
        function admin_del(obj, id) {
            layer.confirm('确认要删除吗？', function (index) {
                //进行后台删除
                var param = {
                    id: id,
                    _token: "{{ csrf_token() }}"
                }
                delAdmin('{{URL::asset('')}}', param, function (ret) {
                    if (ret.result == true) {
                        $(obj).parents("tr").remove();
                        layer.msg(ret.msg, {icon: 1, time: 1000});
                    } else {
                        layer.msg(ret.msg, {icon: 2, time: 1000})
                    }
                })
            });
        }

        /*管理员-编辑*/
        function admin_edit(title, url, id) {
            console.log("admin_edit url:" + url);
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }
        /*管理员-停用*/
        function admin_stop(obj, id) {
            console.log("admin_stop id:" + id);
            layer.confirm('确认要停用吗？', function (index) {
                //此处请求后台程序，下方是成功后的前台处理
                var param = {
                    id: id,
                    status: 0,
                    _token: "{{ csrf_token() }}"
                }
                //从后台设置管理员状态
                setAdminStatus('{{URL::asset('')}}', param, function (ret) {
                    if (ret.status == true) {

                    }
                })
                $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_start(this,' + id + ')" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>');
                $(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">已禁用</span>');
                $(obj).remove();
                layer.msg('已停用', {icon: 5, time: 1000});
            });
        }

        /*管理员-启用*/
        function admin_start(obj, id) {
            layer.confirm('确认要启用吗？', function (index) {
                //此处请求后台程序，下方是成功后的前台处理
                var param = {
                    id: id,
                    status: 1,
                    _token: "{{ csrf_token() }}"
                }
                //从后台设置管理员状态
                setAdminStatus('{{URL::asset('')}}', param, function (ret) {
                    if (ret.status == true) {

                    }
                })
                $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_stop(this,' + id + ')" href="javascript:;" title="停用" style="text-decoration:none"><i class="Hui-iconfont">&#xe631;</i></a>');
                $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
                $(obj).remove();
                layer.msg('已启用', {icon: 6, time: 1000});
            });
        }

    </script>
@endsection