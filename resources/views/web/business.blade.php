<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>首页</title>
    <!--设置视口-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-sclable=0">

    <!--引入重置样式-->
    <link rel="stylesheet" href="/web/lib/bootstrap/dist/css/bootstrap.min.css"/>
     <link rel="stylesheet" href="/web/css/reset.css">

        <link rel="stylesheet" href="/web/css/com.css"/>
        <link rel="stylesheet" href="/web/css/index.css"/>
</head>
<body>
<!--头部-->
<div class="container-fluid">
@include('web.layouts.header')

<!--banner部分-->
<nav class="pyt_nav" id="pyt_nav">
    <div class="container">
        <ul id="nav_pro">
           <a href="{{url('/')}}"> <li class="active_index">首页</li></a>
            <a href="{{url('/columns/today_jing/goods')}}"><li>优品汇</li></a>
            <li>产品全链</li>
            <li>粉丝营销</li>
            <li>推客商学院</li>
            <li>推友商盟</li>
            <li class="open_terrace">开放平台</li>
        </ul>
        <div class="clear"></div>
        <p id="app_explain" class="fadenum">
            <img src="/images/web/banner_biaoyu.png">
        </p>
        <p id="souye_x">
            <img src="/images/web/souye_x.png" alt="">
        </p>
        <p id="invite">邀您携手同行</p>
        <a href="{{url('/columns/today_tui/goods')}}" class="click_open">
            <div class="open_btn">立即开启</div>
        </a>
    </div>
</nav>

    <!--中心板块-->
<seation class="pyt-seation container-fluid">
    <!--主打栏目-->
    <div id="mian_all">
        <div id="main_column">
            <p class="background_column"></p>
            <p class="fontSize40">主打栏目</p>
            <p class="font-size20px">Important section</p>
        </div>
        <div id="column_all_box">
             <a href="{{url('/columns/today_jing/goods')}}">
                <div class="column_single_box">
                    <img src="/images/web/jinri%20jingxuan.png" alt="">
                    <p class="color_today font-size24">今日精选</p>
                    <p class="expect">严选商品 人工审核</p>
                </div>
            </a>
             <a href="{{url('/columns/meishijingxuan/goods')}}">
                <div class="column_single_box">
                    <img src="/images/web/meishi%20jingxuan.png" alt="">
                    <p class="color_food font-size24">美食精选</p>
                    <p class="expect">休闲零食 地域美食想吃就吃</p>
                </div>
            </a>
             <a href="{{url('/columns/jiajujingxuan/goods')}}">
                <div class="column_single_box">
                    <img src="/images/web/jiajujingxuan.png" alt="">
                    <p class="color_fit font-size24">家居精选</p>
                    <p class="expect">打造你的空间</p>
                </div>
            </a>
            <div class="column_single_box margin-right0">
                <img src="/images/web/nvzhuangjingxuan.png" alt="">
                <p class="color_girl font-size24">女装精选</p>
                <p class="expect">敬请期待</p>
            </div>
              <div class="column_single_box">
                <img src="/images/web/muyinjinxuan.png" alt="">
                <p class="color_blue font-size24">母婴精选</p>
                <p class="expect">敬请期待</p>
            </div>
        </div>
    </div>
    <!--产品精选栏目-->
      <div id="product_column">
        <div id="pruduct_column_title">
            <p class="background_column background_column_line"></p>
            <p class="fontSize40 left45">产品精选栏目</p>
            <p class="font-size20px left44">Selected goods section</p>
        </div>
        <div id="product_all_box">
            <div class="product_single_box">
                <div class="top_layout">
                    <p class="time_limit">限时快抢</p>
                    <p class="pledge">第一手全网商品 保证时效</p>
                </div>
                <img src="/images/web/xianshikuaiqiang.png" alt="">
                <a href="{{url('/miaosha/goods')}}"  class="click_open">
                     <div class="go_btn">GO</div>
                 </a>
            </div>
            <div class="product_single_box">
                <div class="top_layout">
                    <p class="time_limit">爆款专区</p>
                    <p class="pledge">人气销量 大大提升转化 带来更多用户</p>
                </div>
                <img src="/images/web/baokuan.png" alt="">
                <a href="{{url('/columns/xiaoliangbaokuan/goods')}}">
                    <div class="go_btn">GO</div>
                </a>
            </div>
            <div class="product_single_box">
                <div class="top_layout" id="time_limit_center">
                    <p class="time_limit">更多精彩</p>
                    <p class="pledge" id="pledge_center">敬请期待</p>
                </div>
                <img src="/images/web/gdjcICON.png" alt="" id="img_center">
            </div>
        </div>
    </div>

    <!--产品矩阵-->
    <div id="list_column">
        <div id="list_column_title">
            <p class="background_column left3"></p>
            <p class="fontSize40">产品矩阵</p>
            <p class="font-size20px">Product matrix</p>
        </div>
        <!--矩阵排版-->
        <div id="matrix">
        <div id="none_matrix">
            <img src="/images/web/tuikelianmeng.png" alt="" id="tuikelM">
            <!--相关产品布局-->
            <p class="friends_box friend_one">朋友汇</p>
            <p class="friends_box friend_two">朋友聊</p>
            <p class="friends_box friend_three">京东推</p>
            <p class="friends_box friend_four">朋友商</p>
            <p class="friends_box friend_five">朋友淘</p>
            <p class="friends_box friend_six">朋友头条</p>
            <p class="friends_box friend_seven">朋友助手</p>
            <!--流星布局-->
            <img src="/images/web/liuxin.png" alt="" id="liuxing">
        </div>
            <!--光圈-->
            <div class="dot"></div>
            <div class="pulse"></div>
            <div id="pulse1"></div>
        </div>
    </div>

    <!--解决方案-->
    <div id="solve">
        <div id="solve_title">
            <p class="background_column left5"></p>
            <p class="fontSize40 left45">解决方案</p>
            <p class="font-size20px left_solution left44 left_10">solution</p>
        </div>
        <!--解决方案详细布局-->
        <div id="test">
        <div id="solve_all_box" >
            <div id="box">
            <div id="content">
                <div id="inner">
            <div class="solve_single_box solve_single_box1">
                <p class="sales">智能导购</p>
                <ul class="list_three">
                    <li>·随时随地，更新第一手隐藏优惠券，一键开启智能导购模式</li>
                    <li>·智能化导购模式实现用户自助找券下单</li>
                    <li>·提高用户的购买体验和转化率，精简成本，缩短时间</li>
                </ul>
                <!--条纹布局-->
                <p class="bar_one bar_color checked_box1"></p>
                <p class="bar_two bar_color checked_box1"></p>
                <p class="bar_three bar_color checked_box1"></p>
                <p class="bar_four bar_color checked_box1"></p>
                <p class="bar_five bar_color checked_box1"></p>
                <p class="bar_six bar_color checked_box1"></p>
                <img src="/images/web/jiejuefangan.png" alt="" class="solve_img"/>
                <img src="/images/web/xcx_jiejuefangan.png" alt="" class="solve_img_wx">
            </div>
            <div class="solve_single_box solve_single_box2">
                <p class="sales">推客助手</p>
                <ul class="list_three">
                    <li>·全后台，商家用户管理神器</li>
                    <li>·消息定时群发，解放双手</li>
                </ul>
                <!--条纹布局-->
                <p class="bar_one bar_color_2 bar_one_2 checked_box2"></p>
                <p class="bar_two bar_color_2 bar_two_2 checked_box2"></p>
                <p class="bar_three bar_color_2 bar_three_2 checked_box2"></p>
                <p class="bar_four bar_color_2 bar_four_2 checked_box2"></p>
                <p class="bar_five bar_color_2 bar_five_2 checked_box2"></p>
                <p class="bar_six bar_color_2 bar_six_2 checked_box2"></p>
                <img src="/images/web/wx_jiejuefangan.png" alt="" class="solve_img_wxw">
            </div>
            <div class="solve_single_box solve_single_box3">
                <p class="sales">推客生态</p>
                <ul class="list_three">
                    <li>·跟随趋势，汇选优品</li>
                    <li>·多人群定位精准推荐，帮助破解流量定位困难</li>
                    <li>·多个特色楼层，实现收益最大化</li>
                </ul>
                <!--条纹布局-->
                <p class="bar_one bar_color_3 bar_one_2 checked_box3"></p>
                <p class="bar_two bar_color_3 bar_two_2 checked_box3"></p>
                <p class="bar_three bar_color_3 bar_three_2 checked_box3"></p>
                <p class="bar_four bar_color_3 bar_four_2 checked_box3"></p>
                <p class="bar_five bar_color_3 bar_five_2 checked_box3"></p>
                <p class="bar_six bar_color_3 bar_six_2 checked_box3"></p>
                <img src="/images/web/jiejuefanganshengtai.png" alt="" class="solve_img_wx3">
            </div>
            <div class="solve_single_box solve_single_box4">
                <p class="sales">优质品库</p>
                <ul class="list_three">
                    <li>·丰富的选品库淘宝，京东，蘑菇街，亚马逊等多平台入驻</li>
                    <li>·全网数据，锁定高佣，高效率分析</li>
                </ul>
                <!--条纹布局-->
                <p class="bar_one bar_color_4 checked_box4"></p>
                <p class="bar_two bar_color_4 checked_box4"></p>
                <p class="bar_three bar_color_4 checked_box4"></p>
                <p class="bar_four bar_color_4 checked_box4"></p>
                <p class="bar_five bar_color_4 checked_box4"></p>
                <p class="bar_six bar_color_4 checked_box4"></p>
                <img src="/images/web/tianmao_jiejuefangan.png" alt="" class="solve_img"/>
                <img src="/images/web/yamaxun.png" alt="" class="solve_img_ymx">
            </div>
                    <div class="solve_single_box solve_single_box1">
                        <p class="sales">智能导购</p>
                        <ul class="list_three">
                            <li>·随时随地，更新第一手隐藏优惠券，一键开启智能导购模式</li>
                            <li>·智能化导购模式实现用户自助找券下单</li>
                            <li>·提高用户的购买体验和转化率，精简成本，缩短时间</li>
                        </ul>
                        <!--条纹布局-->
                        <p class="bar_one bar_color checked_box1"></p>
                        <p class="bar_two bar_color checked_box1"></p>
                        <p class="bar_three bar_color checked_box1"></p>
                        <p class="bar_four bar_color checked_box1"></p>
                        <p class="bar_five bar_color checked_box1"></p>
                        <p class="bar_six bar_color checked_box1"></p>
                        <img src="/images/web/jiejuefangan.png" alt="" class="solve_img"/>
                        <img src="/images/web/xcx_jiejuefangan.png" alt="" class="solve_img_wx">
                    </div>
                    <div class="solve_single_box solve_single_box2">
                        <p class="sales">推客助手</p>
                        <ul class="list_three">
                            <li>·全后台，商家用户管理神器</li>
                            <li>·消息定时群发，解放双手</li>
                        </ul>
                        <!--条纹布局-->
                        <p class="bar_one bar_color_2 bar_one_2 checked_box2"></p>
                        <p class="bar_two bar_color_2 bar_two_2 checked_box2"></p>
                        <p class="bar_three bar_color_2 bar_three_2 checked_box2"></p>
                        <p class="bar_four bar_color_2 bar_four_2 checked_box2"></p>
                        <p class="bar_five bar_color_2 bar_five_2 checked_box2"></p>
                        <p class="bar_six bar_color_2 bar_six_2 checked_box2"></p>
                        <img src="/images/web/wx_jiejuefangan.png" alt="" class="solve_img_wxw">
                    </div>
                    <div class="solve_single_box solve_single_box3">
                        <p class="sales">推客生态</p>
                        <ul class="list_three">
                            <li>·跟随趋势，汇选优品</li>
                            <li>·多人群定位精准推荐，帮助破解流量定位困难</li>
                            <li>·多个特色楼层，实现收益最大化</li>
                        </ul>
                        <!--条纹布局-->
                        <p class="bar_one bar_color_3 bar_one_2 checked_box3"></p>
                        <p class="bar_two bar_color_3 bar_two_2 checked_box3"></p>
                        <p class="bar_three bar_color_3 bar_three_2 checked_box3"></p>
                        <p class="bar_four bar_color_3 bar_four_2 checked_box3"></p>
                        <p class="bar_five bar_color_3 bar_five_2 checked_box3"></p>
                        <p class="bar_six bar_color_3 bar_six_2 checked_box3"></p>
                        <img src="/images/web/jiejuefanganshengtai.png" alt="" class="solve_img_wx3">
                    </div>
                    <div class="solve_single_box solve_single_box4">
                        <p class="sales">优质品库</p>
                        <ul class="list_three">
                            <li>·丰富的选品库淘宝，京东，蘑菇街，亚马逊等多平台入驻</li>
                            <li>·全网数据，锁定高佣，高效率分析</li>
                        </ul>
                        <!--条纹布局-->
                        <p class="bar_one bar_color_4 checked_box4"></p>
                        <p class="bar_two bar_color_4 checked_box4"></p>
                        <p class="bar_three bar_color_4 checked_box4"></p>
                        <p class="bar_four bar_color_4 checked_box4"></p>
                        <p class="bar_five bar_color_4 checked_box4"></p>
                        <p class="bar_six bar_color_4 checked_box4"></p>
                        <img src="/images/web/tianmao_jiejuefangan.png" alt="" class="solve_img"/>
                        <img src="/images/web/yamaxun.png" alt="" class="solve_img_ymx">
                    </div>
        </div>
            </div>
            </div>
        </div>
        <!--横向滚动条-->
            <div id="scrollline">
                <div id="scrollbtn">
                </div>
            </div>
        </div>


    </div>
</seation>
    <div class="clear"></div>
<!--页脚-->
<footer class="container-fluid pyt_footer_box">
    <div class="container-fluid pyt_center_footer">
        <ul class="pyt_footer">
            <li>公司官网</li>
            <li>公司网站</li>
            <li>合作伙伴1</li>
            <li>合作伙伴2</li>
        </ul>
        <div class="clear"></div>
        <p class="pyt_remark">2017-2017 www.tkhd.com朋友推--蜀CP备170234号-1 成都推客互动</p>
    </div>
</footer>
</div>
</body>
<script src="/web/lib/jquery/dist/jquery.js"></script>
<script src="/web/lib/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/web/js/com.js"></script>
<script src="/web/js/index.js"></script>
</html>