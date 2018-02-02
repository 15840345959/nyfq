@extends('admin.layouts.app')

@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 订单管理 <span
                class="c-gray en">&gt;</span>订单列表 <a class="btn btn-success radius btn-refresh r"
                                                     style="line-height:1.6em;margin-top:3px"
                                                     href="javascript:location.replace(location.href);"
                                                     onclick="location.replace('{{URL::asset('/admin/orders/index')}}');"
                                                     title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
        <div class="mt-20">
            <table class="table table-border table-bordered table-bg table-hover table-sort" id="table-sort">
                <thead>
                <tr class="text-c">
                    <th width="80">ID</th>
                    <th width="150">商品</th>
                    <th>类型</th>
                    <th width ="150">出行时间</th>
                    <th>价格</th>
                    <th width="150">订单状态</th>
                    <th width="150">更新时间</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $data)
                    <tr class="text-c">
                        <td>{{$data['id']}}</td>
                        <td>{{$data['tour_goods']->name}}</td>
                        @if($data['goods_type'] == 1)
                            <td>旅游产品</td>
                        @endif
                        <td>{{$data['start_time']}}</td>
                        <td>{{$data['price']}}</td>
                        @if($data['status'] === 1)
                            <th width="150">
                                <span class="label label-success radius">已下单</span>
                            </th>
                        @elseif($data['status'] === 2)
                            <th width="150">
                                <span class="label label-danger radius">已出行</span>
                            </th>
                        @endif
                        <td>{{$data['updated_at']}}</td>
                        <td class="td-manage">
                            <a title="查看详情" href="javascript:;"
                               onclick="comment_edit('查看详情','{{URL::asset('/admin/comment/edit')}}?id={{$data['id']}}',{{$data['id']}})"
                               class="ml-5" style="text-decoration:none">
                                <i class="Hui-iconfont">&#xe695;</i>
                            </a>
                            <a title="删除" href="javascript:;" onclick="comment_del(this,'{{$data['id']}}')" class="ml-5"
                               style="text-decoration:none">
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
            "aaSorting": [[1, "desc"]],//默认第几个排序
            "bStateSave": true,//状态保存
            "pading": false,
            "searching": false, //去掉搜索框
            "bLengthChange": false,   //去掉每页显示多少条数据方法
            "aoColumnDefs": [
                //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                {"orderable": false, "aTargets": [0, 1, 6]}// 不参与排序的列
            ]
        });

        /*查看评价详情*/
        function comment_edit(title, url, id) {
            // console.log("comment_edit url:" + url);
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }

        /*评价-删除*/
        function comment_del(obj, id) {
            layer.confirm('确认要删除吗？', function (index) {
                //进行后台删除
                var param = {
                    id: id,
                    _token: "{{ csrf_token() }}"
                }
                delComment('{{URL::asset('')}}', param, function (ret) {
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