·@extends('admin.layouts.app')

@section('content')

    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 旅游产品管理 <span
                class="c-gray en">&gt;</span>旅游产品详情列表 <a class="btn btn-success radius r btn-refresh"
                                                       style="line-height:1.6em;margin-top:3px"
                                                       href="javascript:location.replace(location.href);" title="刷新"
                                                       onclick="location.replace('{{URL::asset('/admin/tourGoods/tourGoodsDetails')}}');"><i
                    class="Hui-iconfont">&#xe68f;</i></a></nav>
    {{--/{{$datas->type_id}}--}}
    <div class="page-container">
        <table class="table table-border table-bordered table-bg mt-20">
            {{--旅游产品详情--}}
            <thead>
            <tr>
                <th colspan="2" scope="col">旅游产品详情信息</th>
            </tr>
            </thead>
            <tbody>
            @foreach($datas as $data)
                <tr>
                    <td>名称</td>
                    <td>{{$data->name}}</td>
                </tr>
                <tr>
                    <td>短标题</td>
                    <td>{{$data->title}}</td>
                </tr>
                <tr>
                    <td>封面图片</td>
                    <td>
                        <img src="{{ $data->image ? $data->image.'?imageView2/1/w/200/h/100/interlace/1/q/75|imageslim' : URL::asset('/img/upload.png')}}"
                             class=" radius-5">
                    </td>
                </tr>
                <tr>
                    <td>内容图片（为空时有默认图片）</td>
                    <td>
                        <img src="{{ $data->content_image ? $data->content_image.'?imageView2/1/w/200/h/100/interlace/1/q/75|imageslim' : URL::asset('/img/upload.png')}}"
                             class=" radius-5">
                    </td>
                </tr>
                <tr>
                    <td>原价（默认）</td>
                    <td>{{$data->drimecost}}</td>
                </tr>
                <tr>
                    <td>实际价格（默认）</td>
                    <td>{{$data->price}}</td>
                </tr>
                <tr>
                    <td>是否为特价产品</td>
                    @if($data->sale=="0")
                        <td>不是</td>
                    @elseif($data->sale=="1")
                        <td>是</td>
                    @endif
                </tr>
                <tr>
                    <td>旅游产品类型</td>
                    @if($data->type=="0")
                        <td>普通旅游产品</td>
                    @elseif($data->type=="1")
                        <td>一日游旅游产品</td>
                    @else
                        <td>暂无</td>
                    @endif
                </tr>
                <tr>
                    <td>产品单位</td>
                    <td>{{$data->unit}}</td>
                </tr>
                <tr>
                    <td>共有位子（默认）</td>
                    <td>{{$data->total}}</td>
                </tr>
                <tr>
                    <td>剩余空位（默认）</td>
                    <td>{{$data->surplus}}</td>
                </tr>
                <tr>
                    <td>出发地</td>
                    <td>{{$data->start_place}}</td>
                </tr>
            </tbody>
            {{--旅游产品分类详情--}}
            <thead>
                <tr>
                    <th colspan="2" scope="col">旅游产品栏目详情</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>栏目名称</td>
                    <td>{{$data->tourCategories->name}}</td>
                </tr>
                <tr>
                    <td>图片</td>
                    <td>
                        <img src="{{ $data['tourCategories']['image'] ? $data['tourCategories']['image'].'?imageView2/1/w/200/h/300/interlace/1/q/75|imageslim' : URL::asset('/img/upload.png')}}"
                             class=" radius-5">
                    </td>
                </tr>
                <tr>
                    <td>产品类型</td>
                    @if($data->tourCategories->type=="0")
                        <td>正常旅游产品</td>
                    @elseif($data->tourCategories->type=="1")
                        <td>旅游定制-套餐</td>
                    @endif
                </tr>
            </tbody>
            @endforeach
        </table>
        <div style="text-align: center;margin-top: 3rem;margin-bottom: 4rem;">
            <button onClick="layer_close();" class="btn btn-default radius" type="button">返回</button>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">

        $(function () {

        });


    </script>
@endsection