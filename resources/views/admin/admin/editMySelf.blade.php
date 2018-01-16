@extends('admin.layouts.app')

@section('content')
    @if(Session::has('success'))
        <div class="Huialert Huialert-success"><i class="Hui-iconfont">&#xe6a6;</i>{{ Session::get('success') }}</div>
    @endif
    @if(Session::has('error'))
        <div class="Huialert Huialert-error"><i class="Hui-iconfont">&#xe6a6;</i>{{ Session::get('error') }}</div>
    @endif
    <div class="page-container">
        <form class="form form-horizontal" method="post" id="form-admin-edit">
            {{csrf_field()}}
            <div class="row cl hidden">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>id：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input id="id" name="id" type="text" class="input-text" readonly
                           value="{{ isset($data['id']) ? $data['id'] : '' }}" placeholder="管理员id">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>管理员：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input id="nick_name" name="nick_name" type="text" class="input-text"
                           value="{{ isset($data['nick_name']) ? $data['nick_name'] : '' }}" placeholder="请输入管理员姓名">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>联系电话：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input id="telephone" name="telephone" type="text" class="input-text"
                           value="{{ isset($data['telephone']) ? $data['telephone'] : '' }}" placeholder="请输入联系电话">
                </div>
            </div>

            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                    <input class="btn btn-primary radius" type="submit" value="保存管理员">
                </div>
            </div>
        </form>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(function () {

        })
        $("#form-admin-edit").validate({
            rules:{
                nick_name:{
                    required:true,
                },
                telephone:{
                    required:true,
                    number:true,
                    maxlength:11,
                    minlength:11
                },
            },
            onkeyup:false,
            focusCleanup:false,
            success:"valid",
            submitHandler:function(form){
                $(form).ajaxSubmit();
                var index = parent.layer.getFrameIndex(window.name);
                parent.$('.btn-refresh').click();
                parent.layer.close(index);
            }
        });
    </script>
@endsection