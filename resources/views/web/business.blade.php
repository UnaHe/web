<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>商务页面</title>
    <!--设置视口-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-sclable=0">
    <!-- 设置主题样式-->
    <!--引入重置样式-->
      <link rel="stylesheet" href="/web/lib/bootstrap/dist/css/bootstrap.min.css"/>
       <link rel="stylesheet" href="/web/css/reset.css">
          <link rel="stylesheet" href="/web/css/com.css"/>
          <link rel="stylesheet" href="/web/css/business.css"/>
</head>
<body>
<!--头部-->
<div class="container-fluid">
@include('web.layouts.header')
    <!--banner部分-->
    <nav class="pyt_nav" id="pyt_nav">
        <p id="jion_people">招募合伙人</p>
        <p id="advantage">零风险 <span>/</span> 零投资 <span>/</span> 不压货 <span>/</span> 不囤货</p>
        <p id="save_money">省钱还能赚钱</p>
    </nav>

    <!--中心板块-->
    <seation class="pyt-seation container-fluid">
        <!--整合10万品牌商家提供数据和营销服务-->
        <div id="product_column">
            <div id="pruduct_column_title" class='container'>
                <p>整合<span>10万</span>品牌商家提供数据和营销服务</p>
            </div>
            <div id="product_all_box">
                <div class="product_single_box">
                    <img src="/images/web/movepeopleICON.png" alt="" class="auto">
                    <p class="slash">
                      <img src="/images/web/xiegang.png" alt="">
                    </p>
                    <p class="move_people">把握千万移动端人群</p>
                </div>
                <div class="product_single_box">
                    <img src="/images/web/yinxiao.png" alt="" class="auto">
                    <p class="slash">
                        <img src="/images/web/xiegang.png" alt="">
                    </p>
                    <p class="move_people">全平台整合营销</p>
                </div>
                <div class="product_single_box">
                    <img src="/images/web/share.png" alt="" class="auto">
                    <p class="slash">
                        <img src="/images/web/xiegang.png" alt="">
                    </p>
                    <p class="move_people move_peoples">商品一键转发</p>
                </div>
            </div>
        </div>
        <!--企业生态链-->
        <div id="list_column">
            <div id="list_column_title">
                <p class="background_column left3"></p>
                <p class="fontSize40 left45">企业生态链</p>
                <p class="font-size20px left44">Enterprise ecological chain</p>
            </div>
            <!--矩阵排版-->
            <div id="matrix" class='container'>
              <div id='null_box'>
                <img src="/images/web/xuxian.png" alt="" id="xuxian">
                <img src="/images/web/tuikeLOGO.png" alt="" id="tuikeLOGO">
                <p class="circle circle_three"></p>
                   <span class="circle_three span1">优质QQ群</span>
                <p class="circle circle_two"></p>
                   <span class="circle_two span2"> 高配定制</span>
                <p class="circle circle_one"></p>
                    <span class="circle_one span3">高校渠道</span>
                <p class="circle circle_four"></p>
                   <span class="circle_four span4">广告位</span>
                <p class="circle circle_five"></p>
                  <span class="circle_five span5">APP</span>
                <p class="circle circle_seven"></p>
                   <span class="circle_seven span6">朋友推</span>
                <p class="circle circle_six"></p>
                <span class="circle_six span7">朋友淘</span>
               </div>
            </div>
        </div>

        <!--加入我们-->
        <div id="solve">
            <div id="solve_title">
                <p class="background_column left3 left6"></p>
                <p class="fontSize40 left45">加入我们</p>
                <p class="font-size20px left_solution left44 left_10">Join us</p>
            </div>
            <!--解决方案详细布局-->
            <div id="test">
                <img src="/images/web/joinusfloat.png" alt="">
                <p class="let">让流量更省钱，让店铺更赚钱</p>
                <p class="scan">扫描下方二维码，联系我们</p>
                <img src="/images/web/tuikeQRcode.png" alt="" id="tuileQRcode">
            </div>
        </div>
    </seation>
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
</html>