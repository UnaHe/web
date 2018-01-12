<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}} - 朋友推</title>
    <link rel="stylesheet" href="/assets/css/amazeui.css">
    <link rel="stylesheet" href="/css/web/common.css" />
    <link rel="stylesheet" href="/css/web/index.css" />
    <style type="text/css">
        /*登录下拉菜单*/
        .container .topbar-right{
            display: inline;
        }
        ul {
            list-style: none;
        }

        .nav > li {
            float: left;
        }

        .nav a {
            display: block;
            text-decoration: none;
            width: auto;
            height: 40px;
            text-align: center;
            line-height: 42px;
            color: rgba(238, 238, 238, 1);
            background-color: rgba(238, 238, 238, 1);
        }

        .drop-down {
            position: relative;
        }

        .drop-down li {
            width: 100px;
        }

        .drop-down-content {
            padding: 0;
            display: none;
            position: absolute;
            margin-top: 0px;
            z-index: 9999;
        }

        .drop-down-content li a {
            background: white;
            line-height: 30px;
            height: 30px;
        }

        #login {
            width: 100px;
            margin-right: -10px;
        }
    </style>

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

    <div class="pyt-banner">
        <div>
            <a href=""  class="start">立即开启</a>
            {{--<button class="start">立即开启</button>--}}
        </div>
    </div>


{{--产品精选--}}
<div class="">
        今日必推
        <a href="{{url('/columns/today_tui/goods')}}">点击查询</a>
</div>

<div class="">
    限时快抢
    <a href="{{url('/miaosha/goods')}}" >点击查询</a>
</div>

{{--主打栏目--}}
<div class="">
    今日精选
    <a href="{{url('/columns/today_jing/goods')}}"  >点击查询</a>
</div>
<div class="">
  美食精选
    <a href="{{url('/columns/meishijingxuan/goods')}}" >点击查询</a>
</div>
<div class="">
    家居精选
    <a href="{{url('/columns/jiajujingxuan/goods')}}"  >点击查询</a>
</div>





    <script src="/js/jquery.3.2.1.js"></script>
    <script src="/js/layer/layer.js"></script>
    <script src="/assets/js/amazeui.js"></script>

    <script type="text/javascript">

    </script>
</body>
</html>