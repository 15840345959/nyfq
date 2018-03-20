@extends('admin.layouts.app')

@section('content')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 积分商城管理 <span class="c-gray en">&gt;</span> 积分商城商品兑换历史 <a class="btn btn-success radius btn-refresh r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" onclick="location.replace('{{URL::asset('/admin/integral/histories/index')}}');" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <a class="btn btn-primary radius" href="javascript:;">
            积分商城商品兑换历史
            </a>
        </span>
        {{--<span class="r">共有数据：<strong>{{count($datas)}}</strong> 条</span> --}}
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort" id="table-sort">
            <thead>
            <tr class="text-c">
                <th width="80">产品名称</th>
                <th width="80">产品图片</th>
                <th width="60">兑换积分</th>
                <th width="60">商品状态</th>
                <th width="60">用户昵称</th>
                <th width="60">用户电话</th>
                {{--<th width="60">用户积分</th>--}}
                <th width="60">旅行社名称</th>
                <th width="60">旅行社地址</th>
            </tr>
            </thead>
            <tbody>
            @foreach($datas as $data)
                <tr class="text-c">
                    <td>{{$data['goods_name']}}</td>
                    <td>
                        <img src="{{ $data['goods_image'] ? $data['goods_image'].'?imageView2/1/w/100/h/60/interlace/1/q/75|imageslim' : URL::asset('/img/default_headicon.png')}}"
                             class="radius-5">
                    </td>
                    <td>{{$data['goods_price']}}</td>
                    @if($data['status']==0)
                        <td>未兑换</td>
                    @elseif($data['status']==1)
                        <td>已兑换</td>
                    @endif
                    <td>{{$data['user']['nick_name']}}</td>
                    <td>{{$data['user']['telephone']}}</td>
                    {{--<td>{{$data['user']['integral']}}</td>--}}
                    <td>{{$data['organization']['name']}}</td>
                    <td>{{$data['organization']['address']}}</td>
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
            {"orderable":false,"aTargets":[0,1,2]}// 不参与排序的列
        ]
    });



</script>
@endsection