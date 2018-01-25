<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>限时抢购</title>
    <!--设置视口-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-sclable=0">
    <!-- 设置主题样式-->
    <link rel="stylesheet" href="/web/lib/bootstrap/dist/css/bootstrap.min.css"/>

    <!-- 引入字体样式-->
    <link rel="stylesheet" href="/web/lib/bootstrap/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/web/css/reset.css"/>
    <link rel="stylesheet" href="/web/css/com.css"/>
    <link rel="stylesheet" href="/web/css/flash_sale.css"/>
</head>
<body>
<!--头部-->
<div class="container-fluid">
    @include('web.layouts.header')

            <!--搜索导航栏-->
    @include('web.layouts.search')

            <!--导航-->
    @include('web.layouts.navigation')

            <!--主题部分-->
    <seation class="pyt-seation container-fluid">
        <div class="row  container">
            @if(!empty($list))
                    <!-- 中心内容-->
            <!--时间点-->
            <p class="left_arr">
                <span class="glyphicon glyphicon-menu-left prev" aria-hidden="true"></span>
            </p>
            <lable class="col-sm-12 items"
                   style="overflow: hidden; position: relative; visibility: visible; width: 100%; height: 40px;">

                <ul class="rush_point scroll_demo" style="position: absolute; left: 0px;">
                    @foreach($time_step as $v)
                        <a href="{{url('/miaosha/goods').'?active_time='.$v['active_time']}}">
                            <li class="@if($v['active_time']==$active['active_time']) time_active @endif">
                                <p>{{$v['time']}}</p>

                                <p>{{$v['status']}}</p>
                            </li>
                        </a>
                    @endforeach
                </ul>

            </lable>
            <p class="right_arr">
                <span class="glyphicon glyphicon-menu-right next" aria-hidden="true"></span>
            </p>

            @foreach($list as $key=>$val)
                <lable class="col-sm-5">
                    <div class="img_left">
                        <a href="{{url('/goods/'. $val['id']).'?columnCode='.$active['active_column_code']}} "
                           target="_blank" class="click_open">
                            <image src="{{$val['pic']}}"></image>
                        </a>
                    </div>
                    <div class="text_right">
                        <a href="{{url('/goods/'. $val['id']).'?columnCode='.$active['active_column_code']}} "
                           target="_blank" class="click_open">
                            <p class="title"> {{str_limit($val['short_title'], $limit = 39, $end = '...')}}</p>

                            <p class="full_name">{{str_limit($val['des'], $limit = 120, $end = '...')}}</p>
                        </a>

                        <p class="discount"><span class="coupun">券</span> {{ $val['coupon_price']}}元</p>

                        <div class="pyt_price">
                            <p class="floor_price"><span class="floor_price_title">券后价</span> <span
                                        class="price ">￥{{ $val['price']}}</span></p>

                            <p class="floor_price floor_price_right "><span class="floor_price_earnings">预计收益</span>
                                <span class="price">￥{{ $val['commission_finally']}}</span></p>
                        </div>
                        <p class="quick"><span class="sale_num">  {{ $val['sell_num']}}</span>已售
                            <a href="{{url('/goods/'. $val['id']).'?columnCode='.$active['active_column_code']}} "
                               target="_blank" class="click_open">
                            <span class="sale_quick">马上推</span>
                        </a>
                        </p>
                    </div>
                </lable>
            @endforeach

            @else
                <div class="kong"><img src="/web/images/kong.png"></div>
            @endif


        </div>
    </seation>
    <div class="clear"></div>
    <!--页脚-->
    @include('web.layouts.footer')

</div>
</body>
<script src="/web/lib/jquery/dist/jquery.js"></script>
<script src="/web/lib/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/web/js/com.js"></script>
<script>

    //整点购轮播
    $(function () {
        var $content = $(".rush_point");
        var i = 5;  //已知显示的<li>元素的个数
        var m = 5;  //用于计算的变量
        var count = $content.find("li").length;//总共的<li>元素的个数

        $(".next").click(function () {

            if (!$content.is(":animated")) {  //判断元素是否正处于动画，如果不处于动画状态，则追加动画。
                if (m < count) {  //判断 i 是否小于总的个数
                    m++;

                    $content.animate({left: "-=226px"}, 600);
                }
            }
        });
        $(".prev").click(function () {
            if (!$content.is(":animated")) {
                if (m > i) { //判断 i 是否小于总的个数
                    m--;
                    $content.animate({left: "+=226px"}, 600);
                }
            }
        });


    })


</script>
</html>