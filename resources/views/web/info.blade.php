@extends('web.layouts.com')

@section('title')
    商品详情
@stop

@section('css')

    <link rel="stylesheet" href="/web/css/reset.css"/>
    <link rel="stylesheet" href="/web/css/com.css"/>
    <link rel="stylesheet" href="/web/css/choiceness.css"/>
    <link rel="stylesheet" href="/web/css/detail.css"/>
@stop


@section('main')
    <div class="container-fluid big_big_box">
        @include('web.layouts.header')

                <!--搜索导航栏-->
        @include('web.layouts.search')

                <!--导航-->
        @include('web.layouts.navigation')

                <!--主题部分-->
        <seation class="pyt-seation container-fluid">
            <div class="row  container">
                <!-- 详情内容-->
                <div id="detail">
                    <div class="detail_left">
                        <a href="{{$good['goods_url']}}">
                            <img src="{{$good['pic']}}" alt="{{$good['short_title']}}"
                                 title="{{$good['short_title']}}"/>
                        </a>

                        <div>
                            <div class="detail_small_pic">
                                <img src="{{$good['pic']}}" alt="">
                                @foreach($good['caijiPics'] as $v)
                                    <img src="{{$v->pic}}" alt="">
                                @endforeach
                            </div>
                        </div>

                    </div>
                    <!--右边详情-->
                    <div class="detail_right">
                        <p class="short_title">
                            <a href="{{$good['goods_url']}}" class="click_open">
                                {{$good['short_title']}}
                            </a>
                        </p>

                        <p class="long_title">{{$good['des']}}</p>

                        <p class="price_color">
                            <span class="price_color_qh">券后</span><span class="price_num">￥{{$good['price']}}</span>
                            <span class="price_color_qh margin_left">佣金</span><span
                                    class="price_num">￥{{$good['commission_finally']}}</span>
                            <sapn class="price_color_qh">月销量{{$good['sell_num']}}</sapn>
                        </p>

                        <!--截图末班框-->
                        <div class="template_box">
                            <!--模板头部-->
                            <div class="template_header">
                                <p class="template_header_left">营销模板</p>
                                @if($taobao_user_nick)
                                    <p class="template_header_right"><span>{{$taobao_user_nick}}</span></p>
                                @else
                                    <p class="template_header_right">请<span><a href="javascript:;" class="auth-login"
                                                                               target="_blank">登录</a></span>授权</p>
                                @endif
                            </div>
                            <div class="clear"></div>
                            <!--模板内容-->
                            <div class="template_banner">
                                <!--QQ模板-->
                                <div class="template_QQ">
                                    <p class="QQ_title">QQ文案</p>

                                    <div class="chat">
                                        <div class="chat_left" id="qq-copy-main">
                                            <img src="{{$good['pic']}}" alt="商品图片"/>
                                            {{--<img src="/web/images/1.jpg" alt="商品图片"/>--}}
                                            {{--<img src="http://imgproxy.ffquan.cn/imgextra/i4/884909271/*t*b2cif4m*dn*i8*k*jj*sszb*x*xb4*k*f*xa_!!884909271.jpg" alt="商品图片"/>--}}
                                            <p>{{$good['short_title']}}</p>

                                            <p> 领券下单链接 <span class="share_qq_url">【请转换QQ二合一】</span></p>

                                            <p>{{$good['des']}}</p>


                                            {{--<p>甜美粉色宽松，加绒内衬，下摆抽绳字母装饰，袋鼠兜，</p>--}}

                                            {{--<p>本群专享优惠！已抢104件！</p>--}}
                                        </div>
                                        <div class="chat_right">
                                            <img src="/web/images/QQ.png" alt="QQ">
                                        </div>
                                        <form class="qq_form">
                                            <input type="hidden" name="taobaoId" value="{{$good['goodsid']}}"/>
                                            <input type="hidden" name="couponId" value="{{$good['coupon_id']}}"/>
                                            <input type="hidden" name="title" value="{{$good['title']}}"/>
                                            <input type="hidden" name="description" value="{{$good['des']}}"/>
                                            <input type="hidden" name="pic" value="{{$good['pic']}}"/>
                                            <input type="hidden" name="priceFull" value="{{$good['price_full']}}"/>
                                            <input type="hidden" name="couponPrice" value="{{$good['coupon_price']}}"/>
                                            <input type="hidden" name="sell_num" value="{{$good['sell_num']}}"/>
                                        </form>
                                        <div class="creat_pic transfer_link">一键生成</div>
                                    </div>
                                </div>
                                <!--微信模板-->
                                <div class="template_QQ template_wx">
                                    <p class="QQ_title ">微信文案</p>

                                    <div class="chat">
                                        <div class='screen_short' id="wx-copy-main">
                                            <div class="wx_pic_box">
                                                <img src="{{$good['pic']}}" alt="商品图片"/>
                                            </div>
                                            <div class="chat_left chat_wx_right">
                                                <p>{{$good['short_title']}}</p>

                                                <p> 领券下单链接 <span class="share_wx_url">
                                                【请转换QQ二合一】
                                            </span></p>

                                                <p>{{$good['des']}}</p>
                                            </div>
                                        </div>
                                        <div class="chat_right">
                                            <div class="chat_right chart_right_wx">
                                                <img src="/web/images/WX.png" alt="微信">
                                            </div>

                                            <div class="chat_right chart_right_wx_down">
                                                <img src="/web/images/WX.png" alt="微信">
                                            </div>
                                        </div>
                                        <p class="wx_creat transfer_wx_link">一键生成</p>
                                       <p class=" long_pic  weixin-transfer-long-pic " id="transfer-long-pic"
                                            data-target="#create-pic-tpl-box">生成长图</p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--商品列表-->
                <div class="pro_list">
                    <div class="tab_nav">
                        <span>推荐商品</span>
                    <span class="look_more"><a href="{{url('/columns/'.'today_tui'.'/goods')}}"
                                               class="click_open">查看更多</a></span>
                    </div>

                    @foreach($list as $k => $v)
                        <div class="single">
                        <a href="{{url('/goods/'. $v['id']).'?columnCode='.$active['active_column_code']}}"
                       target="_blank" class="click_open">
                            <img src='/web/images/mrtp.jpg' data-img="{{ $v['pic'] }}.jpg" alt="..." class="img_size lazy">

                            <div class="price_introduce">
                                <p class="title">
                                        {{$v['short_title']}}
                                   </p>

                                <p class="discount margin_top148"><span class="coupun">券</span> <span class='prc_pyt'>{{ $v['coupon_price']}}元</span>
                                </p>

                                <p class="mouth_num">月销：<span>{{ $v['sell_num'] }}</span></p>

                                <p class="coupon_back">
                                    <span class="small_word small_color">券后</span><span
                                            class="small_word">￥</span><span>{{ $v['price'] }}</span>
                                </p>

                                <p class="commission">
                                    <span class="small_word small_color">佣金</span><span
                                            class="small_word">￥</span><span>{{$v['commission_finally']}}</span>
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
                            </a>
                        </div>
                    @endforeach


                </div>
            </div>
        </seation>
        <div class="clear"></div>
        <!--页脚-->
        @include('web.layouts.footer')

    </div>
    <!--模态框-->
    <div id="create-pic-tpl-box">
        <div id="create-pic-view-area" class="fl" data-ready="fall">
            <div id="area-left">
                <div class="title">
                    @if ($good['is_tmall'] !== 0)
                        <img src="/web/images/tmail.png" alt="天猫"/>
                    @else
                        <img src="/web/images/taobao.png" alt="淘宝"/>
                    @endif
                    <span>{{str_limit($v['seller_name'], $limit = 40, $end = '...')}}</span>
                    <p class="title_zw">{{str_limit($v['short_title'], $limit = 24, $end = '...')}}</p>
                      <p class="discount margin_top148 discounts">
                      <span class="coupun">券</span>
                      <span class='prc_pyt'>{{ $v['coupon_price']}}元</span>
                      </p>
                    <p class="area_all_price">
                        <span>总价￥{{$good['price_full']}}</span>
                        <span>券后<span class="big_pic">￥{{$good['price']}}</span></span>
                    </p>
                </div>
                <div id="area-right">
                   <div id="code"></div>
                    <p>长按识别二维码</p>
                </div>
                <div class="reco">
                    <p>小编推荐：甜美粉色宽容，加绒软妹卫衣，女2017秋冬，新款连帽保暖，字母学生上衣，加绒内衬，下摆抽线字母装饰，袋鼠兜</p>
                   <img src="{{$good['pic']}}" alt="">

                </div>
            </div>
            <!--右边布局-->
            <div id="area_right_box_btn">
                <p class="pic_sec">
                    <img src="/web/images/S.png" alt="">
                    <span>图片已生成</span>

                </p>

                <p class="copy_btn" id="copy_btn">复制图片</p>
                <a href="javascript:;" rel="external nofollow" class="btn" id="download">
                <p class="pic_save" id="pic_save">图片另存为</p>
                </a>
            </div>
        </div>
    </div>

@stop


@section('js')
    <script src="https://cdn.bootcss.com/html2canvas/0.4.1/html2canvas.js"></script>
    <script src="/js/imgLazy.js"></script>
    <script type="text/javascript" src="/js/web/clipboard.js"></script>
     <script src="/web/js/jquery.qrcode.min.js"></script>
    <script src="/web/js/info.js"></script>
    <script type="text/javascript">
        var transfer_link_url = "{{url('transferLinkWeb')}}";
        var redirectUrl = "{{ url('taobaoCode')}}";
        var appkey = "{{config("taobao.appkey")}}";
        var authUrl = "https://oauth.taobao.com/authorize?response_type=code&client_id=" + appkey + "&redirect_uri=" + redirectUrl + "&state=1212&view=web";
  $("#code").qrcode({
        render:"table",
        width:80,
        height:80,
        typeNumber  : -1,
        text:"$WRFjn$"
    });
        /**
         * 设置主图
         */
        $('.images li img').click(function () {
            var src = $(this).attr('src');
            $('.sell-tpl-content-img').attr('src', src);
            $('#img-show').attr('src', src);
        })
    </script>
@stop