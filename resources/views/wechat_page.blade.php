<?php
    $price = floatval($pageInfo['price_full'] - $pageInfo['coupon_price']);
    $taoCode = $pageInfo['tao_code'];
    $couponPrice = floatval($pageInfo['coupon_price']);
    $pic = (new \App\Helpers\GoodsHelper())->resizePic($pageInfo['pic'], "310x310");
    $titles = [
        '生活百科',
        '网址导航',
        '今日头条',
        '生活常识',
    ];
    $pageTitle = array_random($titles);
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>{{$pageTitle}}</title>
    <link href="/css/wechat_page.css?v=1" rel="stylesheet">
</head>
<body>

<div id="pull" class=" detail-product">
    <div class="scroll-box">
        <div class="content detail-product-head">
            <div class="detail-product-img" onclick="openTips();">
                <img src="{{$pic}}" alt="{{$pageInfo['title']}}">
            </div>
            <!--商品信息-->
            <div class="media-list line-btm">
                <div class="media-list-title line-top">{{$pageInfo['title']}}</div>
                @if($pageInfo['description'])
                    <div class="media-list-subtext"><b>小编推荐：</b>{{$pageInfo['description']}}</div>
                @endif
                <div class="media-list-info flex-center oh">
                    <div class="flex-col">
                        <i class="rmb media-arial fl">&yen;</i>
                        <span class="media-arial media-price fl"> {{$price}}</span>
                        <div class="fl coupon-txt">
                            <p class="old-price media-arial"><i class="fl">&yen;</i> {{floatval($pageInfo['price_full'])}}</p>
                            <p>券后价</p>
                        </div>
                        <span class="fl coupon-price">
                            <b class="price flex-center">
                                <i class="media-arial">&yen;</i>
                                <i class="media-arial">{{$couponPrice}}</i></b>
                            <img src="/images/quan_03.png" alt="">
                        </span>
                        <div class="ios-btn">
                            <a href="javascript:iosOpen();">苹果一键购</a>
                        </div>
                    </div>
                </div>
            </div>

            <!--淘口令-->
            <div class="media-list media-tkl text-center">
                <div class="detail-command">
                    <div class="detail-command-box">
                        <span id="code1_ios">{{$taoCode}}</span>
                        <input type="text" value="{{$taoCode}}" onfocus="iptNum(this, true);" oninput="iptNum(this, false);">
                    </div>
                </div>
                <p class="tkl-txt">长按复制上方淘口令，打开手机淘宝购买</p>
            </div>
            <div class="copy-tao-words">
                <a class="copy-tao-words-btn" data-taowords="{{$taoCode}}">
                    一键复制
                </a>
                <div class="copy-tao-words-txt">点击复制后，请打开【手机淘宝】购买！</div>
            </div>
        </div>

        <!--加载失败-->
        <div class="detail-load-failed">
            <a href="javascript:;">
                <span> <b class="fl">查看图文详情</b> <img src="/images/arrow_03.png" alt=""></span>
            </a>
        </div>

        <!--内容-->
        <div id="content" class="detail-content line-top line-btm">

        </div>
    </div>
</div>

<!--底总按钮-->
<div class="pr detail-footer-bar line-top" style="display: none;">
    <a class="detail-coupon-after detail-ft-bar text-left" href="javascript:;">
        <p class="price-tit">
            <span class="fl">券后</span><i class="fl media-arial">&yen;</i>
        </p>
        <b class="media-arial">{{$price}}</b>
    </a>
    <a class="detail-coupon detail-ft-bar flex-center" href="javascript:;" onclick="openTips();">
        <p>优惠券</p>
        <p><b class="media-arial">{{$couponPrice}}</b> 元</p>
    </a>
    <a class="detail-coupon-buy" href="javascript:;" onclick="openTips();">
        <b>领券购买</b>
    </a>
</div>

<!--口令复制蒙版-->
<div class="dialog">
    <div class="detail-mask"></div>
    <div class="detail-mask-content">
        <div class="detail-mask-allow">
            <img src="/images/allow-top.png" alt="">
        </div>
        <div class="detail-mask-command">
            <div class="detail-mask-command-head">
                <div class="detail-mask-command-ios">
                    <p><span>请点击右上角</span> <img src="/images/browser-allow.png" alt=""></p>
                    <p><span>并选择<i>在<i class="media-arial">Safari</i>中打开</i></span> <img src="/images/browser.png" alt=""></p>
                </div>
                <div class="detail-mask-command-android">
                    <p><span>请点击右上角</span> <img class="android-img" src="/images/browser-allow.png" alt=""></p>
                    <p><span>并选择<i> 在浏览器中打开</i></span></p>
                </div>
                <p><span>就可以到淘宝下单啦！</span></p>
            </div>
            <div class="detail-mask-con">
                <div class="detail-mask-con-title">
                    <div class="detail-mask-title-box">
                        <p>或者</p>
                    </div>
                    <div class="detail-mask-line"></div>
                </div>
                <div class="self-copy-area">
                    <p class="detail-mask-tips">长按复制下方淘口令，打开手机淘宝购买</p>
                    <div class="btn detail-mask-command-box">
                        <span id="code2_ios" class="media-arial">{{$taoCode}}</span>
                        <textarea class="media-arial" onfocus="iptNum(this, true);" oninput="iptNum(this, false);">{{$taoCode}}</textarea>
                    </div>
                </div>
                <div class="copy-tao-words">
                    <a class="copy-tao-words-btn" data-taowords="{{$taoCode}}">
                        一键复制
                    </a>
                    <div class="copy-tao-words-txt">点击复制后，请打开【手机淘宝】购买！</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    window.goods_id = '{{$pageInfo['goods_id']}}';
    window.redirect_url = '{!!$pageInfo['url']!!}';
</script>
<script src="/js/jquery.2.1.4.js"></script>
<script src="/js/layer/layer.js"></script>
<script src="/js/imgLazy.v1.js"></script>
<script src="/js/clip-board.min.js"></script>
<script src="/js/detail.js?v=6"></script>

</body>
</html>
