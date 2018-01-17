@extends('admin.layouts.app')

@section('content')
    @if(Session::has('success'))
        <div class="Huialert Huialert-success"><i class="Hui-iconfont">&#xe6a6;</i>{{ Session::get('success') }}</div>
    @endif
    @if(Session::has('error'))
        <div class="Huialert Huialert-error"><i class="Hui-iconfont">&#xe6a6;</i>{{ Session::get('error') }}</div>
    @endif
    <div class="Huialert Huialert-error" id="error" hidden></div>
    <div class="page-container">
        <form class="form form-horizontal" method="post" id="form-admin-edit">
            {{csrf_field()}}
            <div id="tab-system" class="HuiTab">
                <div class="tabBar cl">
                    <span>基本信息</span>
                    <span>修改密码</span>
                </div>
                <div class="row cl hidden">
                    <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>id：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input id="id" name="id" type="text" class="input-text" readonly
                               value="{{ isset($data['id']) ? $data['id'] : '' }}" placeholder="管理员id">
                    </div>
                </div>
                <div class="tabCon">
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
                </div>
                <div class="tabCon">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>原密码：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input id="password" name="password" type="password" class="input-text" placeholder="请输入原密码">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>新密码：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input id="new_password" name="new_password" type="password" class="input-text" placeholder="请输入新密码">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>确认密码：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input id="confirm_password" name="confirm_password" type="password" class="input-text" placeholder="请输入确认密码">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                    <button class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存</button>
                    <button onClick="layer_close();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(function(){
            $('.skin-minimal input').iCheck({
                checkboxClass: 'icheckbox-blue',
                radioClass: 'iradio-blue',
                increaseArea: '20%'
            });
            $("#tab-system").Huitab({
                index:0
            });
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
                password:{
                    required:true,
                },
                new_password:{
                    required:true,
                },
                confirm_password:{
                    required:true,
                },
            },
            onkeyup:false,
            focusCleanup:false,
            success:"valid",
            submitHandler:function(form){
                if($('#password').val()!=''){
                    var password=$('#password').val();
                    var new_password=$('#new_password').val();
                    var confirm_password=$('#confirm_password').val();
                    if(new_password!=confirm_password){
                        $('#error').show();
                        $('#error').html('<i class="Hui-iconfont">&#xe6a6;</i>密码修改失败，确认密码与新密码不相符')
                    }
                    else{
                        $('#error').hide();
                        $('.btn-primary').html('<i class="Hui-iconfont">&#xe634;</i> 保存中...')
                        $(form).submit();
                    }
                }
                else{
                    $('#error').hide();
                    $('.btn-primary').html('<i class="Hui-iconfont">&#xe634;</i> 保存中...')
                    $(form).submit();
                }
            }
        });
    </script>
@endsection