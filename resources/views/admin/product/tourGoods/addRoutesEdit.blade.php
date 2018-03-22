@extends('admin.layouts.app')

@section('content')



    <div class="page-container">
        <form class="form form-horizontal" id="form-admin-add">
            {{csrf_field()}}
            <div class="row cl hidden">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>id：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input id="id" name="id" type="text" class="input-text"
                           value="{{ isset($data->id) ? $data->id : '' }}" placeholder="旅游产品路线id">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>名称(第几天)：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input id="name" name="name" type="text" class="input-text"
                           value="{{ isset($data->name) ? $data->name : '' }}" placeholder="请输入旅游产品名称(第几天)">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>出发线路：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input id="place" name="place" type="text" class="input-text" style="width: 100%;"
                           value="{{ isset($data->place) ? $data->place : '' }}" placeholder="请输入出发线路">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>内容：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea id="content" name="content" class="textarea" placeholder="输入内容..." rows="" cols="" >{{ isset($data->content) ? $data->content : '' }}</textarea>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"></label>
                <div class="formControls col-xs-8 col-sm-9">
                    <p style="color: red;">一天内不同时间点用此符号隔开：<_> </p>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>选择旅游产品名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <select id="tour_goods_id" name="tour_goods_id" class="select">
                        @foreach($tourGoods as $tourGoods)
                            <option value="{{ isset($tourGoods->id) ? $tourGoods->id : '' }}">{{ isset($tourGoods->name) ? $tourGoods->name : '' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row cl" style="padding-top: 20px;">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                    <input class="btn btn-primary radius" type="submit" value="保存">
                    <button onClick="layer_close();" class="btn btn-default radius" type="button">取消</button>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(function () {

            $("#form-admin-add").validate({
                rules: {
                    name: {
                        required: true,
                    },
                    place: {
                        required: true,
                    },
                    content:{
                        required: true,
                    },
                    tour_goods_id: {
                        required: true,
                    },
                },
                onkeyup: false,
                focusCleanup: true,
                success: "valid",
                submitHandler: function (form) {
                    $(form).ajaxSubmit({
                        type: 'POST',
                        url: "{{ URL::asset('/admin/product/tourGoods/editRoutes')}}",
                        success: function (ret) {
                            console.log(JSON.stringify(ret));
                            if (ret.result) {
                                layer.msg('保存成功', {icon: 1, time: 1000});
                                setTimeout(function () {
                                    var index = parent.layer.getFrameIndex(window.name);
                                    parent.$('.btn-refresh').click();

                                    console.log('window.name:'+window.name);
                                    console.log('index:'+index);
//                                    parent.layer.close(index);
                                    {{--window.location.href='{{ URL::asset('/admin/product/tourGoods/addRoutes')}}'--}}

                                }, 500)
                            } else {
                                layer.msg(ret.message, {icon: 2, time: 1000});
                            }
                        },
                        error: function (XmlHttpRequest, textStatus, errorThrown) {
                            layer.msg('保存失败', {icon: 2, time: 1000});
                            console.log("XmlHttpRequest:" + JSON.stringify(XmlHttpRequest));
                            console.log("textStatus:" + textStatus);
                            console.log("errorThrown:" + errorThrown);
                        }
                    });
                }

            });
        });


    </script>
@endsection