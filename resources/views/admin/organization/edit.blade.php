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
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>旅行社名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input id="name" name="name" type="text" class="input-text" value="{{ isset($data['name']) ? $data['name'] : '' }}" placeholder="请输入旅行社名称">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>旅行社地址：</label>
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
            //初始化地图
            var map;
            initMap();
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
                },
                onkeyup: false,
                focusCleanup: false,
                success: "valid",
                submitHandler: function (form) {
                    $(form).ajaxSubmit({
                        type: 'POST',
                        url: "{{ URL::asset('/admin/organization/edit')}}",
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
                            layer.msg('保存失败', {icon: 1, time: 2000});
                            console.log("XmlHttpRequest:" + JSON.stringify(XmlHttpRequest));
                            console.log("textStatus:" + textStatus);
                            console.log("errorThrown:" + errorThrown);
                        }
                    });
                }

            });
        });

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
            var name=$('#name').val()?$('#name').val():"请填写旅行社的名字";
            var address=$('#address').val()?$('#address').val():"请填写旅行社的地址";
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