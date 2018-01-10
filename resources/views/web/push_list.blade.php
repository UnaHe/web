<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}} - 朋友推</title>
    <link rel="stylesheet" href="/assets/css/amazeui.css"/>
    <link rel="stylesheet" href="/css/web/common.css"/>
    <link rel="stylesheet" href="/css/web/push_list.css"/>

    <style>
        /*登录下拉菜单*/
        ul {
            list-style: none;
        }

        .nav > li {
            float: left;
        }

        .nav a {
            display: block;
            text-decoration: none;
            width: auto;
            height: 40px;
            text-align: center;
            line-height: 42px;
            color: rgba(238, 238, 238, 1);
            background-color: rgba(238, 238, 238, 1);
        }

        .drop-down {
            position: relative;
        }

        .drop-down li {
            width: 100px;
        }

        .drop-down-content {
            padding: 0;
            display: none;
            position: absolute;
            margin-top: 0px;
            z-index: 9999;
        }

        .drop-down-content li a {
            background: white;
            line-height: 30px;
            height: 30px;
        }

        #login {
            width: 100px;
            margin-right: -10px;
        }

        /*分类/筛选/排序样式*/
        .category, .screen, .sort {
            width: 1100px;
            height: 40px;
            background: white;
            border: 1px solid #F0F0F0;
        }

        /*筛选样式*/
        .screen {
            margin-top: 20px;
            padding-top: 5px;
            height: auto;
        }

        /*排序样式*/
        .sort {
            background: white;
            margin-top: 20px;
            height: 38px;
        }

        /*分类span样式*/
        .category span {
            margin-left: 19px;
            width: 59px;
            height: 13px;
            font-size: 14px;
            font-family: NotoSansHans-Regular;
            color: rgba(153, 153, 153, 1);
            line-height: 40px;
        }

        /*筛选排序span样式*/
        .screen span, .sort span {
            margin-left: 5px;
            font-family: NotoSansHans-Regular;
            color: rgba(153, 153, 153, 1);
            font-size: 14px;
        }

        /*筛选input样式*/
        .screen input {
            margin-left: 20px;
            font-family: NotoSansHans-Regular;
            color: rgba(153, 153, 153, 1);
            font-size: 14px;
        }

        .screen .screen-input-text {
            margin-left: 115px;
            margin-top: 9px;
            border-top: 2px dashed #F0F0F0;
            font-size: 14px;
            color: rgba(153, 153, 153, 1);
        }

        .screen-input-text input {
            margin: 9px 0px;
            border: 1px solid;
            width: 60px;
            line-height: 20px;
        }

        .screen-input-text span {
            margin-left: 20px;
        }

        /*金额输入框自带人民币符号*/
        .money-input {
            background-image: url('/images/web/money.png');
            background-repeat: no-repeat;
            background-position: left;
            text-indent: 10px;
        }

        /*筛选按钮样式*/
        .screen-btn {
            background-color: rgba(225, 176, 90, 1);
            color: white
        }

        /*排序内容样式*/
        .sort div {
            display: inline-block;
            text-align: center;
            width: 62px;
            height: 38px;
            line-height: 38px;
        }

        /*分类/高级筛选/排序的状态样式*/
        .main .active {
            background: rgba(246, 246, 246, 1);
            color: rgba(225, 176, 90, 1);
        }

        .sort a:link,.sort a:visited{
            text-decoration:none;
            font-size:14px;
            font-family:NotoSansHans-Regular;
            color:rgba(102,102,102,1);
        }
        /*.sort a:hover{color:#ff0000;}*/

    </style>
    <script src="/js/jquery.3.2.1.js"></script>
    <script src="/js/layer/layer.js"></script>
    <script src="/assets/js/amazeui.js"></script>

    <script type="text/javascript">
        $(function () {
            $('#login').click(function () {
                if ($('.drop-down-content').css('display') == 'none') {
                    $(this).css('background', 'white');
                    $('.drop-down-content').css('display', 'block');
                } else {
                    $(this).css('background', 'rgba(238,238,238,1)');
                    $('.drop-down-content').css('display', 'none');
                }
            });


//            $('.select_cat_id').click(function(){
//                var cat_id=$(this).attr('cat_id');
//                $.ajax({
//                    type: "POST",
//                    url: getCodeUrl,
//                    data: {username: $("#username").val()},
//                    dataType: "json",
//                    success: function (data) {
//                        if (data.code==200) {
//                            $("#codeId").val(data.data[0]);
//                        } else {
//                            layer.alert(data.msg.msg, {
//                                skin: 'layui-layer-lan' //样式类名
//                                ,closeBtn: 0
//                            });
//                        }
//                    }
//                });
//            });

            $('.screen-checkbox').click(function () {

                $('.screen-checkbox').each(function ($key, $val) {
                    $($val).prop('checked', false);
                });
                $(this).prop('checked', true);
            });

            $('.screen-btn').click(function () {
                var code = '';
                $('.screen-checkbox').each(function ($key, $val) {
                    if ($($val).prop('checked')) {
                        code = $($val).val()
                    }

                });
            });
        })
    </script>


</head>
<body>
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
                <div class="topbar-right am-text-right am-fr" style="display: inline">
                    <ul class="nav">
                        @if(\Illuminate\Support\Facades\Auth::check())
                            <li class="drop-down">
                                <a href="#" id="login">{{\Illuminate\Support\Facades\Auth::user()->phone}}</a>
                                <ul class="drop-down-content">
                                    <li><a href="#">个人中心</a></li>
                                    <li><a href="#">授权管理</a></li>
                                    <li><a href="#">账号安全</a></li>
                                    <li><a href="#">退出</a></li>
                                </ul>
                            </li>
                        @else
                            <li><a href="{{url('login')}}">登录</a></li>
                        @endif
                        <li class="mod_copyright_split">|</li>
                        <li><a href="#">注册</a></li>
                        <li class="mod_copyright_split">|</li>
                        <li><a href="#">企业官网</a></li>
                        <li class="mod_copyright_split">|</li>
                        <li><a href="#">商家合作</a></li>
                        <li class="mod_copyright_split">|</li>
                        <li><a href="#">微信交流群</a></li>
                    </ul>

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
                <a href=""><img src="/images/web/logo.png" alt=""/></a>
            </div>
            <div class="search bar6 f1">
                <span class="search_span">综合搜索</span>
                <span class="search_span1"></span>

                <form action="{{url('/columns/zhengdianmiaosha/goods')}}" method="get">
                    <input type="text" placeholder="搜索标题、商品ID、商品链接" name="keyword">
                    <button type="submit"><img src="/images/web/search.png" alt=""/></button>
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
                <li class="cur"><a href="{{url('/')}}">主页</a></li>
                <li class="">
                    <a href="{{url('/columns/today_tui/goods')}}">今日必推</a>
                </li>
                <li class="">
                    <a href="{{url('/columns/zhengdianmiaosha/goods')}}">限时快抢</a>
                </li>
                <li class="">
                    <a href="{{url('/columns/today_jing/goods')}}">今日精选<i class="sf_new"></i></a>
                </li>
                <li class="">
                    <a href="{{url('/columns/baokuan/goods')}}">爆款专区<i class="app_new"></i></a>
                </li>
                <li>
                    <a href="{{url('/columns/today_jing/goods')}}"><img src="/images/web/food.png" alt=""/>美食精选</a>
                </li>
                <li>
                    <a href="{{url('/columns/today_jing/goods')}}"><img src="/images/web/furniture.png" alt=""/>家居精选</a>
                </li>
            </ul>
        </div>
    </div>
    <!--导航菜单 end-->
</div>

<div class="pyt-banner">
    <!--广告位-->
</div>
<div class="main category">
    <span>商品分类:</span>
    <a href="{{url('/columns/zhengdianmiaosha/goods')}}">
        <span class="select_cat_id  @if($active['active_category']=='') active @endif" cat_id="">全部</span>
    </a>
    @foreach($categorys as $v)
        <a href="{{url('/columns/zhengdianmiaosha/goods').'?category='.$v->id}}">
            <span class="select_cat_id @if($active['active_category']==$v->id) active @endif"
                  cat_id="{{$v->id}}">{{$v->name}}</span>
        </a>
    @endforeach
</div>

<div class="main screen">
    <form method="get" action="{{url('/columns/zhengdianmiaosha/goods')}}">
        {{csrf_field()}}
        <span>高级筛选:</span>
        <input class="screen-checkbox" name="today" value="1" type="checkbox"><span>今日新品</span>
        <input class="screen-checkbox" name="isTmall" value="1" type="checkbox" value="11"><span>只看天猫</span>
        <input class="screen-checkbox" name="isJpseller" value="1" type="checkbox"><span>金牌卖家</span>
        <input class="screen-checkbox" name="isQjd" value="1" type="checkbox"><span>旗舰店</span>
        <input class="screen-checkbox" name="isTaoqianggou" value="1" type="checkbox"><span>海抢购</span>
        <input class="screen-checkbox" name="isJuhuashuan" value="1" type="checkbox"><span>聚划算</span>
        <input class="screen-checkbox" name="isNine" value="1" type="checkbox"><span>9.9包邮</span>
        <input class="screen-checkbox" name="isTwenty" value="1" type="checkbox"><span>20元封顶</span>
        <input class="screen-checkbox" name="isJyj" value="1" type="checkbox"><span>极有家</span>
        <input class="screen-checkbox" name="isHaitao" value="1" type="checkbox"><span>海淘</span>
        <input class="screen-checkbox" name="isYfx" value="1" type="checkbox"><span>运费险</span>

        <div class="screen-input-text">
            卷区间:<input type="text" name="minCouponPrice" class="money-input">&nbsp;-&nbsp;<input type="text"
                                                                                                 name="maxCouponPrice"
                                                                                                 class="money-input">
            <span>价格:<input type="text" name="minPrice" class="money-input">&nbsp;-&nbsp;<input type="text"
                                                                                                name="maxPrice"
                                                                                                class="money-input"></span>
            <span>佣金比例><input name="minCommission" type="text"></span>
            <span>销量><input name="minSellNum" type="text"></span>
            <span><button class="screen-btn">筛选</button></span>
        </div>

    </form>
</div>
<div class="main sort">
    <a href="{{url('/columns/zhengdianmiaosha/goods')}}">  <div class="active">综合</div>  </a>
    <a href="{{url('/columns/zhengdianmiaosha/goods').'?sort=2'}}">
        <div>最新</div>
    </a>
    <a href="{{url('/columns/zhengdianmiaosha/goods').'?sort=3'}}">
        <div>销量</div>
    </a>
    <a href="{{url('/columns/zhengdianmiaosha/goods').'?sort=1'}}">
        <div>人气</div>
    </a>
    <a href="{{url('/columns/zhengdianmiaosha/goods').'?sort=-4'}}">
        <div>价格</div>
    </a>
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
                            <a href="/goods/{{ $v['id'] }}" target="_blank">
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


</body>
</html>