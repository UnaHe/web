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
            <div class="detail-product-img">
                <img src="{{$pic}}">
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
                    一键复制到手机淘宝购买
                </a>
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
