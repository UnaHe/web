<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>商品详情</title>
    <!--设置视口-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-sclable=0">
    <meta name="csrf-token" content="{{csrf_token()}}"/>
    <!-- 设置主题样式-->
    <link rel="stylesheet" href="/web/lib/bootstrap/dist/css/bootstrap.min.css"/>
    <!-- 引入字体样式-->
    <link rel="stylesheet" href="/web/lib/bootstrap/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/web/css/reset.css"/>
    <link rel="stylesheet" href="/web/css/com.css"/>
    <link rel="stylesheet" href="/web/css/choiceness.css"/>
    <link rel="stylesheet" href="/web/css/detail.css"/>


    {{--<link rel="stylesheet" href="/web/lib/layer/dist/mobile/need/layer.css">--}}
    {{--<link rel="stylesheet" href="/web/test/pid.css">--}}
    {{--<link rel="stylesheet" href="/web/test/test.css">--}}
</head>
<body>
<!--头部-->
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
                        <img src="{{$good['pic']}}" alt="{{$good['short_title']}}" title="{{$good['short_title']}}"/>
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

                                <div class="chat" id="wx-copy-main">
                                    <div class="wx_pic_box">
                                        <img src="{{$good['pic']}}" alt="商品图片"/>

                                    </div>
                                    <div class="chat_right">
                                        <img src="/web/images/WX.png" alt="微信">
                                    </div>
                                    <div class="chat_left chat_wx_right">
                                        <p>{{$good['short_title']}}</p>

                                        <p> 领券下单链接 <span class="share_wx_url">
                                                【请转换QQ二合一】
                                            </span></p>

                                        <p>{{$good['des']}}</p>

                                    </div>
                                    <div class="chat_right">
                                        <div class="chat_right chart_right_wx">
                                            <img src="/web/images/WX.png" alt="微信">
                                        </div>
                                    </div>
                                    <p class="wx_creat transfer_wx_link">一键生成</p>

                                    <p class="wx_creat long_pic  weixin-transfer-long-pic " id="transfer-long-pic"
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
                    <span class="look_more">查看更多</span>
                </div>

                @foreach($list as $k => $v)
                    <div class="single">
                        <img src="{{ $v['pic'] }}" alt="..." class="img_size">

                        <div class="price_introduce">
                            <p class="title"> {{str_limit($v['short_title'], $limit = 30, $end = '...')}}</p>

                            <p class="discount margin_top148"><span class="coupun">券</span> {{ $v['coupon_price']}}元</p>

                            <p class="mouth_num">月销：<span>{{ $v['sell_num'] }}</span></p>

                            <p class="coupon_back">
                                <span class="small_word small_color">券后:</span><span
                                        class="small_word">￥</span><span>{{ $v['price'] }}</span>
                            </p>

                            <p class="commission">
                                <span class="small_word small_color">佣金:</span><span
                                        class="small_word">￥</span><span>{{ $v['commission_finally'] }}</span>
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

                <p class="title_zw">{{str_limit($v['short_title'], $limit = 30, $end = '...')}} </p>

                <p class="discount"><span class="coupun">券</span> {{$good['coupon_price']}}元</p>

                <p class="area_all_price">
                    <span>总价￥{{$good['price_full']}}</span>
                    <span>券后<span class="big_pic">￥{{$good['price']}}</span></span>
                </p>
            </div>

            <div id="area-right">
                <img src="/web/images/1.jpg" alt="">

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

            <p class="pic_save" id="pic_save">
                <a href="javascript:;" rel="external nofollow" class="btn" id="download">图片另存为</a>
            </p>
        </div>
    </div>
</div>
<div>
    <img src="" id="can_img">
</div>
</body>
<script src="/web/lib/jquery/dist/jquery.js"></script>
<script src="/js/layer/layer.js"></script>
<scrpit src="/web/lib/bootstrap/dist/js/bootstrap.min.js"></scrpit>
<script src="/web/js/com.js"></script>
<script src="https://cdn.bootcss.com/html2canvas/0.4.1/html2canvas.js"></script>

<script type="text/javascript" src="/js/web/clipboard.js"></script>


<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //生成长图,测试中
    $("#transfer-long-pic").click(function () {
        var mtk = document.getElementById('create-pic-tpl-box');
        mtk.style.display = 'block'
        html2canvas($("#area-left"), {
            onrendered: function (canvas) {
                //把截取到的图片替换到a标签的路径下载
                $("#download").attr('href', canvas.toDataURL());

                //下载下来的图片名字
                $("#download").attr('download', 'share.jpg');
//                $('#can_img').attr('src', canvas.toDataURL())
                document.getElementById('area-left').appendChild(canvas);
            },
            backgroundColor: '#FFF',
//可以带上宽高截取你所需要的部分内容
//     ,
//     width: 300,
//     height: 300
        });
    });


    /**
     * 设置主图
     */
    $('.images li img').click(function () {
        var src = $(this).attr('src');
        $('.sell-tpl-content-img').attr('src', src);
        $('#img-show').attr('src', src);
    })


    $('.auth-login').click(function () {
        e = layer.open({
            type: 2,
            title: '授权并登陆',
            shadeClose: true,
            shade: 0.8,
            area: ['760px', '550px'],
            content: "{{url('auth')}}", //iframe的url
        });
    });


    /**
     * 只能复制到文字,外网的图片和本地的图片可以复制,$good['pic']的图片不能复制
     * @type {number}
     */
    var ClipboardSupport = 0;
    if (typeof Clipboard != "undefined") {
        ClipboardSupport = 1;
    } else {
        ClipboardSupport = 0;
    }
    transfer_link_url = "{{url('transferLinkWeb')}}";
    var share_qq_url;
    var share_wx_url;
    var share_error = '正在加载中!';
    $(function () {
        $.ajax({
            type: "POST",
            url: transfer_link_url,
            data: $('.qq_form').serialize(),
            dataType: "json",
            success: function (data) {
                if (data.code == 200) {
                    var s_url = data.data.s_url;
                    share_qq_url = "<a href='" + s_url + "' target='_blank'> " + s_url + "</a>";
                    var wechat_url = data.data.wechat_url;
                    share_wx_url = "<a href='" + wechat_url + "' target='_blank'> " + wechat_url + "</a>";
                    share_error = '';
                } else {
                    share_error = data.msg;
                }
            }
        });

    })


    $('.transfer_link').click(function (e) {
        if (share_error != '') {
            layer.msg(share_error);
            return false;
        }
        $('.share_qq_url').html(share_qq_url);
        var copy = document.getElementById('qq-copy-main');
        copyFunction(copy, '.transfer_link', "QQ文案复制成功", e);

    });


    $('.transfer_wx_link').click(function (e) {
        if (share_error != '') {
            layer.msg(share_error);
            return false;
        }
        $('.share_wx_url').html(share_wx_url);
        var copy = document.getElementById('wx-copy-main');
        copyFunction(copy, '.transfer_wx_link', "微信文案复制成功", e);

    });


    //设置一键复制
    var copyFunction = function (copyMain, copyBtn, copyMsg, e) {
        if (ClipboardSupport == 0) {
            alert('浏览器版本过低，请升级或更换浏览器后重新复制！');
        } else {
            var clipboard = new Clipboard(copyBtn, {
                target: function () {
                    return copyMain;
                }
            });

            clipboard.on('success', function (e) {
                layer.msg(copyMsg);
                e.clearSelection();
            });

            clipboard.on('error', function (e) {
                layer.msg(copyMsg);
                e.clearSelection();
            });
        }
    }


    //    复制图片
    $("#copy_btn").on("click", function () {
        var mtk = document.getElementById('create-pic-tpl-box');
        mtk.style.display = 'none'
    })

</script>
</html>