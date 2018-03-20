@extends('admin.layouts.app')

@section('content')



    <div class="page-container">
        <form class="form form-horizontal" id="form-admin-add">
            {{csrf_field()}}
            <div class="row cl hidden">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>id：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input id="id" name="id" type="text" class="input-text"
                           value="{{ isset($data->id) ? $data->id : '' }}" placeholder="定制套餐id">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input id="name" name="name" type="text" class="input-text"
                           value="{{ isset($data->name) ? $data->name : '' }}" placeholder="请输入名称">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>描述：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea id="desc" name="desc" class="textarea" placeholder="请输入描述..." rows="" cols="" >{{ isset($data->desc) ? $data->desc : '' }}</textarea>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>酒店名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <select id="hotel_id" name="hotel_id" class="select">
                        @foreach($hotel as $hotel)
                            <option value="{{ isset($hotel->id) ? $hotel->id : '' }}">{{ isset($hotel->name) ? $hotel->name : '' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>飞机公司名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <select id="airplane_id" name="airplane_id" class="select">
                        @foreach($plane as $plane)
                            <option value="{{ isset($plane->id) ? $plane->id : '' }}">{{ isset($plane->company) ? $plane->company : '' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>车导型号名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <select id="car_id" name="car_id" class="select">
                        @foreach($car as $car)
                            <option value="{{ isset($car->id) ? $car->id : '' }}">{{ isset($car->name) ? $car->name : '' }}</option>
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
                    desc: {
                        required: true,
                    },
                },
                onkeyup: false,
                focusCleanup: true,
                success: "valid",
                submitHandler: function (form) {
                    $(form).ajaxSubmit({
                        type: 'POST',
                        url: "{{ URL::asset('/admin/madeTour/customization/edit')}}",
                        success: function (ret) {
                            console.log(JSON.stringify(ret));
                            if (ret.result) {
                                layer.msg('保存成功', {icon: 1, time: 1000});
                                setTimeout(function () {
                                    var index = parent.layer.getFrameIndex(window.name);
                                    parent.$('.btn-refresh').click();
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