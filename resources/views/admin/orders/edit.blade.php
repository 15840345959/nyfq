@extends('admin.layouts.app')

@section('content')
    <div class="page-container">
        <form class="form form-horizontal" method="post" id="form-banner-edit">
            {{csrf_field()}}
            <div id="tab-system" class="HuiTab">
                <div class="tabBar cl">
                    <span>用户信息</span>
                    <span>内容详情</span>
                </div>
                <div class="row cl hidden">
                    <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>id：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input id="id" name="id" type="text" class="input-text"
                               value="{{ isset($data['id']) ? $data['id'] : '' }}" placeholder="Banner_id">
                    </div>
                </div>
                <div class="tabCon">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>标题：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input id="title" name="title" type="text" class="input-text"
                                   {{--value="{{ isset($data['admin']['nick_name']) ? $data['admin']['nick_name'] : '' }}"--}}
                                   placeholder="请输入标题">
                        </div>
                    </div>
                    <div class="row cl" id="container">
                        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>图片上传：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{--@if($data['admin']['avatar'])--}}
                                {{--<img id="imagePrv" src="{{$data['admin']['avatar']}}" width="210"/>--}}
                            {{--@else--}}
                                {{--<img id="imagePrv" src="{{ URL::asset('/img/add_picture.png') }}"/>--}}
                            {{--@endif--}}
                            <span class="c-red margin-left-5">*请上传900*500尺寸图片</span>
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">类型：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{--@if($data['type']==0)--}}
                                {{--<input type="text" value="正常详情页" class="input-text no_click" readonly/>--}}
                            {{--@else--}}
                                {{--<input type="text" value="自定义链接" class="input-text no_click" readonly/>--}}
                            {{--@endif--}}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>排序：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{--<input id="sort" name="sort" type="text" class="input-text"--}}
                                   {{--value="{{ isset($data['sort']) ? $data['sort'] : '' }}" placeholder="请输入排序，越大越靠前">--}}
                        </div>
                    </div>
                    <div class="row cl">
                        <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                            <button class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存
                            </button>
                            <button onClick="layer_close();" class="btn btn-default radius" type="button">取消</button>
                        </div>
                    </div>
                </div>
                <style>
                    #details_black img, video {
                        width: 100%;
                    }

                    #details_black .details_black_label {
                        text-align: center;
                        font-weight: bold;
                    }

                    #details_black .detail_add_text {
                        line-height: 30px;
                        background: #5eb95e;
                        text-align: center;
                        color: #fff;
                    }

                    #details_black .detail_add_text:hover {
                        background: #429842;
                    }

                    #details_black .detail_add_image {
                        line-height: 30px;
                        background: #dd514c;
                        text-align: center;
                        color: #fff;
                    }

                    #details_black .detail_add_image:hover {
                        background: #c62b26;
                    }

                    #details_black .detail_add_video {
                        line-height: 30px;
                        background: #f37b1d;
                        text-align: center;
                        color: #fff;
                    }

                    #details_black .detail_add_video:hover {
                        background: #c85e0b;
                    }

                    #details_black .detail_add_button {
                        line-height: 30px;
                        background: #000;
                        text-align: center;
                        color: #fff;
                    }

                    #details_black .imagePrv {
                        width: 100px;
                        height: 100px;
                    }

                    .details_show {
                        /*width:375px;*/
                        height: 500px;
                        overflow-y: scroll;
                        margin: 0 auto;
                        border: 3px solid #000;
                    }

                    #banner_details_content_detail a div {
                        margin: 5px 0;
                        line-height: 25px;
                        text-align: center;
                        font-size: 19px;
                        border: 1px solid #ddd;
                    }

                    #banner_details_content_detail a div:hover {
                        background: #ddd;
                    }

                    #banner_details_content_detail a div:active {
                        background: #666;
                    }

                    .teltphone_header {
                        height: 30px;
                        background: #000;
                        border-radius: 10px 10px 0 0;
                    }

                    .teltphone_logo {
                        text-align: center;
                        line-height: 30px;
                        font-weight: bold;
                        color: #ddd;
                        font-size: 16px;
                    }

                    .teltphone_footer {
                        height: 30px;
                        background: #000;
                        border-radius: 0 0 10px 10px;
                        padding-top: 10px;
                    }

                    .telephone_button {
                        width: 50px;
                        height: 10px;
                        margin: 0px auto;
                        border: #ddd 2px solid;
                        background: #000;
                        border-radius: 10px;
                    }
                </style>
                <div class="tabCon" id="details_black">
                    {{--@if($data['type']==0)--}}
                        {{--<div class="row cl details_black_label">--}}
                            {{--<div class="formControls col-xs-6 col-sm-6">编辑区</div>--}}
                            {{--<div class="formControls col-xs-1 col-sm-1"></div>--}}
                            {{--<div class="formControls col-xs-4 col-sm-4">预览参考区</div>--}}
                            {{--<div class="formControls col-xs-1 col-sm-1"></div>--}}
                        {{--</div>--}}
                        {{--<div class="row cl">--}}
                            {{--<div class="formControls col-xs-6 col-sm-6">--}}
                                {{--<div id="banner_details_content"></div>--}}
                                {{--<div id="container">--}}
                                    {{--<a href="javascript:" onclick="addDetailText()">--}}
                                        {{--<div id="banner_details_content"--}}
                                             {{--class="formControls col-xs-4 col-sm-4 detail_add_text">添加文本--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                    {{--<a href="javascript:" onclick="addDetailImage()">--}}
                                        {{--<div id="banner_details_content"--}}
                                             {{--class="formControls col-xs-4 col-sm-4 detail_add_image">添加图片--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                    {{--<a href="javascript:" onclick="addDetailVideo()">--}}
                                        {{--<div id="banner_details_content"--}}
                                             {{--class="formControls col-xs-4 col-sm-4 detail_add_video">添加视频--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                    {{--<div id="add_detail_text">--}}
                                        {{--<textarea name="" id="add_text" wrap="\n" class="textarea"--}}
                                                  {{--style="resize:vertical;" placeholder="请填写内容" dragonfly="true"--}}
                                                  {{--nullmsg="内容不能为空！"></textarea>--}}
                                        {{--<a href="javascript:" onclick="submitDetailText()">--}}
                                            {{--<div id="banner_details_content"--}}
                                                 {{--class="formControls col-xs-12 col-sm-12 detail_add_button">确认添加--}}
                                            {{--</div>--}}
                                        {{--</a>--}}
                                    {{--</div>--}}
                                    {{--<div id="add_detail_image" style="text-align: center;" hidden>--}}
                                        {{--<img id="imagePrv_image" src="{{ URL::asset('/img/add_image.png') }}"/>--}}
                                        {{--<input id="add_image" type="hidden"/>--}}
                                        {{--<a href="javascript:" onclick="submitDetailImage()">--}}
                                            {{--<div id="banner_details_content"--}}
                                                 {{--class="formControls col-xs-12 col-sm-12 detail_add_button">确认添加--}}
                                            {{--</div>--}}
                                        {{--</a>--}}
                                    {{--</div>--}}
                                    {{--<div id="add_detail_video" style="text-align: center;" hidden>--}}
                                        {{--<img id="imagePrv_video" src="{{ URL::asset('/img/add_image.png') }}"/>--}}
                                        {{--<video src="" id="videoPrv" controls="controls" hidden>--}}
                                            {{--您的浏览器不支持 video 标签。--}}
                                        {{--</video>--}}
                                        {{--<div class="progress-bar"><span class="sr-only"></span></div>--}}
                                        {{--<input id="add_video" type="hidden"/>--}}
                                        {{--<a href="javascript:" onclick="submitDetailVideo()">--}}
                                            {{--<div id="banner_details_content"--}}
                                                 {{--class="formControls col-xs-12 col-sm-12 detail_add_button">确认添加--}}
                                            {{--</div>--}}
                                        {{--</a>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="formControls col-xs-1 col-sm-1"></div>--}}
                            {{--<div class="formControls col-xs-4 col-sm-4 padding-top-10 ">--}}
                                {{--<div class="teltphone_header">--}}
                                    {{--<div class="teltphone_logo">TelePhone</div>--}}
                                {{--</div>--}}
                                {{--<div id="banner_details_show_content" class="details_show"></div>--}}
                                {{--<div class="teltphone_footer">--}}
                                    {{--<div class="telephone_button"></div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="formControls col-xs-1 col-sm-1"></div>--}}
                        {{--</div>--}}
                    {{--@else--}}
                        {{--<div class="row cl">--}}
                            {{--<label class="form-label col-xs-4 col-sm-2">外链地址：</label>--}}
                            {{--<div class="formControls col-xs-8 col-sm-9">--}}
                                {{--<input id="link" name="link" type="text" class="input-text"--}}
                                       {{--value="{{ isset($data['link']) ? $data['link'] : '' }}" placeholder="请输入外链地址">--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="row cl">--}}
                            {{--<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">--}}
                                {{--<button class="btn btn-primary radius" type="submit"><i--}}
                                            {{--class="Hui-iconfont">&#xe632;</i> 保存--}}
                                {{--</button>--}}
                                {{--<button onClick="layer_close();" class="btn btn-default radius" type="button">取消--}}
                                {{--</button>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--@endif--}}
                </div>
            </div>
        </form>
    </div>
    <script id="banner_details_content_template" type="text/x-dot-template">
        <div id="banner_details_content_detail" class="formControls col-xs-12 col-sm-12">

        </div>
    </script>
    <script id="banner_details_show_content_template" type="text/x-dot-template">
        @{{? it.type==0 }}
        <div>@{{=it.content}}</div>
        @{{?? it.type==1 }}
        <img src="@{{=it.content}}"/>
        @{{?? it.type==2 }}
        <video src="@{{=it.content}}" controls="controls">
            您的浏览器不支持 video 标签。
        </video>
        @{{? }}
    </script>

@endsection

@section('script')
    <script type="text/javascript">
        $(function () {
            $('.skin-minimal input').iCheck({
                checkboxClass: 'icheckbox-blue',
                radioClass: 'iradio-blue',
                increaseArea: '20%'
            });
            $("#tab-system").Huitab({
                index: 0
            });
            //获取七牛token
            // initQNUploader();
            $("#form-banner-edit").validate({
                rules: {
                    title: {
                        required: true,
                    },
                    sort: {
                        required: true,
                        digits: true,
                    },
                    image: {
                        required: true,
                    }
                },
                onkeyup: false,
                focusCleanup: false,
                success: "valid",
                submitHandler: function (form) {
                    $('.btn-primary').html('<i class="Hui-iconfont">&#xe634;</i> 保存中...')
                    $(form).ajaxSubmit({
                        type: 'POST',
                        url: "{{ URL::asset('/admin/banner/edit')}}",
                        success: function (ret) {
                            // console.log(JSON.stringify(ret));
                            if (ret.result) {
                                layer.msg(ret.msg, {icon: 1, time: 2000});
                                setTimeout(function () {
                                    var index = parent.layer.getFrameIndex(window.name);
                                    parent.$('.btn-refresh').click();
                                    // parent.layer.close(index);
                                }, 1000)
                            } else {
                                layer.msg(ret.msg, {icon: 2, time: 2000});
                            }
                            $('.btn-primary').html('<i class="Hui-iconfont">&#xe632;</i> 保存')
                        },
                        error: function (XmlHttpRequest, textStatus, errorThrown) {
                            layer.msg('保存失败', {icon: 2, time: 2000});
                            console.log("XmlHttpRequest:" + JSON.stringify(XmlHttpRequest));
                            console.log("textStatus:" + textStatus);
                            console.log("errorThrown:" + errorThrown);
                            $('.btn-primary').html('<i class="Hui-iconfont">&#xe632;</i> 保存')
                        }
                    });
                }

            });
        });


        // 内容详情页编辑
        function LoadDetailsHtml(data) {
            // console.log("data is : "+JSON.stringify(data))
            for (var i = 0; i < data.length; i++) {
                data[i]['index'] = i
                // console.log('LoadDetailsHtml data['+i+'] is : ' + JSON.stringify((data[i])))
                //编辑
                var interText = doT.template($("#banner_details_content_template").text())
                $("#banner_details_content").append(interText(data[i]))
                //展示
                var interText = doT.template($("#banner_details_show_content_template").text())
                $("#banner_details_show_content").append(interText(data[i]))
            }
        }

        //提交修改后的文本
        function updateTextDetial(index) {
            var content = $('#text_detail_' + index).val();
            jsonObj[index]['content'] = content;
            for (var i = 0; i < jsonObj.length; i++) {
                editBannerDetailList(jsonObj[i])
            }
            //重新展示
            refresh(jsonObj)
        }

        //显示添加文本
        function addDetailText() {
            $('#add_detail_text').show();
            $('#add_detail_image').hide();
            $('#add_detail_video').hide();
        }

        //确认添加文本
        function submitDetailText() {
            var add_text = $('#add_text').val()
            if (add_text == '') {
                layer.msg('添加失败，内容不能为空', {icon: 2, time: 2000});
            }
            else {
                var detail = {};
                detail['banner_id'] = '{{$data['id']}}';
                detail['content'] = add_text;
                detail['type'] = 0;
                detail['sort'] = jsonObj.length;
//                jsonObj.push(detail);
                addBannerDetailList(detail, function (ret) {
                    if (ret.result == true) {
                        //重新展示
                        $('#add_text').val('')
                        jsonObj.push(ret.ret);
                        refresh(jsonObj)
                    } else {
                        layer.msg(ret.msg, {icon: 2, time: 1000})
                    }
                })
            }
        }

        //显示添加图片
        function addDetailImage() {
            $('#add_detail_text').hide();
            $('#add_detail_image').show();
            $('#add_detail_video').hide();
        }

        //确认添加图片
        function submitDetailImage() {
            var add_image = $("#add_image").val();
            if (add_image == '') {
                layer.msg('添加失败，请上传图片', {icon: 2, time: 2000});
            }
            else {
                var detail = {};
                detail['banner_id'] = '{{$data['id']}}';
                detail['content'] = add_image;
                detail['type'] = 1;
                detail['sort'] = jsonObj.length;
//                jsonObj.push(detail);
                addBannerDetailList(detail, function (ret) {
                    if (ret.result == true) {
                        //重新展示
                        $('#add_image').val('')
                        $("#imagePrv_image").attr('src', '{{ URL::asset('/img/add_image.png') }}')
                        jsonObj.push(ret.ret);
                        refresh(jsonObj)
                    } else {
                        layer.msg(ret.msg, {icon: 2, time: 1000})
                    }
                })
            }
        }

        //显示添加视频
        function addDetailVideo() {
            $('#add_detail_text').hide();
            $('#add_detail_image').hide();
            $('#add_detail_video').show();
        }

        //确认添加视频
        function submitDetailVideo() {
            var add_video = $("#add_video").val();
            if (add_video == '') {
                layer.msg('添加失败，请上传视频', {icon: 2, time: 2000});
            }
            else {
                var detail = {};
                detail['banner_id'] = '{{$data['id']}}';
                detail['content'] = add_video;
                detail['type'] = 2;
                detail['sort'] = jsonObj.length;
//                jsonObj.push(detail);
                addBannerDetailList(detail, function (ret) {
                    if (ret.result == true) {
                        //重新展示
                        $('#add_video').val('')
                        $('#videoPrv').attr('src', '')
                        $('#videoPrv').hide()
                        $('#imagePrv_video').show()
                        $('.sr-only').css('width', '0%');
                        jsonObj.push(ret.ret);
                        refresh(jsonObj)
                    } else {
                        layer.msg(ret.msg, {icon: 2, time: 1000})
                    }
                })
            }
        }

        //刷新页面
        function refresh(jsonObj) {
            $("#banner_details_content").html('')
            $("#banner_details_show_content").html('')
            LoadDetailsHtml(jsonObj)
        }

        //提交后台编辑数据
        function editBannerDetailList(jsonObj) {
            var param = {
                sort: jsonObj['sort'],
                content: jsonObj['content'],
                id: jsonObj['id'],
                _token: "{{ csrf_token() }}"
            }
            editBannerDetail('{{URL::asset('')}}', param, function (ret) {
                // console.log("editBannerDetail ret is ： "+JSON.stringify(ret))
                if (ret.result == true) {
                    return ret.result;
                } else {
                    layer.msg(ret.msg, {icon: 2, time: 1000})
                    return ret.result;
                }
            })
        }

        //提交后台添加数据
        function addBannerDetailList(detail, callBack) {
            var param = {
                _token: "{{ csrf_token() }}",
                banner_id: detail['banner_id'],
                content: detail['content'],
                type: detail['type'],
                sort: detail['sort']
            }
            editBannerDetail('{{URL::asset('')}}', param, callBack)
        }
    </script>
@endsection