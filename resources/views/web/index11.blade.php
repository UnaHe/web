<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>首页</title>
    <!--设置视口-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-sclable=0">
    <!-- 设置主题样式-->
    <link rel="stylesheet" href="/web/lib/bootstrap/dist/css/bootstrap.min.css"/>
    <!-- 引入字体样式-->
    <!--引入重置样式-->
    <link rel="stylesheet" href="/web/css/reset.css">
    <link rel="stylesheet" href="/web/lib/bootstrap/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet" href="/web/css/com.css"/>
    <link rel="stylesheet" href="/web/css/index.css"/>
</head>
<body>
<!--头部-->
<div class="container-fluid">
    @include('web.layouts.header')

    <!--banner部分-->
    <seation class="pyt-seation container-fluid">
        <!--中心板块-->
        <div class="container-fluid banner_bag">
            <div class="open_btn"><a href="{{url('/columns/today_tui/goods')}}" class="click_open">点击开启</a></div>
        </div>
        <div class="row  container-fluid">
            <div class="col-12_bg">
                <!-- 产品精选-->
                <div class=" col-sm-12">
                    <p class="welcome">— WELCOME —</p>
                    <p class="title_pro">产品精选</p>
                    <p class="pyt">— PENGYOUTUI —</p>
                    <div class="sea_back_img">
                        <div class="text_box text_box_a">
                            <p class="time_limit">限时快抢</p>
                            <p class="time_limit_eng">xianshikuaiqiang</p>
                            <p class="first">第一手全网商品</p>
                            <p class="pledge">保证时效性</p>
                            <p class="full_goods">First full net goods</p>
                            <p class="guarantee">Timeliness of guarantee</p>
                            <p class="click_query"><a href="{{url('/miaosha/goods')}}"  class="click_open">点击查询</a></p>
                        </div>
                        <div class="text_box_2 text_box_a">
                            <p class="time_limit">限时快抢</p>
                            <p class="time_limit_eng">xianshikuaiqiang</p>
                            <p class="first">第一手全网商品</p>
                            <p class="pledge">保证时效性</p>
                            <p class="full_goods">First full net goods</p>
                            <p class="guarantee">Timeliness of guarantee</p>
                            <p class="click_query"><a href="{{url('/miaosha/goods')}}"  class="click_open">点击查询</a></p>
                        </div>
                    </div>
                </div>
                <div class="container-fluid col-xs-12 back_image"><div  class="background_color"></div></div>
            </div>
            <!-- 主打栏目-->
            <div class="col-12_bgr">
                <div class="col-sm-12">
                    <p class="welcome">— WELCOME —</p>
                    <p class="title_pro ">主打栏目</p>
                    <p class="pyt">— PENGYOUTUI —</p>
                </div>
                <div class="sea_back_img  coulmn">
                    <div class="text_box_3 text_small_box">
                        <p class="time_limit">今日精选 </p>
                        <p class="time_limit_eng">jinrijingxuan</p>
                        <p class="first">严格商品</p>
                        <p class="pledge">人工审核</p>
                        <p class="full_goods">Strict selection of goods</p>
                        <p class="guarantee">Manual review</p>
                        <p class="click_query"><a href="{{url('/columns/today_jing/goods')}}"  class="click_open">点击查询</a></p>
                    </div>
                    <div class="text_box_4 text_small_box">
                        <p class="time_limit">美食精选 </p>
                        <p class="time_limit_eng">meishijingxuan</p>
                        <p class="first">休闲零食</p>
                        <p class="pledge">地域美味想吃就吃</p>
                        <p class="full_goods">Snack snack</p>
                        <p class="guarantee">Regional delicacy</p>
                        <p class="click_query"><a href="{{url('/columns/meishijingxuan/goods')}}"  class="click_open">点击查询</a></p>
                    </div>
                    <div class="text_box_5 text_small_box">
                        <p class="time_limit">家居精选 </p>
                        <p class="time_limit_eng">jiajujingxuan</p>
                        <p class="first">打造你的空间</p>

                        <p class="full_goods full_goods_top">Make your space</p>

                        <p class="click_query click_query_top"><a href="{{url('/columns/jiajujingxuan/goods')}}"  class="click_open">点击查询</a></p>
                    </div>
                </div>
                <div class="container-fluid col-xs-12 back_image margin-Top_big"><div  class="background_color"></div></div>
            </div>
            <!--产品矩阵-->
            <div class="col-sm-12 cpjz">
                <p class="welcome">— WELCOME —</p>
                <p class="title_pro">产品矩阵</p>
                <p class="pyt">— PENGYOUTUI —</p>
                <div class=" two_box_square"></div>
            </div>
        </div>
        <!-- 解决方案-->
        <div class="col-sm-12 jjfa_box">
            <p class="welcome welcome_a">— WELCOME —</p>
            <p class="title_pro title_pro_a">解决方案</p>
            <p class="pyt pyt_a">— PENGYOUTUI —</p>
            <div class="two_box">
                <div class="solve">
                    <p class="xcx_logo">
                        <img src="/web/images/xiaochengxu@2x.png" alt="小程序">
                    </p>
                    <p class="xcx_text">APP&小程序</p>
                    <p class="guide">随时随地更新第一手隐藏优惠券一键开启智能导购模式</p>
                    <p class="order">智能化导购模式实现用户自助找券下单</p>
                    <p class="short_time">提高用户的购买体验和转化率精简成本 缩短时间</p>
                </div>
                <div class="solve">
                    <p class="xcx_logo">
                        <img src="/web/images/xiaozhushou@2x.png" alt="小助手">
                    </p>
                    <p class="xcx_text xiaozhushou">小助手</p>
                    <p class="guide left_45">全后台商家用户管理神器</p>
                    <p class="order left_45">全网数据锁定高拥 高效率分析</p>
                    <p class="short_time left_45">消息定时群发 解放双手</p>
                </div>
            </div>

        </div>
    </seation>
    <div class="clear"></div>
    <!--页脚-->
    <footer class="container-fluid pyt_footer_box">
        <div class="container pyt_center_footer">
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
<script>



</script>
</html>