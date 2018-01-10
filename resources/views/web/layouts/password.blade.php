<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title> @yield('title') </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="renderer" content="webkit">
    <meta name="csrf-token" content="{{csrf_token()}}"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="stylesheet" href="assets/css/amazeui.css"/>
    <link rel="stylesheet" href="css/web/user/password.css"/>

    @section('css')
    @show

</head>

<body>
<div class="header">
    <div><a href="#"><img alt="logo" src="images/web/logo.png"/></a>

        <div>
            <div class="header-nav">
                <div class="header-nav-first-span">找回密码</div>

                <div class="header-nav-sec-span"><a href="{{url('/')}}">首页</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                    <a href="{{url('register')}}">注册</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="{{url('login')}}">登录</a></div>
            </div>
        </div>

        @section('content')
        @show

    </div>
</div>


<script src="js/jquery.2.1.4.js"></script>
<script src="js/layer/layer.js"></script>
<script src="js/web/common.js"></script>
@section('js')
@show

</body>
</html>