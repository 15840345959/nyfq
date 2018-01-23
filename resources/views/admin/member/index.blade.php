@extends('admin.layouts.app')

@section('content')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 会员管理 <span class="c-gray en">&gt;</span>会员列表 <a class="btn btn-success radius btn-refresh r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" onclick="location.replace('{{URL::asset('/admin/member/index')}}');" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="text-c">
        <form action="{{URL::asset('/admin/member/index')}}" method="get" class="form-horizontal">
            {{csrf_field()}}
            <span class="select-box" style="width:200px;">
              <select class="select" size="1" name="organization_id">
                <option value="" selected>全部</option>
                <option value="0">没有指定旅行社</option>
                  @foreach($organizations as $organization)
                      <option value="{{$organization['id']}}">{{$organization['name']}}</option>
                  @endforeach
              </select>
            </span>
            <input id="search" name="search" type="text" class="input-text" style="width:250px" placeholder="会员昵称/电话">
            <button type="submit" class="btn btn-success" id="" name="">
                <i class="Hui-iconfont">&#xe665;</i> 搜索
            </button>
        </form>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort" id="table-sort">
            <thead>
            <tr class="text-c">
                <th width="80">ID</th>
                <th>头像</th>
                <th>昵称</th>
                <th>类别</th>
                <th>旅行社</th>
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
                    @if($data['type']==0)
                        <td class="text-l">游客</td>
                    @else
                        <td class="text-l">管理员</td>
                    @endif
                    @if($data['organization_id']==0)
                        <td class="text-l">没有指定旅行社</td>
                    @else
                        <td class="text-l">{{$data['organization']['name']}}</td>
                    @endif
                    <td>{{$data['updated_at']}}</td>
                    <td class="td-manage">
                        <a title="查看详情" href="javascript:;" onclick="member_edit('查看详情','{{URL::asset('/admin/member/edit')}}?id={{$data['id']}}',{{$data['id']}})" class="ml-5" style="text-decoration:none">
                            <i class="Hui-iconfont">&#xe695;</i>
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
            {"orderable":false,"aTargets":[0,6]}// 不参与排序的列
        ]
    });

    /*查看会员详情*/
    function member_edit(title, url, id) {
        console.log("member_edit url:" + url);
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }


</script>
@endsection