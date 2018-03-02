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
    <link rel="stylesheet" href="/web/css/about_us.css"/>
</head>
<body>
<!--头部-->
<div class="container-fluid">
@include('web.layouts.header')
    <!--banner部分-->
    <nav class="pyt_nav" id="pyt_nav">
        <div class="container">
        </div>
    </nav>
    <!--中心板块-->
    <seation class="pyt-seation container-fluid">
        <!--我们是谁-->
        <div class="who_are_we">
            <div class="who_are_we_title">
                <p class="font_size28">我们是谁</p>
            </div>
            <div class="who_are_we_content">
                <p class="font_size16">四川推客互动科技有限公司于（www.tuike198.com）2017年11月28日成立。是一个全新的电商社交平台，目前拥有员工200人以上，成员均来自阿里、腾讯、金山、小米企业，公司实力雄厚，技术团队强大。</p>
                <p class="font_size16">推客互动公司深刻了解每个推客每个阶段需要具备的能力，针对每个人都有不同的课程体系。并为企业提供SAAS模式的内部推客商学院。同时提供给企业一些技术支持和渠道服务。</p>
                <p class="font_size16">推客互动全体员工不断努力，相信在不久的将来会帮助到更多需要帮助的人。源于社会，回馈社会。</p>
            </div>
            <div id="who_are_we_box_all">
                <div class="who_are_we_box">
                    <img src="/images/web/about_us_icon1.png" alt="" />
                    <p class="font_size20">我们沉浸于用户体验</p>
                    <p class="font_size20">帮您挖掘和创新更大商机的可能</p>
                </div>
                <div class="who_are_we_box">
                    <img src="/images/web/about_us_icon2.png" alt="" />
                    <p class="font_size20">服务思维下的商业设计</p>
                    <p class="font_size20">撇弃浮夸去直达共同的目标</p>
                </div>
                <div class="who_are_we_box">
                    <img src="/images/web/about_us_icon3.png" alt="" />
                    <p class="font_size20">精益合作和分享的态度</p>
                    <p class="font_size20">让我们鼎力相助你的梦想</p>
                </div>
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
<script src="/web/js/about_us.js"></script>
</html>