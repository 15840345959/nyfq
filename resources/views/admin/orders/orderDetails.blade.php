·@extends('admin.layouts.app')

@section('content')

    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 订单管理 <span
                class="c-gray en">&gt;</span>订单详情列表 <a class="btn btn-success radius r btn-refresh"
                                                       style="line-height:1.6em;margin-top:3px"
                                                       href="javascript:location.replace(location.href);" title="刷新"
                                                       onclick="location.replace('{{URL::asset('/admin/orders/orderDetails')}}');"><i
                    class="Hui-iconfont">&#xe68f;</i></a></nav>
    {{--/{{$datas->type_id}}--}}
    <div class="page-container">
        <table class="table table-border table-bordered table-bg mt-20">
            {{--订单详情--}}
            <thead>
            <tr>
                <th colspan="2" scope="col">订单详情信息</th>
            </tr>
            </thead>
            <tbody>
            @foreach($datas as $data)
                <tr>
                    <td>原价</td>
                    <td>{{$data->primecost}}</td>
                </tr>
                <tr>
                    <td>实际价格</td>
                    <td>{{$data->price}}</td>
                </tr>
                <tr>
                    <td>购买数量</td>
                    <td>{{$data->count}}</td>
                </tr>
                <tr>
                    <td>联系人电话</td>
                    <td>{{$data->tel}}</td>
                </tr>
                <tr>
                    <td>联系人姓名</td>
                    <td>{{$data->name}}</td>
                </tr>
                <tr>
                    <td>开始时间</td>
                    @if($data->goods_type=='1')
                        <td>{{$data->start_time}}</td>
                    @else
                        <td>暂无旅游时间</td>
                    @endif
                </tr>
                <tr>
                    <td>备注</td>
                    @if($data->content=='')
                        <td>暂无</td>
                    @else
                        <td>{{$data->content}}</td>
                    @endif
                </tr>
                <tr>
                    <td>订单状态</td>
                    @if($data->status=="0")
                        <td>未付款</td>
                    @elseif($data->status=="1")
                        <td>已付款,未出行</td>
                    @elseif($data->status=="2")
                        <td>已出行,但未到结束时间</td>
                    @elseif($data->status=="3")
                        <td>服务完毕</td>
                    @elseif($data->status=="4")
                        <td>退款</td>
                    @endif
                </tr>
            </tbody>
            {{--用户详情--}}
            <thead>
                <tr>
                    <th colspan="2" scope="col">用户详情信息</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>用户昵称</td>
                    <td>{{$data->user->nick_name}}</td>
                </tr>
                <tr>
                    <td>用户头像</td>
                    <td>
                        <img src="{{ $data['user']['avatar'] ? $data['user']['avatar'].'?imageView2/1/w/200/h/200/interlace/1/q/75|imageslim' : URL::asset('/img/default_headicon.png')}}"
                             class="img-rect-30 radius-5">
                    </td>
                </tr>
                <tr>
                    <td>用户电话</td>
                    @if($data->user->telephone=="")
                        <td>暂无用户电话</td>
                    @else
                        <td>{{$data->user->telephone}}</td>
                    @endif
                </tr>
                <tr>
                    <td>用户身份证号</td>
                    @if($data->user->id_card=="")
                        <td>暂无用户身份证号</td>
                    @else
                        <td>{{$data->user->id_card}}</td>
                    @endif
                </tr>
                <tr>
                    <td>用户性别</td>
                    @if($data->user->gender=="1")
                        <td>男性</td>
                    @elseif($data->user->gender=="2")
                        <td>女性</td>
                    @else
                        <td>用户性别保密</td>
                    @endif
                </tr>
                <tr>
                    <td>用户邮箱</td>
                    @if($data->user->email=="")
                        <td>暂无用户邮箱</td>
                    @else
                        <td>{{$data->user->email}}</td>
                    @endif
                </tr>
                <tr>
                    <td>用户护照</td>
                    @if($data->user->passport=="")
                        <td>暂无用户护照</td>
                    @else
                        <td>{{$data->user->passport}}</td>
                    @endif
                </tr>
                <tr>
                    <td>签到天数</td>
                    @if($data->user->sign=="")
                        <td>暂无用户签到</td>
                    @else
                        <td>{{$data->user->sign}}</td>
                    @endif
                </tr>
                <tr>
                    <td>用户积分</td>
                    @if($data->user->integral=="")
                        <td>暂无用户积分</td>
                    @else
                        <td>{{$data->user->integral}}</td>
                    @endif
                </tr>
                <tr>
                    <td>个人中心背景图片</td>
                    <td>
                        <img src="{{ $data['user']['background'] ? $data['user']['background'].'?imageView2/1/w/200/h/200/interlace/1/q/75|imageslim' : URL::asset('/img/default_headicon.png')}}"
                             class="img-rect-30 radius-5">
                    </td>
                </tr>
            </tbody>
            {{--商品详情--}}
            <thead>
            <tr>
                <th colspan="2" scope="col">商品详情信息</th>
            </tr>
            </thead>
            @if($data->goods_type == '1')
                <thead>
                <tr>
                    <th colspan="2" scope="col">旅游产品详情</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>旅游产品名称</td>
                    <td>{{$data->tourGoods->name}}</td>
                </tr>
                <tr>
                    <td>旅游产品简介</td>
                    <td>{{$data->tourGoods->title}}</td>
                </tr>
                <tr>
                    <td>旅游产品封面</td>
                    <td>
                        <img src="{{ $data['tourGoods']['image'] ? $data['tourGoods']['image'].'?imageView2/1/w/200/h/200/interlace/1/q/75|imageslim' : URL::asset('/img/default_headicon.png')}}"
                             class="img-rect-30 radius-5">
                    </td>
                </tr>
                <tr>
                    <td>旅游产品原价</td>
                    <td>{{$data->tourGoods->drimecost}}</td>
                </tr>
                <tr>
                    <td>旅游产品实际价格</td>
                    <td>{{$data->tourGoods->price}}</td>
                </tr>
                <tr>
                    <td>是否为特价旅游产品</td>
                    @if($data->tourGoods->sale == '0')
                        <td>不是</td>
                    @elseif($data->tourGoods->sale == '1')
                        <td>是</td>
                    @endif
                </tr>
                <tr>
                    <td>旅游产品单位</td>
                    <td>{{$data->tourGoods->unit}}</td>
                </tr>
                <tr>
                    <td>共有位子</td>
                    <td>{{$data->tourGoods->total}}</td>
                </tr>
                <tr>
                    <td>剩余空位</td>
                    <td>{{$data->tourGoods->surplus}}</td>
                </tr>
                <tr>
                    <td>出发地</td>
                    <td>{{$data->tourGoods->start_place}}</td>
                </tr>
                </tbody>
            @elseif($data->goods_type == '2')
                <thead>
                <tr>
                    <th colspan="2" scope="col">【旅游定制】飞机票产品详情</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>出发地</td>
                    <td>{{$data->planGoods->start_place}}</td>
                </tr>
                <tr>
                    <td>终点</td>
                    <td>{{$data->planGoods->end_place}}</td>
                </tr>
                <tr>
                    <td>出行时间</td>
                    <td>{{$data->planGoods->start_time}}</td>
                </tr>
                <tr>
                    <td>降落时间</td>
                    <td>{{$data->planGoods->end_time}}</td>
                </tr>
                <tr>
                    <td>原价</td>
                    <td>{{$data->planGoods->primecast}}</td>
                </tr>
                <tr>
                    <td>实际价格</td>
                    <td>{{$data->planGoods->price}}</td>
                </tr>
                <tr>
                    <td>是否为特价机票</td>
                    @if($data->planGoods->sale == '0')
                        <td>不是</td>
                    @elseif($data->planGoods->sale == '1')
                        <td>是</td>
                    @endif
                </tr>
                <tr>
                    <td>单位</td>
                    <td>{{$data->planGoods->unit}}</td>
                </tr>
                <tr>
                    <td>航空公司</td>
                    <td>{{$data->planGoods->company}}</td>
                </tr>
                </tbody>
            @elseif($data->goods_type == '3')
                <thead>
                    <tr>
                        <th colspan="2" scope="col">【旅游定制】酒店产品详情</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td>名称</td>
                    <td>{{$data->hotelGoods->name}}</td>
                </tr>
                <tr>
                    <td>酒店产品封面</td>
                    <td>
                        <img src="{{ $data['hotelGoods']['image'] ? $data['hotelGoods']['image'].'?imageView2/1/w/200/h/200/interlace/1/q/75|imageslim' : URL::asset('/img/default_headicon.png')}}"
                             class="img-rect-30 radius-5">
                    </td>
                </tr>
                <tr>
                    <td>酒店产品原价</td>
                    <td>{{$data->hotelGoods->primecost}}</td>
                </tr>
                <tr>
                    <td>酒店产品实际价格</td>
                    <td>{{$data->hotelGoods->price}}</td>
                </tr>
                <tr>
                    <td>是否为特价产品</td>
                    @if($data->hotelGoods->sale == '0')
                        <td>不是</td>
                    @elseif($data->hotelGoods->sale == '1')
                        <td>是</td>
                    @endif
                </tr>
                <tr>
                    <td>酒店产品单位</td>
                    <td>{{$data->hotelGoods->unit}}</td>
                </tr>
                <tr>
                    <td>酒店地点</td>
                    <td>{{$data->hotelGoods->address}}</td>
                </tr>
                <tr>
                    <td>酒店经度</td>
                    <td>{{$data->hotelGoods->lon}}</td>
                </tr>
                <tr>
                    <td>酒店纬度</td>
                    <td>{{$data->hotelGoods->lat}}</td>
                </tr>
                <tr>
                    <td>酒店联系方式</td>
                    <td>{{$data->hotelGoods->telephone}}</td>
                </tr>
                <tr>
                    <td>酒店介绍</td>
                    <td>{{$data->hotelGoods->content}}</td>
                </tr>
                <tr>
                    <td>酒店政策</td>
                    <td>{{$data->hotelGoods->policy}}</td>
                </tr>
                </tbody>
            @elseif($data->goods_type == '4')
                <thead>
                <tr>
                    <th colspan="2" scope="col">【旅游定制】车导产品详情</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>车导产品型号</td>
                    <td>{{$data->carGoods->name}}</td>
                </tr>
                <tr>
                    <td>车导产品图片</td>
                    <td>
                        <img src="{{ $data['carGoods']['image'] ? $data['carGoods']['image'].'?imageView2/1/w/200/h/200/interlace/1/q/75|imageslim' : URL::asset('/img/default_headicon.png')}}"
                             class="img-rect-30 radius-5">
                    </td>
                </tr>
                <tr>
                    <td>车导区域</td>
                    <td>{{$data->carGoods->address}}</td>
                </tr>
                <tr>
                    <td>车导座位数</td>
                    <td>{{$data->carGoods->seat}}</td>
                </tr>
                <tr>
                    <td>车导原价</td>
                    <td>{{$data->carGoods->primecast}}</td>
                </tr>
                <tr>
                    <td>车导实际价格</td>
                    <td>{{$data->carGoods->price}}</td>
                </tr>
                <tr>
                    <td>是否为特价产品</td>
                    @if($data->carGoods->sale == '0')
                        <td>不是</td>
                    @elseif($data->carGoods->sale == '1')
                        <td>是</td>
                    @endif
                </tr>
                <tr>
                    <td>车导产品单位</td>
                    <td>{{$data->carGoods->unit}}</td>
                </tr>
                </tbody>
            @endif
            @endforeach
        </table>
        <div style="text-align: center;margin-top: 3rem;margin-bottom: 4rem;">
            <button onClick="layer_close();" class="btn btn-default radius" type="button">返回</button>
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
                {"orderable": false, "aTargets": [0, 1, 5]}// 不参与排序的列
            ]
        });

        $(function () {

        });


    </script>
@endsection