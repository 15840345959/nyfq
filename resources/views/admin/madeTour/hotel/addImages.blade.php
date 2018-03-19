@extends('admin.layouts.app')

@section('content')


    <div class="page-container">
        <form class="form form-horizontal" method="post" id="form-goods-edit">
            {{csrf_field()}}
            <div id="tab-system" class="HuiTab">
                <div class="tabBar cl">
                    {{--<span>基本信息</span>--}}
                    <span>添加【旅游定制】酒店图片</span>
                </div>
                <div class="row cl hidden">
                    <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>id：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input id="id" name="id" type="text" class="input-text"
                               value="{{ isset($data->id) ? $data->id : '' }}" placeholder="酒店id">
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
                    <div class="row cl details_black_label">
                        <div class="formControls col-xs-6 col-sm-6">编辑区</div>
                        <div class="formControls col-xs-1 col-sm-1"></div>
                        <div class="formControls col-xs-4 col-sm-4">预览参考区</div>
                        <div class="formControls col-xs-1 col-sm-1"></div>
                    </div>
                    <div class="row cl"  id="container"  style="position: relative;">
                        <div class="formControls col-xs-6 col-sm-6">
                            <div id="banner_details_content"></div>
                            <div>
                                <a href="javascript:" onclick="addDetailImage()">
                                    <div id="banner_details_content"
                                         class="formControls col-xs-12 col-sm-12 detail_add_image">添加图片
                                    </div>
                                </a>
                                <div id="add_detail_image" style="text-align: center;">
                                    <img id="imagePrv_image" src="{{ URL::asset('/img/add_image.png') }}"/>
                                    <input id="add_image" type="hidden"/>
                                    <a href="javascript:" onclick="submitDetailImage()">
                                        <div id="banner_details_content"
                                             class="formControls col-xs-12 col-sm-12 detail_add_button">确认添加
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="formControls col-xs-1 col-sm-1"></div>
                        <div class="formControls col-xs-4 col-sm-4 padding-top-10 ">
                            <div class="teltphone_header">
                                <div class="teltphone_logo">TelePhone</div>
                            </div>
                            <div id="banner_details_show_content" class="details_show"></div>
                            <div class="teltphone_footer">
                                <div class="telephone_button"></div>
                            </div>
                        </div>
                        <div class="formControls col-xs-1 col-sm-1"></div>
                    </div>
                </div>
            </div>
        </form>
    </div>


    <script id="banner_details_content_template" type="text/x-dot-template">
        <div id="banner_details_content_detail" class="formControls col-xs-12 col-sm-12">

            <img src="@{{=it.image}}"/>

            {{--@{{? it.type==0 }}--}}
            {{--<a href="javascript:" onclick="sortUp(@{{=it.index}},@{{=it.id}})" title="上移">--}}
                {{--<div class="formControls col-xs-3 col-sm-3 Hui-iconfont">&#xe6d6;</div>--}}
            {{--</a>--}}
            {{--<a href="javascript:" onclick="delDetial(@{{=it.index}},@{{=it.id}})" title="删除">--}}
                {{--<div class="formControls col-xs-3 col-sm-3 c-red Hui-iconfont">&#xe6a6;</div>--}}
            {{--</a>--}}
            {{--<a href="javascript:" onclick="updateTextDetial(@{{=it.index}},@{{=it.id}})" title="提交编辑">--}}
                {{--<div class="formControls col-xs-3 col-sm-3 c-green  Hui-iconfont">&#xe60c;</div>--}}
            {{--</a>--}}
            {{--<a href="javascript:" onclick="sortDown(@{{=it.index}},@{{=it.id}})" title="下移">--}}
                {{--<div class="formControls col-xs-3 col-sm-3 Hui-iconfont">&#xe6d5;</div>--}}
            {{--</a>--}}
            {{--@{{?? }}--}}
            <a href="javascript:" onclick="sortUp(@{{=it.index}},@{{=it.id}})" title="上移">
                <div class="formControls col-xs-4 col-sm-4 Hui-iconfont">&#xe6d6;</div>
            </a>
            <a href="javascript:" onclick="delDetial(@{{=it.index}},@{{=it.id}})" title="删除">
                <div class="formControls col-xs-4 col-sm-4 c-red Hui-iconfont">&#xe6a6;</div>
            </a>
            <a href="javascript:" onclick="sortDown(@{{=it.index}},@{{=it.id}})" title="下移">
                <div class="formControls col-xs-4 col-sm-4 Hui-iconfont">&#xe6d5;</div>
            </a>
            {{--@{{? }}--}}
        </div>
    </script>
    <script id="banner_details_show_content_template" type="text/x-dot-template">
        <img src="@{{=it.image}}"/>
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
            initQNUploader();
        });

        //初始化七牛上传模块
        function initQNUploader() {
            var uploader = Qiniu.uploader({
                runtimes: 'html5,flash,html4',      // 上传模式，依次退化
                browse_button: 'pickfiles',         // 上传选择的点选按钮，必需
                container: 'container',//上传按钮的上级元素ID
                // 在初始化时，uptoken，uptoken_url，uptoken_func三个参数中必须有一个被设置
                // 切如果提供了多个，其优先级为uptoken > uptoken_url > uptoken_func
                // 其中uptoken是直接提供上传凭证，uptoken_url是提供了获取上传凭证的地址，如果需要定制获取uptoken的过程则可以设置uptoken_func
                uptoken: "{{$upload_token}}", // uptoken是上传凭证，由其他程序生成
                // uptoken_url: '/uptoken',         // Ajax请求uptoken的Url，强烈建议设置（服务端提供）
                // uptoken_func: function(file){    // 在需要获取uptoken时，该方法会被调用
                //    // do something
                //    return uptoken;
                // },
                get_new_uptoken: false,             // 设置上传文件的时候是否每次都重新获取新的uptoken
                // downtoken_url: '/downtoken',
                // Ajax请求downToken的Url，私有空间时使用，JS-SDK将向该地址POST文件的key和domain，服务端返回的JSON必须包含url字段，url值为该文件的下载地址
                unique_names: true,              // 默认false，key为文件名。若开启该选项，JS-SDK会为每个文件自动生成key（文件名）
                // save_key: true,                  // 默认false。若在服务端生成uptoken的上传策略中指定了sava_key，则开启，SDK在前端将不对key进行任何处理
                domain: 'http://twst.isart.me/',     // bucket域名，下载资源时用到，必需
                max_file_size: '100mb',             // 最大文件体积限制
                flash_swf_url: 'path/of/plupload/Moxie.swf',  //引入flash，相对路径
                max_retries: 3,                     // 上传失败最大重试次数
                dragdrop: true,                     // 开启可拖曳上传
                drop_element: 'container',          // 拖曳上传区域元素的ID，拖曳文件或文件夹后可触发上传
                chunk_size: '4mb',                  // 分块上传时，每块的体积
                auto_start: true,                   // 选择文件后自动上传，若关闭需要自己绑定事件触发上传
                //x_vars : {
                //    查看自定义变量
                //    'time' : function(up,file) {
                //        var time = (new Date()).getTime();
                // do something with 'time'
                //        return time;
                //    },
                //    'size' : function(up,file) {
                //        var size = file.size;
                // do something with 'size'
                //        return size;
                //    }
                //},
                init: {
                    'FilesAdded': function (up, files) {
                        plupload.each(files, function (file) {
                            // 文件添加进队列后，处理相关的事情
//                                            alert(alert(JSON.stringify(file)));
                        });
                    },
                    'BeforeUpload': function (up, file) {
                        // 每个文件上传前，处理相关的事情
//                        console.log("BeforeUpload up:" + up + " file:" + JSON.stringify(file));
                    },
                    'UploadProgress': function (up, file) {
                        // 每个文件上传时，处理相关的事情
//                        console.log("UploadProgress up:" + up + " file:" + JSON.stringify(file));
                    },
                    'FileUploaded': function (up, file, info) {
                        // 每个文件上传成功后，处理相关的事情
                        // 其中info是文件上传成功后，服务端返回的json，形式如：
                        // {
                        //    "hash": "Fh8xVqod2MQ1mocfI4S4KpRL6D98",
                        //    "key": "gogopher.jpg"
                        //  }
                        console.log(JSON.stringify(info));
                        var domain = up.getOption('domain');
                        var res = JSON.parse(info);
                        //获取上传成功后的文件的Url
                        var sourceLink = domain + res.key;
                        $("#img").val(sourceLink);
                        $("#pickfiles").attr('src', qiniuUrlTool(sourceLink, "head_icon"));
//                        console.log($("#pickfiles").attr('src'));
                    },
                    'Error': function (up, err, errTip) {
                        //上传出错时，处理相关的事情
                        console.log(err + errTip);
                    },
                    'UploadComplete': function () {
                        //队列文件处理完毕后，处理相关的事情
                    },
                    'Key': function (up, file) {
                        // 若想在前端对每个文件的key进行个性化处理，可以配置该函数
                        // 该配置必须要在unique_names: false，save_key: false时才生效

                        var key = "";
                        // do something with key here
                        return key
                    }
                }
            });
//            编辑新闻详情
            var uploader_1 = Qiniu.uploader({
                runtimes: 'html5,flash,html4',      // 上传模式，依次退化
                browse_button: 'imagePrv_image',         // 上传选择的点选按钮，必需
                container: 'container',//上传按钮的上级元素ID
                // 在初始化时，uptoken，uptoken_url，uptoken_func三个参数中必须有一个被设置
                // 切如果提供了多个，其优先级为uptoken > uptoken_url > uptoken_func
                // 其中uptoken是直接提供上传凭证，uptoken_url是提供了获取上传凭证的地址，如果需要定制获取uptoken的过程则可以设置uptoken_func
                uptoken: "{{$upload_token}}", // uptoken是上传凭证，由其他程序生成
                // uptoken_url: '/uptoken',         // Ajax请求uptoken的Url，强烈建议设置（服务端提供）
                // uptoken_func: function(file){    // 在需要获取uptoken时，该方法会被调用
                //    // do something
                //    return uptoken;
                // },
                get_new_uptoken: false,             // 设置上传文件的时候是否每次都重新获取新的uptoken
                // downtoken_url: '/downtoken',
                // Ajax请求downToken的Url，私有空间时使用，JS-SDK将向该地址POST文件的key和domain，服务端返回的JSON必须包含url字段，url值为该文件的下载地址
                unique_names: true,              // 默认false，key为文件名。若开启该选项，JS-SDK会为每个文件自动生成key（文件名）
                // save_key: true,                  // 默认false。若在服务端生成uptoken的上传策略中指定了sava_key，则开启，SDK在前端将不对key进行任何处理
                domain: 'http://dsyy.isart.me/',     // bucket域名，下载资源时用到，必需
                max_file_size: '100mb',             // 最大文件体积限制
                flash_swf_url: 'path/of/plupload/Moxie.swf',  //引入flash，相对路径
                max_retries: 3,                     // 上传失败最大重试次数
                dragdrop: true,                     // 开启可拖曳上传
                drop_element: 'container',          // 拖曳上传区域元素的ID，拖曳文件或文件夹后可触发上传
                chunk_size: '4mb',                  // 分块上传时，每块的体积
                auto_start: true,                   // 选择文件后自动上传，若关闭需要自己绑定事件触发上传
                //x_vars : {
                //    查看自定义变量
                //    'time' : function(up,file) {
                //        var time = (new Date()).getTime();
                // do something with 'time'
                //        return time;
                //    },
                //    'size' : function(up,file) {
                //        var size = file.size;
                // do something with 'size'
                //        return size;
                //    }
                //},
                init: {
                    'FilesAdded': function (up, files) {
                        plupload.each(files, function (file) {
                            // 文件添加进队列后，处理相关的事情
//                                            alert(alert(JSON.stringify(file)));
                        });
                    },
                    'BeforeUpload': function (up, file) {
                        // 每个文件上传前，处理相关的事情
//                        console.log("BeforeUpload up:" + up + " file:" + JSON.stringify(file));
                    },
                    'UploadProgress': function (up, file) {
                        // 每个文件上传时，处理相关的事情
//                        console.log("UploadProgress up:" + up + " file:" + JSON.stringify(file));
                    },
                    'FileUploaded': function (up, file, info) {
                        // 每个文件上传成功后，处理相关的事情
                        // 其中info是文件上传成功后，服务端返回的json，形式如：
                        // {
                        //    "hash": "Fh8xVqod2MQ1mocfI4S4KpRL6D98",
                        //    "key": "gogopher.jpg"
                        //  }
                        console.log(JSON.stringify(info));
                        var domain = up.getOption('domain');
                        var res = JSON.parse(info);
                        //获取上传成功后的文件的Url
                        var sourceLink = domain + res.key;
                        $("#imagePrv_image").attr('src', sourceLink);
                        $('#add_image').val(sourceLink)
                        // console.log($("#pickfiles").attr('src'));
                    },
                    'Error': function (up, err, errTip) {
                        //上传出错时，处理相关的事情
                        console.log(err + errTip);
                    },
                    'UploadComplete': function () {
                        //队列文件处理完毕后，处理相关的事情
                    },
                    'Key': function (up, file) {
                        // 若想在前端对每个文件的key进行个性化处理，可以配置该函数
                        // 该配置必须要在unique_names: false，save_key: false时才生效

                        var key = "";
                        // do something with key here
                        return key
                    }
                }
            });

//            新闻编辑详情结束

        }

        //        新加图文详情
        if({{$data['id']}}){
            //json转数组
            var str='{{$data['images']}}'
//            alert(str);
            var jsonStr=str.replace(/&quot;/ig, '"')
            var jsonObj = JSON.parse(jsonStr)
            console.log(jsonObj)
            //内容详情页
            LoadDetailsHtml(jsonObj)
        }
        // 内容详情页编辑
        function LoadDetailsHtml(data){
            // console.log("data is : "+JSON.stringify(data))
            for(var i=0;i<data.length;i++){
                data[i]['index']=i
                // console.log('LoadDetailsHtml data['+i+'] is : ' + JSON.stringify((data[i])))
                //编辑
                var interText = doT.template($("#banner_details_content_template").text())
                $("#banner_details_content").append(interText(data[i]))
                //展示
                var interText = doT.template($("#banner_details_show_content_template").text())
                $("#banner_details_show_content").append(interText(data[i]))
            }
        }
        //点击排序-上升
        function sortUp(index,id){
            // console.log('sortUp index is : ' + JSON.stringify((jsonObj[index])))
            //判断如果不是最上面的内容，执行向上操作
            if(index!=0){
                //再交换jsonObj中的位置
                var pack=jsonObj[index-1]
                jsonObj[index-1]=jsonObj[index]
                jsonObj[index]=pack
                for(var i=0;i<jsonObj.length;i++){
                    jsonObj[i]['sort']=i
                }
                for(var i=0;i<jsonObj.length;i++){
                    editGoodsInfoDetailList(jsonObj[i])
                }
                //重新展示
                refresh(jsonObj)
            }
        }
        //点击排序-下降
        function sortDown(index){
             console.log('sortDown index is : ' + JSON.stringify((jsonObj[index])))
            //判断如果不是最上面的内容，执行向上操作
            if(index!=jsonObj.length-1){
                //再交换jsonObj中的位置
                var pack=jsonObj[index+1]
                jsonObj[index+1]=jsonObj[index]
                jsonObj[index+1]['sort']=index+1
                jsonObj[index]=pack
                jsonObj[index]['sort']=index
                for(var i=0;i<jsonObj.length;i++){
                    jsonObj[i]['sort']=i
                }
                for(var i=0;i<jsonObj.length;i++){
                    editGoodsInfoDetailList(jsonObj[i])
                }
                //重新展示
                refresh(jsonObj)
            }
        }

        //删除这条数据
        function delDetial(index, id) {
            console.log('index:'+index);
            console.log('jsonObj.length:'+jsonObj.length)
            layer.confirm('确认要删除这条数据吗？', function () {
                //进行后台删除
                var param = {
                    id: id,
                    _token: "{{ csrf_token() }}"
                }
//                console.log('param is : ' + JSON.stringify(param))
                delHotelImage('{{URL::asset('')}}', param, function (ret) {
                    if (ret.result == true) {
                        layer.msg(ret.msg, {icon: 1, time: 1000});
//                         console.log('sortDown index is : ' + JSON.stringify((jsonObj[index-1])))
                        for (var i = 0; i < jsonObj.length; i++) {
//                            console.log('jsonObj.length : ' + JSON.stringify((jsonObj.length)))
                            if (i == index) {
                                console.log('jsonObj.splice : ' + JSON.stringify(jsonObj[i]))
                                jsonObj.splice(i, 1);//从下标为i的元素开始，连续删除1个元素
                            }
                        }
                        console.log('jsonObj  : ' + JSON.stringify(jsonObj))
                        //重新展示
                        refresh(jsonObj)
                    } else {
                        layer.msg(ret.msg, {icon: 2, time: 1000})
                    }
                })
            });
        }



        //显示添加图片
        function addDetailImage(){
            $('#add_detail_text').hide();
            $('#add_detail_image').show();
            $('#add_detail_video').hide();
        }
        //确认添加图片
        function submitDetailImage() {
            var add_image=$("#add_image").val();
            if(add_image==''){
                layer.msg('添加失败，请上传图片', {icon: 2, time: 2000});
            }
            else{
                var detail={};
                detail['hotel_goods_id']='{{$data['id']}}';
                detail['image']=add_image;
//                detail['type']=1;
                detail['sort']=jsonObj.length;
                console.log("detail is ： "+JSON.stringify(detail))
//                jsonObj.push(detail);
                addHotelImageList(detail,function(ret){
                    if (ret.result == true) {
                        jsonObj.push(ret.ret);
                        //重新展示
                        $('#add_image').val('')
                        $("#imagePrv_image").attr('src', '{{ URL::asset('/img/add_image.png') }}')
                        refresh(jsonObj)
                    } else {
                        layer.msg(ret.msg, {icon: 2, time: 1000})
                    }
                })
            }
        }

        //刷新页面
        function refresh(jsonObj){
            $("#banner_details_content").html('')
            $("#banner_details_show_content").html('')
            LoadDetailsHtml(jsonObj)
        }
        //提交后台编辑数据
        function editGoodsInfoDetailList(jsonObj){
            console.log("jsonObj ret is ： "+JSON.stringify(jsonObj))
            var param = {
                sort:jsonObj['sort'],
                image:jsonObj['image'],
                id: jsonObj['id'],
                _token: "{{ csrf_token() }}"
            }
            console.log("提交后台编辑数据 ： "+JSON.stringify(param))
            addHotelImage('{{URL::asset('')}}', param, function (ret) {
                 console.log("addHotelImage ret is ： "+JSON.stringify(ret))
                if (ret.result == true) {
                    return ret.result;
                } else {
                    layer.msg(ret.msg, {icon: 2, time: 1000})
                    return ret.result;
                }
            })
        }
        //提交后台添加数据
        function addHotelImageList(detail,callBack){
            var param={
                _token: "{{ csrf_token() }}",
                hotel_goods_id:detail['hotel_goods_id'],
                image:detail['image'],
//                type:detail['type'],
                sort:detail['sort']
            }
            console.log("addHotelImageList ret is ： "+JSON.stringify(param))
            addHotelImage('{{URL::asset('')}}', param, callBack)
        }



    </script>
@endsection