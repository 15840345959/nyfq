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
                    <input id="id" name="id" type="text" class="input-text"
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
            @if($data['id']!=1&&$admin['admin']==1)
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>角色：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <select id="admin" name="admin" class="select">
                        <option value="0" {{$data['admin'] == "0"? "selected":""}}>普通管理员</option>
                        <option value="1" {{$data['admin'] == "1"? "selected":""}}>超级管理员</option>
                    </select>
                </div>
            </div>
            @endif
            @if(!isset($data['id']))
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2"></label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <span class="grey-font">新建管理员的默认密码为Aa123456</span>
                    </div>
                </div>
            @endif
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                    <button class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存</button>
                    <button onClick="layer_close();" class="btn btn-default radius" type="button">取消</button>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(function () {

        });
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
                    $('#error').hide();
                    $('.btn-primary').html('<i class="Hui-iconfont">&#xe634;</i> 保存中...')
                    $(form).submit();
            }
        });
    </script>
@endsection