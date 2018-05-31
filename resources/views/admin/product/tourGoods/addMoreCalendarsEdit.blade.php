@extends('admin.layouts.app')

@section('content')



    <div class="page-container">
        <form class="form form-horizontal" id="form-admin-add">
            {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>日期范围：</label>
                <div class="formControls col-xs-8 col-sm-9">

                    <input type="text" onfocus="WdatePicker({ minDate:'%y-%M-%d' })" value="{{date('Y-m-d',strtotime(now()))}}" id="logmin" name="date_start" class="input-text Wdate" style="width:120px;">
                    -
                    <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'logmin\')}' })" value="{{date('Y-m-d',strtotime(now()))}}" id="logmax" name="date_end" class="input-text Wdate" style="width:120px;">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>原价：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input id="primecast" name="primecast" type="text" class="input-text"
                           value="{{ isset($data->primecast) ? $data->primecast : '' }}" placeholder="请输入旅游产品原价">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>实际价格：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input id="price" name="price" type="text" class="input-text" style="width: 100%;"
                           value="{{ isset($data->price) ? $data->price : '' }}" placeholder="请输入出发线路">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>是否为特价旅游产品：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <select id="sale" name="sale" class="select">
                        <option value="0" {{$data->sale == "0"? "selected":""}}>否</option>
                        <option value="1" {{$data->sale == "1"? "selected":""}}>是</option>
                    </select>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>共有位子：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input id="total" name="total" type="text" class="input-text" style="width: 100%;"
                           value="{{ isset($data->total) ? $data->total : '' }}" placeholder="请输入出发线路">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>剩余空位：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input id="surplus" name="surplus" type="text" class="input-text" style="width: 100%;"
                           value="{{ isset($data->surplus) ? $data->surplus : '' }}" placeholder="请输入出发线路">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>旅游产品名称：</label>
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
                    date_start: {
                        required: true,
                    },
                    date_end: {
                        required: true,
                    },
                    primecast: {
                        required: true,
                    },
                    price: {
                        required: true,
                    },
                    total:{
                        required: true,
                    },
                    surplus: {
                        required: true,
                    },
                },
                onkeyup: false,
                focusCleanup: true,
                success: "valid",
                submitHandler: function (form) {
                    $(form).ajaxSubmit({
                        type: 'POST',
                        url: "{{ URL::asset('/admin/product/tourGoods/editMoreCalendars')}}",
                        success: function (ret) {
                            console.log(JSON.stringify(ret));
                            if (ret.result) {
                                layer.msg('保存成功', {icon: 1, time: 1000});
                                setTimeout(function () {
                                    var index = parent.layer.getFrameIndex(window.name);
                                    parent.$('.btn-refresh').click();
//                                    console.log('window.name:'+window.name);
//                                    console.log('index:'+index);
                                    parent.layer.close(index);

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