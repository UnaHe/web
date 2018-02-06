<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>商务</title>
    <!--设置视口-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-sclable=0">
    <!-- 设置主题样式-->
    <link rel="stylesheet" href="/web/lib/bootstrap/dist/css/bootstrap.min.css"/>
    <!-- 引入字体样式-->
      <link rel="stylesheet" href="/web/css/reset.css">
    <link rel="stylesheet" href="/web/lib/bootstrap/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/web/css/com.css"/>
    <link rel="stylesheet" href="/web/css/business.css"/>
</head>
<body>
<!--头部-->
<div class="container-fluid">
    @include('web.layouts.header')



            <!--搜索导航栏-->
    <nav class="navbar navbar-default container search_nav">
        <div class="container-fluid pyt_search_nav">
            <div class="navbar-header pyt_navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand pyt_font_size48" href="#">朋友惠</a><span class="line_pyt"></span>
                <a class="navbar-brand pyt_font_size48 pyt_color" href="#">Tuike</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                <form class="navbar-form navbar-left">
                    <div class="form-group">
                        <ul class="nav navbar-nav navbar-left">
                            <li class="pyt_searchAll">综合搜索</li>
                        </ul>
                        <input type="text" class="form-control" placeholder="搜索标题、商品ID、商品链接" id='blue_line' name='search'/>
                    </div>
                    <div  class="btn  btn-C"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></div>
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
                    <li class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/columns/today_tui/goods') active @endif">
                        <a href="{{url('/columns/today_tui/goods')}}">今日必推</a></li>
                    <li class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/miaosha/goods') active @endif">
                        <a href="{{url('/miaosha/goods')}}">限时快抢</a></li>
                    <li class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/columns/today_jing/goods') active @endif">
                        <a href="{{url('/columns/today_jing/goods')}}">今日精选</a></li>
                    <li class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/columns/xiaoliangbaokuan/goods') active @endif">
                        <a href="{{url('/columns/xiaoliangbaokuan/goods')}}">爆款专区</a></li>
                    <li class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/columns/meishijingxuan/goods') active @endif">
                        <a href="{{url('/columns/meishijingxuan/goods')}}">美食精选</a></li>
                    <li class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/columns/jiajujingxuan/goods') active @endif">
                        <a href="{{url('/columns/jiajujingxuan/goods')}}">家具精选</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!--主题部分-->
    <seation class="pyt-seation container-fluid">
        <!--中心板块-->
        <div class="container-fluid banner_bag">
            <div class="open_btn"><a href="{{url('/columns/today_tui/goods')}}" class="click_open">点击开启</a></div>
        </div>
        <div class="row  container">
            <!-- 中心内容-->
            <div id="sever_business">
                <p class="hearder_title">整合 <span>10万</span>品牌商家提供数据和营销服务</p>

                <div class="col-sm-12" id="line">
                    <div class="col-sm-4 infor_logo">
                        <img src="/web/images/shouji@2x.png" alt="手机">

                        <p>把握千万移动端人群</p>
                    </div>
                    <div class="col-sm-4 infor_logo">
                        <img src="/web/images/shuju@2x.png" alt="数据">

                        <p class="margin_20">全平台整合营销</p>
                    </div>
                    <div class="col-sm-4 infor_logo">
                        <img src="/web/images/zhuanfa@2x.png" alt="">

                        <p>商品一键转发</p>
                    </div>
                </div>
                <div class="col-sm-12">
                    <p class="chain">企业生态链 </p>

                    <p class="chain_english">Enterprise ecological chain</p>

                    <p class="com_img"><img src="/web/images/shengtailian%20@2x.png" alt="企业生态链"></p>
                </div>
            </div>
        </div>
    </seation>
    <div class="clear"></div>
    <!--页脚-->
    <footer class="container-fluid pyt_footer_box">
        <div id="footer_join">
            <p class="family">加入我们的"大家庭"</p>

            <p class="join_us">JOIN US</p>

            <p class="footer_logo"><img src="/web/images/xinfeng@2x.png" alt="信封"></p>

            <p class="relation">很高兴收到你的来信，我们在审核后第一时间与您联系</p>

            <p class="advantage">让流量更省钱，让店铺更赚钱，只需要你几分钟</p>
            <button class="register"><a href="{{url('register')}}" class="click_open">注册</a></button>
        </div>


        <div class="container pyt_center_footer">
            <ul class="pyt_footer">
                 <li>公司官网</li><span class='footer_line'></span>
                 <li>公司官网2</li><span class='footer_line'></span>
                 <li>合作伙伴</li><span class='footer_line'></span>
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
<script src="/web/js/com.js"></script>
<script>



</script>
</html>