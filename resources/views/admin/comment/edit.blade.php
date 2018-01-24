@extends('admin.layouts.app')

@section('content')
    <div class="page-container">
        <form class="form form-horizontal" method="post" id="form-comment-edit">
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
                    @if($data['media'])
                        <ul>
                            @foreach($data['media'] as $media)
                            <li class="col-xs-3 col-sm-3 mt-10">
                                @if($media['type']==1)
                                    <img src="{{$media['content']}}" style="width:150px;height:150px;" />
                                @else
                                    <video src="{{$media['content']}}" controls="controls" style="width:150px;height:150px;" >
                                        您的浏览器不支持 video 标签。
                                    </video>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    @endif
                    <div style="clear: both;" ></div>
                    @if($data['replies'])
                        @foreach($data['replies'] as $replies)
                            <div class="panel panel-default mt-10" style="padding-left:0px;padding-right:0px;">
                                <div class="panel-header">回复：
                                    @if($replies['user_id']['avatar'])
                                        <img src="{{$replies['user_id']['avatar']}}" class="avatar radius size-L" />
                                    @else
                                        <img src="{{URL::asset('/img/default_headicon.png')}}" class="avatar radius size-L" />
                                    @endif
                                    &nbsp;{{$replies['user_id']['nick_name']}}
                                </div>
                                <div class="panel-body">{{$replies['content']}}</div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                    @if(!$data['examine'])
                        <button onClick="comment_editDo('{{$data['id']}}')"  class="btn btn-success radius" type="button">审核通过</button>
                    @endif
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

        /* 点击审核通过 */
        function comment_editDo(id) {
            var param = {
                id: id,
                _token: "{{ csrf_token() }}"
            }
            examineComment('{{URL::asset('')}}', param, function (ret) {
                // console.log("examineComment ret is : "+JSON.stringify(ret));
                if (ret.result == true) {
                    layer.msg(ret.msg, {icon: 1, time: 1000});
                    setTimeout(function () {
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.$('.btn-refresh').click();
                        // parent.layer.close(index);
                    }, 1000)
                } else {
                    layer.msg(ret.msg, {icon: 2, time: 1000})
                }
            })
        }
    </script>
@endsection