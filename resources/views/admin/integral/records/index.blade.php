@extends('admin.layouts.app')

@section('content')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 积分商城管理 <span class="c-gray en">&gt;</span> 用户积分兑换记录 <a class="btn btn-success radius btn-refresh r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" onclick="location.replace('{{URL::asset('/admin/integral/records/index')}}');" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <a class="btn btn-primary radius" href="javascript:;">
            用户积分兑换记录
            </a>
        </span>
        {{--<span class="r">共有数据：<strong>{{count($datas)}}</strong> 条</span> --}}
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort" id="table-sort">
            <thead>
            <tr class="text-c">
                <th width="80">积分记录事件</th>
                <th width="60">积分类型</th>
                <th width="60">用户昵称</th>
                <th width="60">用户电话</th>
                <th width="60">用户性别</th>
                {{--<th width="60">用户积分</th>--}}
            </tr>
            </thead>
            <tbody>
            @foreach($datas as $data)
                <tr class="text-c">
                    <td>{{$data['content']}}</td>
                    @if($data['type']==0)
                        <td>积分商品兑换</td>
                    @elseif($data['type']==1)
                        <td>签到</td>
                    @elseif($data['type']==2)
                        <td>邀请好友</td>
                    @elseif($data['type']==3)
                        <td>发表评论</td>
                    @endif
                    <td>{{$data['user']['nick_name']}}</td>
                    <td>{{$data['user']['telephone']}}</td>
                    @if($data['gender']==0)
                        <td>女</td>
                    @elseif($data['gender']==1)
                        <td>男</td>
                    @endif
                    {{--<td>{{$data['user']['integral']}}</td>--}}
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