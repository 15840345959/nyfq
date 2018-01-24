@extends('admin.layouts.app')

@section('content')
    <style>
        .member-image{
            width:100px;
            height:100px;
            border-radius: 100%;
        }
    </style>
    <div class="page-container">
        <form class="form form-horizontal" method="post" id="form-member-edit">
            {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">头像：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    @if($data['avatar'])
                        <img src="{{$data['avatar']}}" class="member-image" />
                    @else
                        <img src="{{URL::asset('/img/default_headicon.png')}}" class="member-image" />
                    @endif
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">昵称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" readonly class="input-text" value="{{ isset($data['nick_name']) ? $data['nick_name'] : '' }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">电话：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" readonly class="input-text" value="{{ isset($data['telephone']) ? $data['telephone'] : '' }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">身份证：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" readonly class="input-text" value="{{ isset($data['id_card']) ? $data['id_card'] : '' }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">性别：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" readonly class="input-text" value="{{ isset($data['gender']) ? $data['gender']==1?'男':'女' : '' }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">邮箱地址：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" readonly class="input-text" value="{{ isset($data['email']) ? $data['email'] : '' }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">护照：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" readonly class="input-text" value="{{ isset($data['passport']) ? $data['passport'] : '' }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">签到天数：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" readonly class="input-text" value="{{ isset($data['sign']) ? $data['sign'] : '' }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">积分：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" readonly class="input-text" value="{{ isset($data['integral']) ? $data['integral'] : '' }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">旅行社：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" readonly class="input-text" value="{{ isset($data['organization']) ? $data['organization']['name'] : '没有指定旅行社' }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">类别：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" readonly class="input-text" value="{{ $data['type']==0 ? '游客' : '管理员' }}">
                </div>
            </div>
            @if($data['share'])
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">分享者：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" readonly class="input-text" value="{{ $data['share']['nick_name'] }}">
                </div>
            </div>
            @endif
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                    <button onClick="layer_close();" class="btn btn-default radius" type="button">返回</button>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(function () {
        });
    </script>
@endsection