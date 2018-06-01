@extends('admin.layouts.app')

@section('content')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 旅游定制酒店管理 <span class="c-gray en">&gt;</span> 旅游定制酒店管理列表 <a class="btn btn-success radius btn-refresh r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" onclick="location.replace('{{URL::asset('/admin/madeTour/hotel/index')}}');" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="text-c">
        <form action="{{URL::asset('/admin/madeTour/hotel/index')}}" method="post" class="form-horizontal">
            {{csrf_field()}}
            <input id="search_word" name="search_word" type="text" class="input-text" style="width:450px" placeholder="名称">
            <button type="submit" class="btn btn-success" id="" name="">
                <i class="Hui-iconfont">&#xe665;</i> 搜索
            </button>
        </form>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <a class="btn btn-primary radius" onclick="hotel_add('添加旅游定制酒店','{{URL::asset('/admin/madeTour/hotel/edit')}}')" href="javascript:;">
                <i class="Hui-iconfont">&#xe600;</i> 添加旅游定制酒店
            </a>
        </span>
        {{--<span class="r">共有数据：<strong>{{count($datas)}}</strong> 条</span> --}}
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort" id="table-sort">
            <thead>
            <tr class="text-c">
                <th width="80">中文名称</th>
                <th width="80">封面图片</th>
                {{--<th width="60">默认原价</th>--}}
                <th width="60">默认实际价格</th>
                <th width="60">是否显示特价</th>
                {{--<th width="60">单位</th>--}}
                <th width="90">地点</th>
                {{--<th width="60">经度</th>--}}
                {{--<th width="60">纬度</th>--}}
                {{--<th width="60">联系方式</th>--}}
                {{--<th width="60">中文名称</th>--}}
                <th width="60">英文名称</th>
                <th width="60">标签</th>
                {{--<th width="60">酒店设施</th>--}}
                {{--<th width="60">介绍</th>--}}
                {{--<th width="60">政策</th>--}}
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($datas as $data)
                <tr class="text-c">
                    <td>{{$data['name']}}</td>
                    <td><img width="210" class="picture-thumb" src="{{$data['image']}}"></td>
{{--                    <td class="text-l">{{$data['primecost']}}</td>--}}
                    <td>{{$data['price']}}</td>
                    @if($data['sale']==0)
                        <td>否</td>
                    @elseif($data['sale']==1)
                        <td>是</td>
                    @endif
{{--                    <td>{{$data['unit']}}</td>--}}
                    <td>{{$data['address']}}</td>
{{--                    <td>{{$data['lon']}}</td>--}}
                    {{--<td>{{$data['lat']}}</td>--}}
                    {{--<td>{{$data['telephone']}}</td>--}}
{{--                    <td>{{$data['china_name']}}</td>--}}
                    <td>{{$data['english_name']}}</td>
                    <td>{{$data['label']}}</td>
{{--                    <td>{{$data['facilities']}}</td>--}}
{{--                    <td>{{$data['content']}}</td>--}}
{{--                    <td>{{$data['policy']}}</td>--}}
                    <td class="td-manage">
                        <a title="添加酒店图片" href="javascript:;" onclick="hotel_addImage('添加酒店图片','{{URL::asset('/admin/madeTour/hotel/addImage')}}?id={{$data['id']}}',{{$data['id']}})"
                           class="ml-5" style="text-decoration:none">
                            <span class="label label-success radius">添加酒店图片</span>
                        </a>
                        <a title="添加酒店房间" href="javascript:;" onclick="hotel_addRooms('添加酒店房间','{{URL::asset('/admin/madeTour/hotel/addHotelRoomsIndex')}}?id={{$data['id']}}',{{$data['id']}})"
                           class="ml-5" style="text-decoration:none">
                            <span class="label label-success radius">添加酒店房间</span>
                        </a>
                        <a title="编辑" href="javascript:;" onclick="hotel_edit('旅游定制酒店编辑','{{URL::asset('/admin/madeTour/hotel/edit')}}?id={{$data['id']}}',{{$data['id']}})" class="ml-5" style="text-decoration:none">
                            <i class="Hui-iconfont">&#xe6df;</i>
                        </a>
                        <a title="删除" href="javascript:;" onclick="hotel_del(this,'{{$data['id']}}')" class="ml-5" style="text-decoration:none">
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
        "aaSorting": [[ 1, "desc" ]],//默认第几个排序
        "bStateSave": true,//状态保存
        "pading":false,
        "searching" : false, //去掉搜索框
        "bLengthChange": false,   //去掉每页显示多少条数据方法
        "aoColumnDefs": [
            //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
            {"orderable":false,"aTargets":[0,1,5]}// 不参与排序的列
        ]
    });

    /*旅游定制酒店-添加*/
    function hotel_add(title,url){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }

    /*旅游定制酒店-编辑*/
    function hotel_edit(title, url, id) {
        console.log("banner_edit url:" + url);
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }

    /*旅游定制酒店-删除*/
    function hotel_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            //进行后台删除
            var param = {
                id: id,
                _token: "{{ csrf_token() }}"
            }
            delHotel('{{URL::asset('')}}', param, function (ret) {
                if (ret.result == true) {
                    $(obj).parents("tr").remove();
                    layer.msg(ret.msg, {icon: 1, time: 1000});
                } else {
                    layer.msg(ret.msg, {icon: 2, time: 1000})
                }
            })
        });
    }

    /*添加旅游产品图片*/
    function hotel_addImage(title, url, id) {
        console.log("tourGoods_addImage url:" + url);
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }

    /*添加旅游产品路线*/
    function hotel_addRooms(title, url, id) {
        console.log("tourGoods_addImage url:" + url);
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }


</script>
@endsection