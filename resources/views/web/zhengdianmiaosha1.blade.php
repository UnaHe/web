<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>{{$title}}-朋友推</title>
    <!--设置视口-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-sclable=0">
    <!-- 设置主题样式-->
    <link rel="stylesheet" href="/web/lib/bootstrap/dist/css/bootstrap.min.css"/>
    <!-- 引入字体样式-->
    <link rel="stylesheet" href="/web/lib/bootstrap/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/web/css/com.css"/>
    <link rel="stylesheet" href="/web/css/flash_sale.css"/>
</head>
<body>
<!--头部-->
<div class="container-fluid">
    <header class="pyt_header pyt_hearder_color">
        <nav class="navbar navbar-default  container pyt_hearder_color">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class=""><a href="#">给你的不仅仅是优惠</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown-toggle"><a href="#">1888********</a>
                        </li>
                        <ul class="dropdown-menu">
                            <li><a href="#">个人中心</a></li>
                            <li><a href="#">授权管理</a></li>
                            <li><a href="#">账号安全</a></li>
                            <li><a href="#">退出</a></li>
                        </ul>
                        <li><a href="#">注册</a></li>
                        <li><a href="#">企业官网</a></li>
                        <li><a href="#">商务合作</a></li>
                        <li><a href="#">微信交流群</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!--搜索导航栏-->
    <nav class="navbar navbar-default container">
        <div class="container-fluid pyt_search_nav">
            <div class="navbar-header pyt_navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand pyt_font_size48" href="#">朋友推</a>
                <a class="navbar-brand pyt_font_size48 pyt_color" href="#">Tuike</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                <form class="navbar-form navbar-left">
                    <div class="form-group">
                        <ul class="nav navbar-nav navbar-left">
                            <li class="pyt_searchAll">综合搜索</li>
                        </ul>
                        <input type="text" class="form-control" placeholder="搜索标题、商品ID、商品链接">
                    </div>
                    <button type="submit" class="btn btn-default">搜索图</button>
                </form>
            </div>
        </div>
    </nav>
    <!--导航-->
    <nav class="navbar navbar-inverse container-fluid">
        <div class="container">
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-3">
                <ul class="nav navbar-nav pyt_navbar-nav">
                    <li class=""><a href="{{url('/')}}">主页</a></li>
                    <li class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/columns/today_tui/goods')) active @endif">
                        <a href="{{url('/columns/today_tui/goods')}}">今日必推</a></li>
                    <li class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/miaosha/goods')) active @endif">
                        <a href="{{url('/miaosha/goods')}}">限时快抢</a></li>
                    <li class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/columns/today_jing/goods')) active @endif">
                        <a href="{{url('/columns/today_jing/goods')}}">今日精选</a></li>
                    <li class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/columns/xiaoliangbaokuan/goods')) active @endif">
                        <a href="{{url('/columns/xiaoliangbaokuan/goods')}}">爆款专区</a></li>
                    <li class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/columns/meishijingxuan/goods')) active @endif">
                        <a href="{{url('/columns/meishijingxuan/goods')}}">美食精选</a></li>
                    <li class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/columns/jiajujingxuan/goods')) active @endif">
                        <a href="{{url('/columns/jiajujingxuan/goods')}}">家具精选</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!--主题部分-->
    <seation class="pyt-seation container-fluid">
        <div class="row  container">
            <!-- 中心内容-->
            <!--时间点-->
            <lable class="col-sm-12 ">
                <p class="left_arr">
                    <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
                </p>
                <ul class="rush_point">

                    @foreach($time_step as $v)
                        <a href="{{url('/miaosha/goods').'?active_time='.$v['active_time']}}">
                            <li>
                                <p>{{$v['time']}}</p>

                                <p>{{$v['status']}}</p>
                            </li>
                        </a>
                    @endforeach

                </ul>
                <p class="right_arr">
                    <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                </p>
            </lable>


            @foreach($list as $key=>$val)
                <lable class="col-sm-5">
                    <div class="img_left">
                        <a href="{{url('/goods/'. $val['id']).'?columnCode='.$active['active_column_code']}} "
                           target="_blank" class="click_open">
                            <image src="{{$val['pic']}}"></image>
                        </a>
                    </div>
                    <div class="text_right">
                        <a href="{{url('/goods/'. $val['id']).'?columnCode='.$active['active_column_code']}} "
                           target="_blank" class="click_open">
                            <p class="title">   {{str_limit($val['short_title'], $limit = 39, $end = '...')}}</p>

                            <p class="full_name"> {{str_limit($val['des'], $limit = 120, $end = '...')}}</p>
                        </a>

                        <p class="discount"><span class="coupun">券</span> {{ $val['coupon_price']}}元</p>

                        <div class="pyt_price">
                            <p class="floor_price"><span class="floor_price_title">券后价</span> <span
                                        class="price ">￥{{ $val['price']}}</span></p>

                            <p class="floor_price floor_price_right "><span class="floor_price_earnings">预计收益</span>
                                <span class="price">￥{{ $val['commission_finally']}}</span></p>
                        </div>
                        <p class="quick"><span class="sale_num"> {{ $val['sell_num']}}</span>已售 <span
                                    class="sale_quick">马上推</span></p>
                    </div>
                </lable>
            @endforeach


        </div>
    </seation>
    <div class="clear"></div>
    <!--页脚-->
    <footer class="container-fluid pyt_footer_box">
        <div class="container pyt_center_footer">
            <ul class="pyt_footer">
                <li>公司官网</li>
                <li>公司官网2</li>
                <li>合作伙伴</li>
                <li>合作伙伴2</li>
            </ul>
            <div class="clear"></div>
            <p class="pyt_remark">2017-2017 www.tkhd.com朋友推--蜀CP备170234号-1 成都推客互动</p>
        </div>

    </footer>
</div>
</body>
<script src="/web/lib/jquery/dist/jquery.js"></script>
<scrpit src="/web/lib/bootstrap/dist/js/bootstrap.min.js"></scrpit>
<script>
    $('.glyphicon-menu-left').click(function () {
        alert(111);
    });

    <!-- 头部登录下拉菜单-->
    $(".dropdown-toggle").on("click", function () {
        $(".dropdown-menu").slideToggle()
    });
    //提交表单事件


</script>
</html>