@extends('admin.layouts.app')

@section('content')
    <div class="page-container">
        <form class="form form-horizontal" method="post" id="form-member-edit">
            {{csrf_field()}}
            <div class="row cl">
                <label class="col-xs-4 col-sm-2"></label>
                <div class="col-xs-8 col-sm-8">
                    <div class="panel panel-default" style="padding-left:0px;padding-right:0px;">
                        <div class="panel-header">
                            @if($data['user_id']['avatar'])
                                <img src="{{$data['user_id']['avatar']}}" class="avatar radius size-L" />
                            @else
                                <img src="{{URL::asset('/img/default_headicon.png')}}" class="avatar radius size-L" />
                            @endif
                            &nbsp;{{$data['user_id']['nick_name']}}
                        </div>
                        <div class="panel-body">{{$data['content']}}</div>
                    </div>
                </div>
            </div>
            {{--@if($data['share'])--}}
            {{--<div class="row cl">--}}
                {{--<label class="form-label col-xs-4 col-sm-2">分享者：</label>--}}
                {{--<div class="formControls col-xs-8 col-sm-9">--}}
                    {{--<input type="text" readonly class="input-text" value="{{ $data['share']['nick_name'] }}">--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--@endif--}}
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