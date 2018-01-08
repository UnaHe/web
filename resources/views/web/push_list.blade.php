<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}} - 朋友推</title>
    <link rel="stylesheet" href="/assets/css/amazeui.css" />
    <link rel="stylesheet" href="/css/web/common.css" />
    <link rel="stylesheet" href="/css/web/push_list.css" />

</head>
<body>
    <div class="layout-header am-hide-sm-only topbar">

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
                            <a href="">登录</a>
                            <span class="mod_copyright_split">|</span>
                            <a href="">注册</a>
                            <span class="mod_copyright_split">|</span>
                            <a href="">企业官网</a>
                            <span class="mod_copyright_split">|</span>
                            <a href="">商家合作</a>
                            <span class="mod_copyright_split">|</span>
                            <a href="">微信交流群</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--公共顶部 end-->
        </div>

        <div class="header-box">
            <!--头部 start-->
            <div class="container">
                <div class="header">
                    <div class="logo f1">
                        <a href=""><img src="/images/web/logo.png" alt="" /></a>
                    </div>
                    <div class="search bar6 f1">
                            <span class="search_span">综合搜索</span>
                            <span class="search_span1"></span>
                        <form>
                            <input type="text" placeholder="搜索标题、商品ID、商品链接" name="cname">
                            <button type="submit"><img src="/images/web/search.png" alt="" /></button>
                            <span></span>
                        </form>
                    </div>
                </div>
            </div>
            <!--头部 end-->
        </div>

        <div class="head-nav">
            <!--导航菜单 start-->
            <div class="nav-main">
                <div class="nav-list clearfix">
                    <ul class="">
                        <li class="cur"><a href="">主页</a></li>
                        <li class="">
                            <a href="">今日必推</a>
                        </li>
                        <li class="">
                            <a href="">限时快抢</a>
                        </li>
                        <li class="">
                            <a href="">今日精选<i class="sf_new"></i></a>
                        </li>
                        <li class="">
                            <a href="">爆款专区<i class="app_new"></i></a>
                        </li>
                        <li>
                            <a href=""><img src="/images/web/food.png" alt="" />美食精选</a>
                        </li>
                        <li>
                            <a href=""><img src="/images/web/furniture.png" alt="" />家居精选</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!--导航菜单 end-->
        </div>

    </div>

    <!--广告位-->
    <div class="pyt-banner">
    </div>

    <div class="main">
        <!--主体商品遍历部分 start-->
        <div class="wrapper">
            <div class="goods-list clearfix">
                @foreach($list as $k => $v)
                <div id="goods-items_5069853" data_goodsid="529065425856" data-sellerid="2378275931" class="goods-item ">
                    <div class="goods-item-content">
                        <div class="goods-img">
                            <a href="goods/{{ $v->id }}" target="_blank">
                                <img class="lazy" src="{{ $v->pic }}">
                            </a>
                        </div>
                        <div class="goods-info">
                            <span class="goods-tit">
                                <a href="goods/{{ $v->id }}" target="_blank">
                                    {{ $v->short_title }}
                                </a>
                            </span>
                            <div class="goods-quan">
                                <div class="goods-coupon-price">
                                    <span class="goods-coupon">券</span>
                                    <div class="goods-coupon-1">
                                        <span class="goods-coupon-yuan">&nbsp;{{ $v->coupon_price }}</span>
                                        <span class="goods-coupon-unit">元&nbsp;</span>
                                    </div>
                                </div>
                                <div class="goods-sales">
                                    <span class="goods-sales-unit">月销: </span>
                                    <span class="goods-sales-num">{{ $v->sell_num }}</span>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="goods-qjy">
                                <div class="goods-price"><span>券后</span><span class="rmb-style">￥</span><b>{{ $v->price }}</b></div>
                                <div class="goods-yj"><span>佣金</span><span class="rmb-style">￥</span><b>{{ $v->commission_finally }}</b></div>
                            </div>
                            <div class="@if ($v->is_tmall !== 0) icon-tmail @else icon-taobao @endif">
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <!--主体商品遍历部分 start-->
    </div>

    <div class="footer">
        <!--公共底部 start-->
        <div class="footer-hd center-block">
            <p class="mod_copyright_links">
                <a href="" target="_blank">公司官网</a>
                <span class="mod_copyright_split">|</span>
                <a href="" target="_blank">公司网站2</a>
                <span class="mod_copyright_split">|</span>
                <a href="" target="_blank">合作伙伴</a>
                <span class="mod_copyright_split">|</span>
                <a href="" target="_blank">合作伙伴2</a>
            </p>
        </div>
        <div class="footer-in"></div>
        <div class="footer-bd center-block">
            <p class="mod_copyright_links">
                <em>&copy; 2017-{{date("Y",time())}} 推客版权所有</em>
            </p>
        </div>
        <!--公共底部 end-->
    </div>

    <script src="/js/jquery.3.2.1.js"></script>
    <script src="/js/layer/layer.js"></script>
    <script src="/assets/js/amazeui.js"></script>

    <script type="text/javascript">

    </script>
</body>
</html>