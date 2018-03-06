<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>{{$title}}-朋友惠</title>
    <!--设置视口-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-sclable=0">
    <!--引入重置样式-->
    <link rel="stylesheet" href="/web/lib/bootstrap/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/web/css/reset.css"/>
    <link rel="stylesheet" href="/web/css/com.css"/>
    <link rel="stylesheet" href="/web/css/py_tao.css"/>
</head>
<body>
<div class="container-fluid">
    <!--头部-->
    <header class="herder">
        <div class="container">
            <div class="herder-left">
                <a href="/"><img alt="logo" src="/images/web/py_tao/LOGO.png"/><span class="herder-left-title">朋友淘</span></a>
            </div>
            <ul class="herder-nav">
                <li><a>主页</a></li>
                <li><a>关于我们</a></li>
                <li><a>介绍</a></li>
                <li><a>角色</a></li>
                <li><a>下载</a></li>
            </ul>
        </div>
    </header>
    <!--中心板块-->
    <seation class="pyt-seation container-fluid">
        <!--朋友淘-->
        <div class="pytao">
            <div class="pytao-left">
                <p class="font_size28">朋友淘</p>
                <p class="font_size28">汇聚全网优惠券</p>
                <p class="font_size28">让你不仅省钱，还赚钱</p>
                <img src="/images/web/py_tao/qr_code.png" />
                <p class="font_size28">每天都是双十一</p>
                <p class="font_size28">扫码关注官方微信公众号下载</p>
                <div class="open_btn">立即下载</div>
            </div>
            <div class="pytao-right">
                <img src="/images/web/py_tao/py_tao.png" />
            </div>
        </div>
        <!--联系我们-->
        <div class="contact_us">
            <div class="contact_us_title">
                <p class="font_size28">联系我们</p>
            </div>
            <div id="contact_us_box_all">
                <div class="contact_us_box">
                    <div class="circle">
                        <img src="/images/web/about_us_phone.png" alt="" />
                    </div>
                    <p class="font_size16">给我们打电话</p>
                    <p class="font_size28">028-83173171</p>
                </div>
                <div class="contact_us_box">
                    <div class="circle">
                        <img src="/images/web/about_us_QQ.png" alt="" />
                    </div>
                    <p class="font_size16">QQ在线联系</p>
                    <p class="font_size28">1280977784</p>
                </div>
                <div class="contact_us_box">
                    <div class="circle">
                        <img src="/images/web/about_us_email.png" alt="" />
                    </div>
                    <p class="font_size16">给我们发邮件</p>
                    <p class="font_size28">service@tuike198.com</p>
                </div>
            </div>
        </div>
        <!--关注微信-->
        <div class="follow_wechat">
            <div class="follow_wechat_title">
                <p class="font_size28">关注微信</p>
            </div>
            <div class="follow_wechat_content">
                <p class="font_size16">扫一扫二维码，关注我们的微信公众号</p>
            </div>
            <div class="follow_wechat_qr">
                <img src="/images/web/about_us_wechat_qr.png" alt="" />
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
<script src="/web/js/com.js"></script>
<script src="/web/js/py_tao.js"></script>
</html>