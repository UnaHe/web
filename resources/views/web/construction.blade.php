<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>{{$title}}-朋友惠</title>
    <!--设置视口-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-sclable=0">
    <!--引入重置样式-->
    <link rel="stylesheet" href="/web/lib/bootstrap/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/web/css/reset.css">
    <link rel="stylesheet" href="/web/css/com.css"/>
    <link rel="stylesheet" href="/web/css/construction.css"/>
</head>
<body>
<!--头部-->
<div class="container-fluid">
@include('web.layouts.header')

<!--banner部分-->
    <nav class="pyt_nav" id="pyt_nav">
        <div class="container">
            <ul id="nav_pro">
                <a href="{{url('/')}}"><li class="{{$name?'':'active_index'}}">首页</li></a>
                <a href="{{url('/columns/today_jing/goods')}}"><li>臻品汇</li></a>
                <li onclick="javascript:document.getElementById('list_column').scrollIntoView()">产品矩阵</li>
                <a href="{{url('/construction/c1')}}" id="construction1"><li class="{{$name=='c1'?'active_index1':''}}">粉丝营销</li></a>
                <a href="{{url('/construction/c2')}}" id="construction2"><li class="{{$name=='c2'?'active_index1':''}}">推客商学院</li></a>
                <a href="{{url('/construction/c3')}}" id="construction3"><li class="{{$name=='c3'?'active_index1':''}}">推客商盟</li></a>
                <a href="{{url('/construction/c4')}}" id="construction4"><li class="open_terrace {{$name=='c4'?'active_index1':''}}">开放平台</li></a>
            </ul>
            <div class="clear"></div>
            <p id="souye_x" class='container'>
                <img src="/images/web/underConstruction.png" alt="">
            </p>
            <a href="{{url('/')}}" class="click_open">
                <div class="open_btn container">返回首页</div>
            </a>
        </div>
    </nav>
    <div class="clear"></div>
    <!--页脚-->
    <footer class="container-fluid pyt_footer_box">
        <div class="container-fluid pyt_center_footer">
            {{--<ul class="pyt_footer">--}}
            {{--<li>公司官网</li>--}}
            {{--<li>公司网站</li>--}}
            {{--<li>合作伙伴1</li>--}}
            {{--<li>合作伙伴2</li>--}}
            {{--</ul>--}}
            {{--<div class="clear"></div>--}}
            <p class="pyt_remark">&copy;2017 四川推客互动有限责任公司 蜀ICP备170234号-1 www.tuike198.com</p>
        </div>
    </footer>
</div>
</body>
<script src="/web/lib/jquery/dist/jquery.js"></script>
<script src="/web/lib/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/web/js/com.js"></script>
<script src="/web/js/construction.js"></script>
</html>