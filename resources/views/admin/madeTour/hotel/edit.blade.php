@extends('admin.layouts.app')

@section('content')
    <div class="page-container">
        <form class="form form-horizontal" method="post" id="form-organization-edit">
            {{csrf_field()}}
            <div class="row cl hidden">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>id：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input id="id" name="id" type="text" class="input-text"
                           value="{{ isset($data['id']) ? $data['id'] : '' }}" placeholder="编号">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>酒店名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input id="name" name="name" type="text" class="input-text" value="{{ isset($data['name']) ? $data['name'] : '' }}" placeholder="请输入酒店名称">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>默认原价：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input id="primecost" name="primecost" type="text" class="input-text" value="{{ isset($data['primecost']) ? $data['primecost'] : '' }}" placeholder="请输入默认原价">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>默认实际价格：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input id="price" name="price" type="text" class="input-text" value="{{ isset($data['price']) ? $data['price'] : '' }}" placeholder="请输入默认实际价格">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>是否显示特价：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <select id="sale" name="sale" class="select">
                        <option value="0" {{$data->sale == "0"? "selected":""}}>否</option>
                        <option value="1" {{$data->sale == "1"? "selected":""}}>是</option>
                    </select>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>单位：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input id="unit" name="unit" type="text" class="input-text" value="{{ isset($data['unit']) ? $data['unit'] : '' }}" placeholder="请输入单位">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>联系方式：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input id="telephone" name="telephone" type="text" class="input-text" value="{{ isset($data['telephone']) ? $data['telephone'] : '' }}" placeholder="请输入联系方式">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>酒店设施：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea id="facilities" name="facilities" class="textarea" placeholder="输入内容..." rows="" cols="" >{{ isset($data->facilities) ? $data->facilities : '' }}</textarea>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"></label>
                <div class="formControls col-xs-8 col-sm-9">
                    <p style="color: red;">以“_”分割</p>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>介绍：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea id="content" name="content" class="textarea" placeholder="输入内容..." rows="" cols="" >{{ isset($data->content) ? $data->content : '' }}</textarea>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>政策：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea id="policy" name="policy" class="textarea" placeholder="输入内容..." rows="" cols="" >{{ isset($data->policy) ? $data->policy : '' }}</textarea>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>酒店地点：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input id="address" name="address" type="text" class="input-text" style="width:50%;" value="{{ isset($data['address']) ? $data['address'] : '' }}" placeholder="请输入旅行社地址">
                    <button type="button" class="btn btn-primary" onclick="searchByStationName()">定位</button>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"></label>
                <div class="formControls col-xs-8 col-sm-9">
                    经度：
                    <input id="lon" name="lon" type="text" class="input-text" style="width:30%;" value="{{ isset($data['lon']) ? $data['lon'] : '' }}" placeholder="请输入经度">
                    维度：
                    <input id="lat" name="lat" type="text" class="input-text" style="width:30%;" value="{{ isset($data['lat']) ? $data['lat'] : '' }}" placeholder="请输入维度">
                    <button type="button" class="btn btn-primary" onclick="initMap()">重新校验</button>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"></label>
                <div class="formControls col-xs-8 col-sm-9">
                    <!--百度地图容器-->
                    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=9x6fsBvnCgvu8Kje8sSGq7ybQaQkZks9"></script>
                    <div style="width:700px;height:250px;border:#ccc solid 1px;font-size:12px" id="map"></div>
                    <p style="color:red;font-weight:600">该地图只为了参考定位经纬度，具体样式以小程序的实际样式为主</p>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>酒店封面图片：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input id="image" name="image" type="text" class="input-text"
                           value="{{ isset($data->image) ? $data->image : '' }}" placeholder="请选择酒店封面图片">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"></label>
                <div class="formControls col-xs-8 col-sm-9">
                    <div id="container">
                        <img id="pickfiles"
                             {{--src="{{URL::asset('/img/upload.png')}}"--}}
                             src="{{ $data->image ? $data->image.'?imageView2/1/w/200/h/100/interlace/1/q/75|imageslim' : URL::asset('/img/upload.png')}}"
                             style="width: 350px;">
                    </div>
                    <div style="font-size: 12px;margin-top: 10px;" class="text-gray">*请上传350*200尺寸图片
                    </div>
                </div>
                <div class="row cl" style="padding-top: 20px;">
                    <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                        <input class="btn btn-primary radius" type="submit" value="保存">
                        <button onClick="layer_close();" class="btn btn-default radius" type="button">取消</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(function () {
            //初始化地图
            var map;
            initMap();

            //获取七牛token
            initQNUploader();

            $("#form-organization-edit").validate({
                rules: {
                    name: {
                        required: true,
                    },
                    address: {
                        required: true,
                    },
                    lon: {
                        required: true,
                    },
                    lat: {
                        required: true,
                    },
                    telephone: {
                        required: true,
                    },
                    image: {
                        required: true,
                    },
                },
                onkeyup: false,
                focusCleanup: false,
                success: "valid",
                submitHandler: function (form) {
                    $(form).ajaxSubmit({
                        type: 'POST',
                        url: "{{ URL::asset('/admin/madeTour/hotel/edit')}}",
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
                        },
                        error: function (XmlHttpRequest, textStatus, errorThrown) {
                            layer.msg('保存失败', {icon: 2, time: 2000});
                            console.log("XmlHttpRequest:" + JSON.stringify(XmlHttpRequest));
                            console.log("textStatus:" + textStatus);
                            console.log("errorThrown:" + errorThrown);
                        }
                    });
                }

            });
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
                        $("#image").val(sourceLink);
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
        }



        //创建和初始化地图函数：
        function initMap(){
            var lon=$('#lon').val();
            var lat=$('#lat').val();
            createMap(lon,lat);//创建地图
            setMapEvent();//设置地图事件
            addMapControl();//向地图添加控件
            addMapOverlay(lon,lat);//向地图添加覆盖物
        }
        function createMap(lon,lat){
            map = new BMap.Map("map");
            map.centerAndZoom(new BMap.Point(lon,lat),15);
        }
        function setMapEvent(){
            map.enableScrollWheelZoom();
            map.enableKeyboard();
            map.enableDragging();
            map.enableDoubleClickZoom()
        }
        function addClickHandler(target,window){
            target.addEventListener("click",function(){
                target.openInfoWindow(window);
            });
        }
        function addMapOverlay(lon,lat){
            var name=$('#name').val()?$('#name').val():"请填写酒店的名字";
            var address=$('#address').val()?$('#address').val():"请填写酒店的地址";
            var markers = [
                {content:address,title:name,imageOffset: {width:-46,height:-21},position:{lat:lat,lng:lon}}
            ];
            for(var index = 0; index < markers.length; index++ ){
                var point = new BMap.Point(markers[index].position.lng,markers[index].position.lat);
                var marker = new BMap.Marker(point,{icon:new BMap.Icon("http://api.map.baidu.com/lbsapi/createmap/images/icon.png",new BMap.Size(20,25),{
                        imageOffset: new BMap.Size(markers[index].imageOffset.width,markers[index].imageOffset.height)
                    })});
                var label = new BMap.Label(markers[index].title,{offset: new BMap.Size(25,5)});
                var opts = {
                    width: 200,
                    title: markers[index].title,
                    enableMessage: false
                };
                var infoWindow = new BMap.InfoWindow(markers[index].content,opts);
                marker.setLabel(label);
                addClickHandler(marker,infoWindow);
                map.addOverlay(marker);
            };
        }
        //向地图添加控件
        function addMapControl(){
            var scaleControl = new BMap.ScaleControl({anchor:BMAP_ANCHOR_BOTTOM_LEFT});
            scaleControl.setUnit(BMAP_UNIT_IMPERIAL);
            map.addControl(scaleControl);
            var navControl = new BMap.NavigationControl({anchor:BMAP_ANCHOR_TOP_LEFT,type:BMAP_NAVIGATION_CONTROL_LARGE});
            map.addControl(navControl);
            var overviewControl = new BMap.OverviewMapControl({anchor:BMAP_ANCHOR_BOTTOM_RIGHT,isOpen:true});
            map.addControl(overviewControl);
        }
        function searchByStationName(){
            map.clearOverlays();//清空原来的标注
            map = new BMap.Map("map");
            var localSearch = new BMap.LocalSearch(map);
            var keyword = $("#address").val();
            localSearch.setSearchCompleteCallback(function (searchResult) {
                var poi = searchResult.getPoi(0);
                $('#lon').val(poi.point.lng);
                $('#lat').val(poi.point.lat);
                map.centerAndZoom(poi.point, 15);
                initMap();
            });
            localSearch.search(keyword);
        }
    </script>
@endsection