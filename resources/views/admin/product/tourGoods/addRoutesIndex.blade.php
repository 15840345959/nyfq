@extends('admin.layouts.app')

@section('content')

    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 旅游产品管理 <span
                class="c-gray en">&gt;</span> 旅游产品线路列表 <a class="btn btn-success radius r btn-refresh"
                                                       style="line-height:1.6em;margin-top:3px"
                                                       href="javascript:location.replace(location.href);" title="刷新"
                                                       onclick="location.replace('{{URL::asset('/admin/product/tourGoods/addRoutesIndex')}}');"><i
                    class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                 <a href="javascript:;" onclick="tourCategories_add('添加旅游产品路线','{{URL::asset('/admin/product/tourGoods/editRoutes')}}')"
                    class="btn btn-primary radius">
                     <i class="Hui-iconfont">&#xe600;</i> 添加旅游产品路线
                 </a>
            </span>
        </div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-bg table-sort" id="table-sort">
            <thead>
            <tr class="text-c">
                <th width="40">旅游产品名称</th>
                <th width="100">线路名称(第几天)</th>
                <th width="140">出发线路</th>
                <th width="50">内容</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($datas as $data)
                <tr class="text-c">
                    <td>{{$data['tourGoods']['name']}}</td>
                    <td>{{$data['name']}}</td>
                    <td>{{$data['place']}}</td>
                    <td>{{$data['content']}}</td>
                    <td class="td-manage">
                        <a title="编辑" href="javascript:;" onclick="tourCategories_edit('旅游产品路线编辑','{{URL::asset('/admin/product/tourGoods/editRoutes')}}?id={{$data['id']}}',{{$data['id']}})"  class="ml-5" style="text-decoration:none">
                            <i class="Hui-iconfont">&#xe6df;</i>
                        </a>
                        <a title="删除" href="javascript:;" onclick="tourCategories_del(this,'{{$data['id']}}')" class="ml-5" style="text-decoration:none">
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
        $('.table-sort').dataTable({
            "aaSorting": [[ 0, "desc" ]],//默认第几个排序
            "bStateSave": true,//状态保存
            "pading":false,
            "searching" : false, //去掉搜索框
            "bLengthChange": false,   //去掉每页显示多少条数据方法
            "aoColumnDefs": [
                //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                {"orderable":false,"aTargets":[4]}// 不参与排序的列
            ]
        });

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
        /*旅游产品路线-增加*/
        function tourCategories_add(title, url) {
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }
        /*旅游产品路线-删除*/
        function tourCategories_del(obj, id) {
            layer.confirm('确认要删除吗？', function (index) {
                //进行后台删除
                var param = {
                    id: id,
                    _token: "{{ csrf_token() }}"
                }
                delTourCategories('{{URL::asset('')}}', param, function (ret) {
                    if (ret.result == true) {
                        $(obj).parents("tr").remove();
                        layer.msg(ret.msg, {icon: 1, time: 1000});
                    } else {
                        layer.msg(ret.msg, {icon: 2, time: 1000})
                    }
                })
            });
        }

        /*旅游产品路线-编辑*/
        function tourCategories_edit(title, url, id) {
            console.log("admin_edit url:" + url);
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }


    </script>
@endsection