<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>
        
        @yield('title')

    </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="renderer" content="webkit">
    <meta name="csrf-token" content="{{csrf_token()}}"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="stylesheet" href="{{ asset('css/amazeui.css') }}"/>
    <link href="{{ asset('css/web/dlstyle.css') }}" rel="stylesheet" type="text/css">

    @section('css')
    @show


</head>

<body>

<div class="login-boxtitle">
    <a href="#"><img alt="logo"  src="{{ asset('images/web/logobig.png') }}"/></a>
</div>

<div class="login-banner">
    <div class="login-main">
        <div class="login-banner-bg">
            <span></span>
        </div>
        <div class="login-box">
            <h3 class="title">
                <a href="{{url('login')}}"><span class="@if($active=='login') avtive @endif">欢迎登录</span></a>&nbsp;&nbsp; &nbsp;
                <table class="line"><tr><td valign="top"></td></tr></table>
                &nbsp; &nbsp;
                <a href="{{url('register')}}"> <span class="@if($active=='register') avtive @endif">免费注册</span></a>
            </h3>
            <div class="clear"></div>

            @section('content')
            @show

        </div>
    </div>
</div>

<hr style="margin-top: 177px;margin-left:473px;width: 1100px;background:rgba(255,255,255,1);"/>
<div class="footer ">
    <div class="footer-hd center-block">
        <p style="display: inline" >
            <a href="# ">公司官网</a>
            &nbsp;
        <table class="line" ><tr><td valign="top"></td></tr></table>
        &nbsp;
            <a href="# ">公司网站</a>
        &nbsp;
        <table  class="line"><tr><td valign="top"></td></tr></table>
        &nbsp;
            <a href="# ">合作伙伴</a>
        &nbsp;
        <table class="line" ><tr><td valign="top"></td></tr></table>
        &nbsp;
            <a href="# ">合作伙伴</a>
        </p>
    </div>
    <div class="footer-bd center-block">
        <p>
            <em>© 2017-{{date("Y",time())}} 推客版权所有</em>
        </p>
    </div>
</div>
</body>
<script src="{{ asset('/js/jquery.2.1.4.js') }}"></script>
<script src="{{ asset('/js/layer/layer.js') }}"></script>
@section('js')
@show

</html>