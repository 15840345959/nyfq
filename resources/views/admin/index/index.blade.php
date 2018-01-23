@extends('admin.layouts.app')

@section('content')

    <header class="navbar-wrapper">
        <div class="navbar navbar-fixed-top">
            <div class="container-fluid cl"><a class="logo navbar-logo f-l mr-10 hidden-xs"
                                               href="/aboutHui.shtml">辽宁南洋风情</a>
                <a class="logo navbar-logo-m f-l mr-10 visible-xs" href="#"></a>
                <span class="logo navbar-slogan f-l mr-10 hidden-xs">v1.3</span>
                <a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs" href="javascript:;">&#xe667;</a>
                <nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
                    <ul class="cl">
                        @if($admin['nick_name']==1)
                            <li>超级管理员</li>
                        @else
                            <li>普通管理员</li>
                        @endif
                        <li class="dropDown dropDown_hover">
                            <a href="#" class="dropDown_A">{{$admin['nick_name']}}<i class="Hui-iconfont">&#xe6d5;</i></a>
                            <ul class="dropDown-menu menu radius box-shadow">
                                <li><a  href="javascript:;" onclick="mysqlf_edit('修改个人信息','{{ route('editMySelf') }}')">个人信息</a></li>
                                <li><a href="{{ URL::asset('/admin/loginout') }}">退出</a></li>
                            </ul>
                        </li>
                        {{--<li id="Hui-msg">--}}
                            {{--<a href="#" title="消息">--}}
                                {{--<span class="badge badge-danger">1</span>--}}
                                {{--<i class="Hui-iconfont" style="font-size:18px">&#xe68a;</i>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        <li id="Hui-skin" class="dropDown right dropDown_hover">
                            <a href="javascript:;" class="dropDown_A" title="换肤">
                                <i class="Hui-iconfont" style="font-size:18px">&#xe62a;</i>
                            </a>
                            <ul class="dropDown-menu menu radius box-shadow">
                                <li><a href="javascript:;" data-val="default" title="默认（黑色）">默认（黑色）</a></li>
                                <li><a href="javascript:;" data-val="blue" title="蓝色">蓝色</a></li>
                                <li><a href="javascript:;" data-val="green" title="绿色">绿色</a></li>
                                <li><a href="javascript:;" data-val="red" title="红色">红色</a></li>
                                <li><a href="javascript:;" data-val="yellow" title="黄色">黄色</a></li>
                                <li><a href="javascript:;" data-val="orange" title="橙色">橙色</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <aside class="Hui-aside">
        <div class="menu_dropdown bk_2">
            <dl id="menu-user">
                <dt>
                    <i class="Hui-iconfont">&#xe62d;</i> 管理员管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
                </dt>
                <dd>
                    <ul>
                        <li><a data-href="{{ URL::asset('/admin/admin/index') }}" data-title="管理员管理"
                               href="javascript:void(0)">管理员管理</a></li>
                    </ul>
                </dd>
            </dl>
            <dl id="menu-picture">
                <dt><i class="Hui-iconfont">&#xe613;</i> Banner管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
                </dt>
                <dd>
                    <ul>
                        <li><a data-href="{{ URL::asset('/admin/banner/index') }}" data-title="Banner管理" href="javascript:void(0)">Banner管理</a></li>
                    </ul>
                </dd>
            </dl>
            <dl id="menu-organization">
                <dt><i class="Hui-iconfont">&#xe66a;</i> 旅行社管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
                </dt>
                <dd>
                    <ul>
                        <li><a data-href="{{ URL::asset('/admin/organization/index') }}" data-title="旅行社管理" href="javascript:void(0)">旅行社管理</a></li>
                    </ul>
                </dd>
            </dl>
            {{--<dl id="menu-product">--}}
                {{--<dt><i class="Hui-iconfont">&#xe648;</i> 产品管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>--}}
                {{--</dt>--}}
                {{--<dd>--}}
                    {{--<ul>--}}
                        {{--<li><a data-href="product-brand.html" data-title="产品分类" href="javascript:void(0)">产品分类</a></li>--}}
                        {{--<li><a data-href="product-category.html" data-title="产品管理" href="javascript:void(0)">产品管理</a>--}}
                    {{--</ul>--}}
                {{--</dd>--}}
            {{--</dl>--}}
            {{--<dl id="menu-goods">--}}
                {{--<dt><i class="Hui-iconfont">&#xe649;</i> 旅游定制管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>--}}
                {{--</dt>--}}
                {{--<dd>--}}
                    {{--<ul>--}}
                        {{--<li><a data-href="product-brand.html" data-title="酒店" href="javascript:void(0)">酒店</a></li>--}}
                        {{--<li><a data-href="product-category.html" data-title="航班" href="javascript:void(0)">航班</a></li>--}}
                        {{--<li><a data-href="product-category.html" data-title="套餐" href="javascript:void(0)">套餐</a></li>--}}
                        {{--<li><a data-href="product-category.html" data-title="车导" href="javascript:void(0)">车导</a></li>--}}
                        {{--<li><a data-href="product-category.html" data-title="成型套餐" href="javascript:void(0)">成型套餐</a></li>--}}
                    {{--</ul>--}}
                {{--</dd>--}}
            {{--</dl>--}}
            {{--<dl id="menu-order">--}}
                {{--<dt><i class="Hui-iconfont">&#xe670;</i> 订单管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>--}}
                {{--</dt>--}}
                {{--<dd>--}}
                    {{--<ul>--}}
                        {{--<li><a data-href="product-brand.html" data-title="订单管理" href="javascript:void(0)">订单管理</a></li>--}}
                    {{--</ul>--}}
                {{--</dd>--}}
            {{--</dl>--}}
            <dl id="menu-member">
                <dt><i class="Hui-iconfont">&#xe62b;</i> 会员管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
                </dt>
                <dd>
                    <ul>
                        <li><a data-href="{{ URL::asset('/admin/member/index') }}" data-title="会员管理" href="javascript:void(0)">会员管理</a></li>
                    </ul>
                </dd>
            </dl>
            {{--<dl id="menu-integral">--}}
                {{--<dt><i class="Hui-iconfont">&#xe6b5;</i> 积分商城管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>--}}
                {{--</dt>--}}
                {{--<dd>--}}
                    {{--<ul>--}}
                        {{--<li><a data-href="product-brand.html" data-title="积分兑换商品" href="javascript:void(0)">积分兑换商品</a></li>--}}
                        {{--<li><a data-href="product-brand.html" data-title="兑换记录信息" href="javascript:void(0)">兑换记录信息</a></li>--}}
                    {{--</ul>--}}
                {{--</dd>--}}
            {{--</dl>--}}
            {{--<dl id="menu-ticket">--}}
                {{--<dt><i class="Hui-iconfont">&#xe628;</i> 抢票模块管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>--}}
                {{--</dt>--}}
                {{--<dd>--}}
                    {{--<ul>--}}
                        {{--<li><a data-href="product-brand.html" data-title="评论管理" href="javascript:void(0)">抢票模块管理</a></li>--}}
                    {{--</ul>--}}
                {{--</dd>--}}
            {{--</dl>--}}
            {{--<dl id="menu-comment">--}}
                {{--<dt><i class="Hui-iconfont">&#xe6b3;</i> 评论管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>--}}
                {{--</dt>--}}
                {{--<dd>--}}
                    {{--<ul>--}}
                        {{--<li><a data-href="product-brand.html" data-title="评论管理" href="javascript:void(0)">评论管理</a></li>--}}
                    {{--</ul>--}}
                {{--</dd>--}}
            {{--</dl>--}}
        </div>
    </aside>
    <div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a>
    </div>
    <section class="Hui-article-box">
        <div id="Hui-tabNav" class="Hui-tabNav hidden-xs">
            <div class="Hui-tabNav-wp">
                <ul id="min_title_list" class="acrossTab cl">
                    <li class="active">
                        <span title="业务概览" data-href="welcome.html">系统首页</span>
                        <em></em></li>
                </ul>
            </div>
            <div class="Hui-tabNav-more btn-group"><a id="js-tabNav-prev" class="btn radius btn-default size-S"
                                                      href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a><a
                        id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i
                            class="Hui-iconfont">
                        &#xe6d7;</i></a></div>
        </div>
        <div id="iframe_box" class="Hui-article">
            <div class="show_iframe">
                <div style="display:none" class="loading"></div>
                <iframe scrolling="yes" frameborder="0" src="{{ URL::asset('/admin/welcome') }}"></iframe>
            </div>
        </div>
    </section>

    <div class="contextMenu" id="Huiadminmenu">
        <ul>
            <li id="closethis">关闭当前</li>
            <li id="closeall">关闭全部</li>
        </ul>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(function () {

        });
        /*资讯-添加*/
        function mysqlf_edit(title,url){
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }
    </script>
@endsection