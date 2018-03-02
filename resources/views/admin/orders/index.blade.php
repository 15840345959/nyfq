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
                    <th width="150">商品</th>
                    <th>类型</th>
                    <th width="150">出行时间</th>
                    <th>价格</th>
                    <th width="150">订单状态</th>
                    <th width="150">数量</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $data)
                    <tr class="text-c">
                        @if($data['goods_type'] == 1)
                            <td>{{$data['tourGoods']['name']}}</td>
                        @elseif($data['goods_type'] == 2)
                            <td>{{$data['planGoods']['company']}}</td>
                        @elseif($data['goods_type'] == 3)
                            <td>{{$data['hotelGoods']['name']}}</td>
                        @elseif($data['goods_type'] == 4)
                            <td>{{$data['carGoods']['name']}}</td>
                        @endif
                        @if($data['goods_type'] == 1)
                            <td>旅游产品</td>
                        @elseif($data['goods_type'] == 2)
                            <td>飞机票产品</td>
                        @elseif($data['goods_type'] == 3)
                            <td>酒店产品</td>
                        @elseif($data['goods_type'] == 4)
                            <td>车导产品</td>
                        @endif
                        <td>{{$data['start_time']}}</td>
                        <td>{{$data['price']}}</td>
                        @if($data['status'] === 0)
                            <th width="150">
                                <span class="label label-success radius">已下单</span>
                            </th>
                        @elseif($data['status'] === 1)
                            <th width="150">
                                <span class="label label-danger radius">服务完毕</span>
                            </th>
                        @endif
                        <td>{{$data['count']}}</td>
                        <td class="td-manage">
                            <a title="查看详情" href="javascript:;"
                               onclick="order_edit('查看详情','{{URL::asset('/admin/orders/orderDetails')}}?id={{$data['id']}}',{{$data['id']}})"
                               class="ml-5" style="text-decoration:none">
                                <i class="Hui-iconfont">&#xe695;</i>
                            </a>
                            @if($data->status=="0")
                                <a style="text-decoration:none" onClick="send_order(this,'{{$data->id}}')"
                                   href="javascript:;">
                                    <span class="label label-success radius">设置订单状态</span>
                                </a>
                            @elseif($data->status=="1")
                                <span class="label label-danger radius">订单已服务完毕</span>
                            @endif
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
            "aaSorting": [[0, "desc"]],//默认第几个排序
            "bStateSave": true,//状态保存
            "pading": false,
            "searching": false, //去掉搜索框
            "bLengthChange": false,   //去掉每页显示多少条数据方法
            "aoColumnDefs": [
                //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                {"orderable": false, "aTargets": [1,2,6]}// 不参与排序的列
            ]
        });

        /*查看订单详情*/
        function order_edit(title, url, id) {
            // console.log("comment_edit url:" + url);
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }

        /*设置订单状态*/
        function send_order(obj, id) {
            console.log("send_order id:" + id);
            layer.confirm('确定订单已服务完毕吗？', function (index) {
                    //此处请求后台程序，下方是成功后的前台处理
                    var param = {
                        id: id,
                        status:1,
                        _token: "{{ csrf_token() }}"
                    }
                    //从后台添加物流单号
                    setStatus('{{URL::asset('')}}', param, function (ret) {
                        if (ret.status == 1) {
                            layer.msg('成功设置订单状态', {icon: 1, time: 1000});
                            window.location.reload();
                        }
                    })
                    window.location.reload();
                    layer.msg('已设置订单状态', {icon: 6, time: 1000});
                });
        }



    </script>
@endsection