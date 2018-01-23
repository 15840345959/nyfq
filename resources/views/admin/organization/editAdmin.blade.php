@extends('admin.layouts.app')

@section('content')
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 旅行社管理 <span class="c-gray en">&gt;</span> {{$organization['name']}}备选管理员列表 <a class="btn btn-success radius btn-refresh r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" onclick="location.replace('{{URL::asset('/admin/organization/editAdmin')}}?organization_id={{$organization_id}}');" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="text-c">
        <form action="{{URL::asset('/admin/organization/editAdminSearch')}}" method="get" class="form-horizontal">
            {{csrf_field()}}
            <input id="organization_id" name="organization_id" type="hidden" value="{{$organization_id}}">
            <input id="search" name="search" type="text" class="input-text" style="width:450px" placeholder="用户昵称/电话">
            <button type="submit" class="btn btn-success" id="" name="">
                <i class="Hui-iconfont">&#xe665;</i> 搜索
            </button>
        </form>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <a href="javascript:void(0)" onclick="layer_close()">
                <input class="btn btn-primary-outline radius" type="button" value="返回">
            </a>
        </span>
        <span class="r">共有数据：<strong>{{count($datas)}}</strong> 条</span> </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort" id="table-sort">
            <thead>
            <tr class="text-c">
                <th width="80">ID</th>
                <th>头像</th>
                <th>昵称</th>
                <th>电话</th>
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
                    @if($data['telephone'])
                        <td>{{substr($data['telephone'],0,3)}}****{{substr($data['telephone'],6,3)}}</td>
                    @else
                        <td>暂未设置</td>
                    @endif
                    <td>{{$data['updated_at']}}</td>
                    <td class="td-manage">
                        <a title="成为管理员" href="javascript:;" onclick="organizationAdmin_setUp(this,'{{$data['id']}}','{{$organization_id}}')" class="ml-5" style="text-decoration:none">
                            <input class="btn btn-success radius" type="button" value="成为管理员">
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

    /*成为旅行社管理员*/
    function organizationAdmin_setUp(obj,id,organization_id){
        layer.confirm('确认要将指定用户设为该旅行社的管理员吗？',function(index){
            var param = {
                id: id,
                organization_id:organization_id,
                _token: "{{ csrf_token() }}"
            }
            setUpOrganizationAdmin('{{URL::asset('')}}', param, function (ret) {
                if (ret.result == true) {
                    $(obj).parents("tr").remove();
                    layer.msg(ret.msg, {icon: 1, time: 1000});
                    setTimeout(function () {
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.$('.btn-refresh').click();
                        // parent.layer.close(index);
                    }, 1000)
                } else {
                    layer.msg(ret.msg, {icon: 2, time: 1000})
                }
            })
        });
    }


</script>
@endsection