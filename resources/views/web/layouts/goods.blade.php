<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}} - 朋友推</title>
    <link rel="stylesheet" href="/assets/css/amazeui.css"/>
    <link rel="stylesheet" href="/css/web/common.css"/>
    <link rel="stylesheet" href="/css/web/push_list.css"/>
    <link rel="stylesheet" href="/css/web/goods_layouts.css"/>

    @section('css')
    @show

    <script src="/js/jquery.3.2.1.js"></script>
    <script src="/js/layer/layer.js"></script>
    <script src="/assets/js/amazeui.js"></script>
    <script type="text/javascript" src="/js/web/goods_layouts.js"></script>


</head>
<body>
<div class="topbar">
    <!--公共顶部 start-->
    <div class="container top">
        <div class="am-g">
            <div class="am-u-md-3">
                <div class="topbar-left">
                    <span class="">给你的不仅是优惠！</span>
                </div>
            </div>
            <div class="am-u-md-9">
                <div class="topbar-right am-text-right am-fr">
                    <ul class="nav">
                        @if(\Illuminate\Support\Facades\Auth::check())
                            <li class="drop-down">
                                <a href="#" id="login">{{\Illuminate\Support\Facades\Auth::user()->phone}}</a>
                                <ul class="drop-down-content">
                                    <li><a href="{{url('/userCenter')}}">个人中心</a></li>
                                    <li><a href="#">授权管理</a></li>
                                    <li><a href="{{url('/accountSecurity')}}">账号安全</a></li>
                                    <li><a href="{{url('/logout')}}">退出</a></li>
                                </ul>
                            </li>
                        @else
                            <li><a href="{{url('login')}}">登录</a></li>
                        @endif
                            <li class="mod_copyright_split">|</li>
                            <li><a href="{{url('register')}}">注册</a></li>
                            <li class="mod_copyright_split">|</li>
                            <li><a href="#">企业官网</a></li>
                            <li class="mod_copyright_split">|</li>
                            <li><a href="{{url('/business')}}">商家合作</a></li>
                            <li class="mod_copyright_split">|</li>
                            <li><a href="#">微信交流群</a></li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
    <!--公共顶部 end-->
</div>

<div class="header-box">
    <!--头部 start-->
    <div class="container">
        <div class="header">
            <div class="logo f1">
                <a href=""><img src="/images/web/logo.png" alt=""/></a>
            </div>
            <div class="search bar6 f1">
                <span class="search_span">综合搜索</span>
                <span class="search_span1"></span>

                <form action="{{url('/columns/'.$active['active_column_code'].'/goods')}}" method="get">
                    <input type="text" placeholder="搜索标题、商品ID、商品链接" name="keyword">
                    <button type="submit"><img src="/images/web/search.png" alt=""/></button>
                    <span></span>
                </form>
            </div>
        </div>
    </div>
    <!--头部 end-->
</div>

<div class="head-nav">
    <!--导航菜单 start-->
    <div class="nav-main">
        <div class="nav-list clearfix">
            <ul class="">
                <li><a href="{{url('/')}}">主页</a></li>
                <li>
                    <a class="@if($active['active_column_code']=='today_tui') active @endif"
                       href="{{url('/columns/today_tui/goods')}}">今日必推</a>
                </li>
                <li class="">
                    <a class="@if($active['active_column_code']=='zhengdianmiaosha') active @endif"
                       href="{{url('/miaosha/goods')}}">限时快抢</a>
                </li>
                <li class="">
                    <a class="@if($active['active_column_code']=='today_jing') active @endif"
                       href="{{url('/columns/today_jing/goods')}}">今日精选<i class="sf_new"></i></a>
                </li>
                <li class="">
                    <a class="@if($active['active_column_code']=='xiaoliangbaokuan') active @endif"
                       href="{{url('/columns/xiaoliangbaokuan/goods')}}">爆款专区<i class="app_new"></i></a>
                </li>
                <li>
                    <a class="@if($active['active_column_code']=='meishijingxuan') active @endif"
                       href="{{url('/columns/meishijingxuan/goods')}}"><img src="/images/web/food.png" alt=""/>美食精选</a>
                </li>
                <li>
                    <a class="@if($active['active_column_code']=='jiajujingxuan') active @endif"
                       href="{{url('/columns/jiajujingxuan/goods')}}"><img src="/images/web/furniture.png" alt=""/>家居精选</a>
                </li>
            </ul>
        </div>
    </div>
    <!--导航菜单 end-->
</div>


@section('pyt-banner')
@show

@section('category')
@show

@section('screen')
@show


@section('sort')
@show


@section('main')
@show


<div class="footer">
    <!--公共底部 start-->
    <div class="footer-hd center-block">
        <p class="mod_copyright_links">
            <a href="" target="_blank">公司官网</a>
            <span class="mod_copyright_split">|</span>
            <a href="" target="_blank">公司网站2</a>
            <span class="mod_copyright_split">|</span>
            <a href="" target="_blank">合作伙伴</a>
            <span class="mod_copyright_split">|</span>
            <a href="" target="_blank">合作伙伴2</a>
        </p>
    </div>
    <div class="footer-in"></div>
    <div class="footer-bd center-block">
        <p class="mod_copyright_links">
            <em>&copy; 2017-{{date("Y",time())}} 推客版权所有</em>
        </p>
    </div>
    <!--公共底部 end-->
</div>

@section('js')
@show
</body>
</html>