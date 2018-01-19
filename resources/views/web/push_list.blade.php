<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>{{$title}}-朋友推</title>
    <!--设置视口-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-sclable=0">
    <!-- 设置主题样式-->
    <link rel="stylesheet" href="/web/lib/bootstrap/dist/css/bootstrap.min.css"/>
    <!-- 引入字体样式-->
    <link rel="stylesheet" href="/web/lib/bootstrap/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/web/css/com.css"/>
    <link rel="stylesheet" href="/web/css/choiceness.css"/>



</head>
<body>
<!--头部-->
<div class="container-fluid">
    <header class="pyt_header pyt_hearder_color">
        <nav class="navbar navbar-default  container pyt_hearder_color">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class=""><a href="#">给你的不仅仅是优惠</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown-toggle"><a href="#">1888********</a>
                        </li>
                        <ul class="dropdown-menu">
                            <li><a href="{{url('/userCenter')}}">个人中心</a></li>
                            <li><a href="#">授权管理</a></li>
                            <li><a href="{{url('/accountSecurity')}}">账号安全</a></li>
                            <li><a href="{{url('/logout')}}">退出</a></li>
                        </ul>
                        <li><a href="{{url('register')}}">注册</a></li>
                        <li><a href="#">企业官网</a></li>
                        <li><a href="{{url('/business')}}">商务合作</a></li>
                        <li><a href="#">微信交流群</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!--搜索导航栏-->
    <nav class="navbar navbar-default container">
        <div class="container-fluid pyt_search_nav">
            <div class="navbar-header pyt_navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand pyt_font_size48" href="#">朋友推</a>
                <a class="navbar-brand pyt_font_size48 pyt_color" href="#">Tuike</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                <form class="navbar-form navbar-left">
                    <div class="form-group">
                        <ul class="nav navbar-nav navbar-left">
                            <li class="pyt_searchAll">综合搜索</li>
                        </ul>
                        <input type="text" class="form-control" placeholder="搜索标题、商品ID、商品链接">
                    </div>
                    <button type="submit" class="btn btn-default">搜索图</button>
                </form>
            </div>
        </div>
    </nav>
    <!--导航-->
    <nav class="navbar navbar-inverse container-fluid">
        <div class="container">
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-3">
                <ul class="nav navbar-nav pyt_navbar-nav">
                    <li class=""><a href="{{url('/')}}">主页</a></li>
                    <li class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/columns/today_tui/goods') active @endif"><a href="{{url('/columns/today_tui/goods')}}">今日必推</a></li>
                    <li class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/miaosha/goods') active @endif"><a href="{{url('/miaosha/goods')}}">限时快抢</a></li>
                    <li class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/columns/today_jing/goods') active @endif"><a href="{{url('/columns/today_jing/goods')}}">今日精选</a></li>
                    <li class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/columns/xiaoliangbaokuan/goods') active @endif"><a href="{{url('/columns/xiaoliangbaokuan/goods')}}">爆款专区</a></li>
                    <li class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/columns/meishijingxuan/goods') active @endif"><a href="{{url('/columns/meishijingxuan/goods')}}">美食精选</a></li>
                    <li class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/columns/jiajujingxuan/goods') active @endif"><a href="{{url('/columns/jiajujingxuan/goods')}}">家具精选</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!--主题部分-->
    <seation class="pyt-seation container-fluid">



        <div class="row  container">
            <!-- 中心内容-->
            <!--图片-->

            <div class="img_door">
                <img src="/web/images/push_banner.png" alt="...">
            </div>


            @if($active['active_column_code']!='meishijingxuan' && $active['active_column_code']!='jiajujingxuan')
            <div class="prod_type_box ">
                <p class="prod_type">商品分类：</p>
                <ul class="prod_type_list margin_left4">
                    <a href="{{url('/columns/'.$active['active_column_code'].'/goods')}}">
                    <li class="@if($active['active_category']=='') active @endif">全部</li>
                    </a>
                    @foreach($categorys as $v)
                        <a href="{{url('/columns/'.$active['active_column_code'].'/goods').'?category='.$v->id}}"> <li class="@if($active['active_category']==$v->id) active @endif">{{$v->name}}</li></a>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="prod_type_box line_30">
                <form method="get" action="{{url('/columns/'.$active['active_column_code'].'/goods')}}">
                    {{csrf_field()}}
                <p class="prod_type">高级筛选：</p>
                <div class="scree_box">
                    <ul class="prod_type_list margin_right">
                        <li><input type="checkbox" name="today" value="1"/>今日新品</li>
                        <li><input type="checkbox" name="isTmall" value="1"/>只看天猫</li>
                        <li><input type="checkbox" name="isJpseller" value="1"/>金牌卖家</li>
                        <li><input type="checkbox" name="isQjd" value="1"/>旗舰店</li>
                        <li><input type="checkbox" name="isTaoqianggou" value="1"/>淘抢购</li>
                        <li> <input type="checkbox" name="isJuhuashuan" value="1"/> 聚划算</li>
                        <li><input type="checkbox" name="isNine" value="1"/>9.9包邮</li>
                        <li> <input type="checkbox" name="isTwenty" value="1"/>20元封顶</li>
                        <li><input type="checkbox" name="isJyj" value="1"/>极有家</li>
                        <li><input type="checkbox" name="isHaitao" value="1"/>淘淘</li>
                        <li><input type="checkbox" name="isYfx" value="1"/>运费险</li>

                    </ul>
                    <div class="section">
                        <p class="section_title">
                            <span>券区间</span>
                            <input type="text" name="minCouponPrice" placeholder="￥">-<input type="text" name="maxCouponPrice" placeholder="￥">
                        </p>
                        <p class="section_title">
                            <span>价格</span>
                            <input type="text" name="minPrice" placeholder="￥">-<input type="text"  name="maxPrice" placeholder="￥">
                        </p>
                        <p class="section_title">
                            <span>佣金比例></span>
                            <input type="text"  name="minCommission" placeholder= "￥">
                        </p>
                        <p class="section_title">
                            <span>销量></span>
                            <input type="text"  name="minSellNum" placeholder="￥">
                        </p>
                        <p class="section_title">
                            <button type="button screen-btn">筛选</button>
                        </p>

                    </div>
                </div>
                </form>
            </div>
            <div class="clear"></div>



            <!--商品列表-->
            <div class="pro_list">
                <div class="tab_nav">
                    <a href="{{url('/columns/'.$active['active_column_code'].'/goods')}}">
                        <span class=" @if($active['active_sort']=='') tab_nav_active @endif">综合</span>
                    </a>
                    <a href="{{url('/columns/'.$active['active_column_code'].'/goods').'?sort=2'}}">
                        <span class=" @if($active['active_sort']==2) tab_nav_active @endif">最新</span>
                    </a>
                    <a href="{{url('/columns/'.$active['active_column_code'].'/goods').'?sort=3'}}">
                        <span class=" @if($active['active_sort']==3) tab_nav_active @endif">销量</span>
                    </a>
                    <a href="{{url('/columns/'.$active['active_column_code'].'/goods').'?sort=1'}}">
                        <span class=" @if($active['active_sort']==1) tab_nav_active @endif">人气</span>
                    </a>
                    <a href="{{url('/columns/'.$active['active_column_code'].'/goods').'?sort=-4'}}">
                        <span class=" @if($active['active_sort']==4) tab_nav_active @endif">价格</span>
                    </a>
                </div>
                @foreach($list as $k => $v)

                    <div class="single">
                        <a href="{{url('/goods/'. $v['id']).'?columnCode='.$active['active_column_code']}}"
                           target="_blank">
                        <img src="{{ $v['pic'] }}" alt="..." class="img_size">
                        </a>
                        <div class="price_introduce">
                            <p class="title">
                                <a href="{{url('/goods/'. $v['id']).'?columnCode='.$active['active_column_code']}}"
                                   target="_blank">
                                {{str_limit($v['short_title'], $limit = 24, $end = '...')}}
                                </a>
                            </p>

                            <p class="discount"><span class="coupun">券</span> {{ $v['coupon_price']}}元</p>

                            <p class="mouth_num">月销：<span>{{ $v['sell_num'] }}</span></p>

                            <p class="coupon_back">
                                <span class="small_word small_color">券后:</span><span class="small_word">￥</span><span>{{ $v['price'] }}</span>
                            </p>

                            <p class="commission">
                                <span class="small_word small_color">佣金:</span><span class="small_word">￥</span><span>{{ $v['commission_finally'] }}</span>
                            </p>
                            <!--商品所属图标-->
                            <p class="log_pro">
                                @if ($v['is_tmall'] !== 0)
                                <img src="/web/images/tmail.png" alt="天猫"/>
                                @else
                                <img src="/web/images/taobao.png" alt="淘宝"/>
                                @endif
                            </p>
                        </div>
                    </div>

                @endforeach

            </div>
        </div>
    </seation>
    <div class="clear"></div>
    <!--页脚-->
    <footer class="container-fluid pyt_footer_box">
        <div class="container pyt_center_footer">
            <ul class="pyt_footer">
                <li>公司官网</li>
                <li>公司官网2</li>
                <li>合作伙伴</li>
                <li>合作伙伴2</li>
            </ul>
            <div class="clear"></div>
            <p class="pyt_remark">2017-2017 www.tkhd.com朋友推--蜀CP备170234号-1 成都推客互动</p>
        </div>

    </footer>
</div>
</body>
<script src="/web/lib/jquery/dist/jquery.js"></script>
<scrpit src="/web/lib/bootstrap/dist/js/bootstrap.min.js"></scrpit>
<script>
    <!-- 头部登录下拉菜单-->
    $(".dropdown-toggle").on("click", function () {
        $(".dropdown-menu").slideToggle()
    });
    //提交表单事件


</script>
</html>