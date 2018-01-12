@extends('web.layouts.goods')

@section('css')
    <style>
        .good-info {
            width: 1100px;
            height: 680px;
            background: #1b6d85;
        }

        .main-left {
            width: 428px;
            height: 680px;
            float: left;
        rgba(255, 255, 255, 1);
        }

        .main-left-img img {
            width: 428px;
            height: 428px;
        }

        .main-left ul li {
            list-style: none;
            float: left;
        }

        .main-left ul li img {
            width: 75px;
            height: 75px;
        }

        .main-right {
            width: 632px;
            height: 680px;
            float: right;
            background: #ffffaa;
        }

        .main-right-top {
            width: 632px;
            height: 150px;
            background: #fff000;
        }

        .sell-tpl-title {
            width: 632px;
            height: 40px;
            background: #ffc028;
        }

        .sell-tpl-content {
            width: 632px;
            height: 460px;
            background: #ffad6d;
        }

        .sell-tpl-qq, .sell-tpl-weixin {
            width: 296px;
            height: 460px;
            background: #ff9402;
        }

        .sell-tpl-qq-content {
            width: 220px;
        }

        .sell-tpl-qq-btn button {
            width: 296px;
            height: 40px;
            margin-bottom: -334px;
            line-height: 40px;
        }

        .sell-tpl-qq, .sell-tpl-qq-content {
            float: left;
        }

        .sell-tpl-weixin, .sell-tpl-logo, .sell-tpl-weixin-img {
            float: right;
        }

        .sell-tpl-content-img {
            width: 80px;
            height: 100px;
        }

        .clear {
            clear: both;
        }

        .sell-tpl-weixin-btn {
            width: 296px;
            height: 40px;
            /*margin-bottom: -334px;*/
            line-height: 40px;
        }

        .sell-tpl-weixin-btn button {
            width: 145px;
            height: 40px;
            margin-bottom: -359px;
            line-height: 40px;
        }

    </style>

@stop

@section('main')
    <div class="main good-info">
        <div class="main-left">
            <div class="main-left-img">
                <img id="img-show" src="/images/web/good_test1.jpg">
            </div>
            <ul class="images">
                <li><img src="/images/web/good_test1.jpg"></li>
                <li><img src="/images/web/good_test2.jpg"></li>
            </ul>

        </div>

        <div class="main-right">

            <div class="main-right-top">
                <p>{{$good['short_title']}}</p>

                <p>{{$good['des']}}</p>

                <p><span>卷后</span>
                    <span>¥{{$good['price']}}</span><span>佣金</span><span>¥ {{$good['commission_finally']}}</span><span>月销量{{$good['sell_num']}}</span>
                </p>
            </div>
            <div class="main-right-bottom">
                <div class="sell-tpl-title">
                    <span>营销模板</span> <span>请<a href="#">登录</a>授权</span>

                </div>
                <div class="sell-tpl-content">
                    <div class="sell-tpl-qq">
                        <p>QQ文案</p>
                        <div class="sell-tpl-qq-content">
                            <img class="sell-tpl-content-img" src="{{$good['pic']}}">

                            <p id="qq-des">{{$good['des']}}</p>
                        </div>
                        <div class="sell-tpl-logo">
                            <img src="/images/web/QQ_logo.png"/>
                        </div>
                        <div class="sell-tpl-qq-btn">
                            <button class="qq_generate" type="button">一键生成</button>
                        </div>
                    </div>


                    <div class="sell-tpl-weixin">
                        <p>微信文案</p>

                        <div>
                            <div class="sell-tpl-logo">
                                <img src="/images/web/weixin_logo.png"/>
                            </div>
                            <div class="sell-tpl-weixin-img">
                                <img class="sell-tpl-content-img"
                                     src="{{$good['pic']}}">
                            </div>
                        </div>

                        <div class="clear"></div>
                        <div>
                            <div class="sell-tpl-logo">
                                <img src="/images/web/weixin_logo.png"/>
                            </div>
                            <div class="sell-tpl-weixin-content">
                                <p>{{$good['des']}}</p>
                            </div>
                        </div>

                        <div class="sell-tpl-weixin-btn">
                            <button type="button">一键生成</button>
                            <button type="button">生成长图</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <div class="main">
        <!--主体商品遍历部分 start-->
        <div class="wrapper">
            <div class="goods-list clearfix">
                @foreach($list as $k => $v)
                    <div id="goods-items_5069853" data_goodsid="529065425856" data-sellerid="2378275931"
                         class="goods-item ">
                        <div class="goods-item-content">
                            <div class="goods-img">
                                <a href="{{url('/goods/'. $v['id']).'?columnCode='.$active['active_column_code']}}"
                                   target="_blank">
                                    <img class="lazy" src="{{ $v['pic'] }}">
                                </a>
                            </div>
                            <div class="goods-info">
    <span class="goods-tit">
    <a href="/goods/{{ $v['id'] }}" target="_blank">
        {{ $v['short_title']}}
    </a>
    </span>

                                <div class="goods-quan">
                                    <div class="goods-coupon-price">
                                        <span class="goods-coupon">券</span>

                                        <div class="goods-coupon-1">
                                            <span class="goods-coupon-yuan">&nbsp;{{ $v['coupon_price']}}</span>
                                            <span class="goods-coupon-unit">元&nbsp;</span>
                                        </div>
                                    </div>
                                    <div class="goods-sales">
                                        <span class="goods-sales-unit">月销: </span>
                                        <span class="goods-sales-num">{{ $v['sell_num'] }}</span>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="goods-qjy">
                                    <div class="goods-price"><span>券后</span><span
                                                class="rmb-style">￥</span><b>{{ $v['price'] }}</b></div>
                                    <div class="goods-yj"><span>佣金</span><span
                                                class="rmb-style">￥</span><b>{{ $v['commission_finally'] }}</b></div>
                                </div>
                                <div class="@if ($v['is_tmall'] !== 0) icon-tmail @else icon-taobao @endif">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!--主体商品遍历部分 start-->
    </div>
@stop

@section('js')
    <script type="text/javascript" src="/js/web/clipboard.js"></script>
    <script type="text/javascript">
        /**
         * 设置主图
         */
        $('.images li img').click(function () {
            var src = $(this).attr('src');
            $('.sell-tpl-content-img').attr('src', src);
            $('#img-show').attr('src', src);
        })

        /**
         * 目前只能复制文字
         */
        var clipboard = new Clipboard('.qq_generate', {
            text: function () {
                return $('#qq-des').html();
            }
        });
        clipboard.on('success', function (e) {
            alert("复制成功");
        });

        clipboard.on('error', function (e) {
            console.log(e);
        });


    </script>
@stop