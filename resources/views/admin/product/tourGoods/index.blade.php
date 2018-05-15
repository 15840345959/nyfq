@extends('admin.layouts.app')

@section('content')

    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 旅游产品管理 <span
                class="c-gray en">&gt;</span> 旅游产品列表 <a class="btn btn-success radius r btn-refresh"
                                                       style="line-height:1.6em;margin-top:3px"
                                                       href="javascript:location.replace(location.href);" title="刷新"
                                                       onclick="location.replace('{{URL::asset('/admin/product/tourGoods/index')}}');"><i
                    class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
        <div class="text-c">
            <form action="{{URL::asset('/admin/product/tourGoods/index')}}" method="post" class="form-horizontal">
                {{csrf_field()}}
                <input id="search_word" name="search_word" type="text" class="input-text" style="width:450px"
                       placeholder="旅游产品名称">
                <button type="submit" class="btn btn-success" id="" name="">
                    <i class="Hui-iconfont">&#xe665;</i> 搜索
                </button>
            </form>
        </div>
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                 <a href="javascript:;" onclick="tourGoods_add('添加旅游产品','{{URL::asset('/admin/product/tourGoods/add')}}')"
                    class="btn btn-primary radius">
                     <i class="Hui-iconfont">&#xe600;</i> 添加旅游产品
                 </a>
            </span>
        </div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-bg table-sort" id="table-sort">
            <thead>
            <tr class="text-c">
                <th width="90">名称</th>
                <th width="10">封面图片</th>
                <th width="70">类型</th>
                <th width="30">分类名称</th>
                <th width="40">原价（默认）</th>
                <th width="50">实际价格（默认）</th>
                <th width="30">是否为特价产品</th>
                <th width="30">旅游产品类型</th>
                <th width="40">单位</th>
                <th width="40">共有位子（默认）</th>
                <th width="40">剩余空位（默认）</th>
                <th width="40">出发地</th>
                <th width="90">出发线路</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($datas as $data)
                <tr class="text-c">
                    <td>{{$data['name']}}</td>
                    <td>
                        <img src="{{ $data['image'] ? $data['image'].'?imageView2/1/w/100/h/60/interlace/1/q/75|imageslim' : URL::asset('/img/default_headicon.png')}}"
                             class="radius-5">
                    </td>
                    <td>{{$data->tourCategories->type == "0" ? "正常旅游产品" : "旅游定制-套餐"}}</td>
                    <td>{{$data['tourCategories']['name']}}</td>
                    <td>{{$data['drimecost']}}</td>
                    <td>{{$data['price']}}</td>
                    @if($data['sale']==0)
                        <td>不是</td>
                    @elseif($data['sale']==1)
                        <td>是</td>
                    @endif
                    @if($data['type']==0)
                        <td>普通旅游产品</td>
                    @elseif($data['type']==1)
                        <td>一日游旅游产品</td>
                    @endif
                    <td>{{$data['unit']}}</td>
                    <td>{{$data['total']}}</td>
                    <td>{{$data['surplus']}}</td>
                    <td>{{$data['start_place']}}</td>
                    <td>
                        @foreach($data['tourGoodsRoutes'] as $tourGoodsRoutes)
                            &nbsp;&nbsp;名称（第几天）：{{$tourGoodsRoutes['name']}}出发线路：{{$tourGoodsRoutes['place']}}内容：{{$tourGoodsRoutes['content']}}</br>
                        @endforeach
                    </td>
                    <td class="td-manage">
                        <a title="添加产品图片" href="javascript:;" onclick="tourGoods_addImage('添加产品图片','{{URL::asset('/admin/product/tourGoods/addImage')}}?id={{$data['id']}}',{{$data['id']}})"
                           class="ml-5" style="text-decoration:none">
                            <span class="label label-success radius">添加产品图片</span>
                        </a>
                        <a title="添加产品线路" href="javascript:;" onclick="tourGoods_addRoutes('添加产品线路','{{URL::asset('/admin/product/tourGoods/addRoutes')}}?id={{$data['id']}}',{{$data['id']}})"
                           class="ml-5" style="text-decoration:none">
                            <span class="label label-success radius">添加产品线路</span>
                        </a>
                        <a title="添加产品日期价钱" href="javascript:;" onclick="tourGoods_addCalendars('添加产品日期价钱','{{URL::asset('/admin/product/tourGoods/addCalendars')}}?id={{$data['id']}}',{{$data['id']}})"
                           class="ml-5" style="text-decoration:none">
                            <span class="label label-success radius">添加产品日期价钱</span>
                        </a>
                        </br>
                        <a title="查看详情" href="javascript:;"
                           onclick="tourGoodsDetails_edit('查看详情','{{URL::asset('/admin/product/tourGoods/tourGoodsDetails')}}?id={{$data['id']}}',{{$data['id']}})"
                           class="ml-5" style="text-decoration:none">
                            <i class="Hui-iconfont">&#xe695;</i>
                        </a>
                        <a title="编辑" href="javascript:;" onclick="tourGoods_edit('旅游产品编辑','{{URL::asset('/admin/product/tourGoods/edit')}}?id={{$data['id']}}',{{$data['id']}})"
                           class="ml-5" style="text-decoration:none">
                            <i class="Hui-iconfont">&#xe6df;</i>
                        </a>
                        <a title="删除" href="javascript:;" onclick="tourGoods_del(this,'{{$data['id']}}')" class="ml-5" style="text-decoration:none">
                            <i class="Hui-iconfont">&#xe6e2;</i>
                        </a>
                        <a title="企业二维码" href="javascript:;"
                           onclick="tourGoods_show_ewm('{{$data->name}}小程序码','{{URL::asset('/admin/product/tourGoods/ewm')}}?id={{$data->id}}',{{$data->id}})"
                           class="ml-5"
                           style="text-decoration:none">
                            <i class="icon iconfont">&#xe6d7;</i>
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
                {"orderable":false,"aTargets":[11]}// 不参与排序的列
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
        /*旅游产品-增加*/
        function tourGoods_add(title, url) {
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }

        /*查看旅游产品详情*/
        function tourGoodsDetails_edit(title, url, id) {
            // console.log("comment_edit url:" + url);
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }

        /*旅游产品-删除*/
        function tourGoods_del(obj, id) {
            layer.confirm('确认要删除吗？', function (index) {
                //进行后台删除
                var param = {
                    id: id,
                    _token: "{{ csrf_token() }}"
                }
                delTourGoods('{{URL::asset('')}}', param, function (ret) {
                    if (ret.result == true) {
                        $(obj).parents("tr").remove();
                        layer.msg(ret.msg, {icon: 1, time: 1000});
                    } else {
                        layer.msg(ret.msg, {icon: 2, time: 1000})
                    }
                })
            });
        }

        /*旅游产品-编辑*/
        function tourGoods_edit(title, url, id) {
            console.log("admin_edit url:" + url);
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }

        /*添加旅游产品图片*/
        function tourGoods_addImage(title, url, id) {
            console.log("tourGoods_addImage url:" + url);
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }

        /*添加旅游产品路线*/
        function tourGoods_addRoutes(title, url, id) {
            console.log("tourGoods_addImage url:" + url);
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }

        /*添加旅游产品日期价钱*/
        function tourGoods_addCalendars(title, url, id) {
            console.log("tourGoods_addImage url:" + url);
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }

        /*
         *
         * 展示企业二维码
         *
         * By TerryQi
         *
         * 2018-03-29
         */
        function tourGoods_show_ewm(title, url) {
            console.log("url:" + url);
            var index = layer.open({
                type: 2,
                area: ['520px', '520px'],
                fixed: false,
                maxmin: true,
                title: title,
                content: url
            });
        }


    </script>
@endsection