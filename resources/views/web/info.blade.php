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
                    <img src="{{$good['pic']}}" alt="商品图片"/>
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
                    <p class="short_title">{{$good['short_title']}}</p>
                    <p class="long_title">{{$good['des']}}</p>
                    <p class="price_color">
                        <span class="price_color_qh">券后</span><span class="price_num">￥{{$good['price']}}</span>
                        <span class="price_color_qh margin_left">佣金</span><span class="price_num">￥{{$good['commission_finally']}}</span>
                        <sapn class="price_color_qh">月销量{{$good['sell_num']}}</sapn>
                    </p>

                    <!--截图末班框-->
                    <div class="template_box">
                        <!--模板头部-->
                        <div class="template_header">
                            <p class="template_header_left">营销模板</p>
                            <p class="template_header_right">请<span><a href="javascript:;" class="auth-login" target="_blank">登录</a></span>授权</p>
                        </div>
                        <div class="clear"></div>
                        <!--模板内容-->
                        <div class="template_banner">
                            <!--QQ模板-->
                            <div class="template_QQ">
                                <p class="QQ_title">QQ文案</p>
                                <div class="chat">
                                    <div class="chat_left">
                                        <img src="{{$good['pic']}}" alt="商品图片"/>
                                        <p>秋冬新款连帽保暖字母学生上衣潮 券后【178元】包邮秒杀</p>
                                        <p> 领券下单链接 <span class="share_url">【请转换QQ二合一】</span>  甜美粉色宽松，加绒内衬，下摆抽</p>
                                        <p>甜美粉色宽松，加绒内衬，下摆抽绳字母装饰，袋鼠兜，</p>
                                        <p>本群专享优惠！已抢104件！</p>
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
                                    <div class="creat_pic transfer_link" >一键生成</div>
                                </div>
                            </div>
                            <!--微信模板-->
                            <div class="template_QQ template_wx">
                                <p class="QQ_title ">微信文案</p>
                                <div class="chat">
                                    <div class="wx_pic_box">
                                        <img src="{{$good['pic']}}" alt="商品图片"/>

                                    </div>
                                    <div class="chat_right">
                                        <img src="/web/images/WX.png" alt="微信">
                                    </div>
                                    <div class="chat_left chat_wx_right">
                                        <p>秋冬新款连帽保暖字母学生上衣潮 券后【178元】包邮秒杀</p>
                                        <p> 领券下单链接 <span>
                                                【请转换QQ二合一】
                                            </span>  甜美粉色宽松，加绒内衬，下摆抽</p>
                                        <p>甜美粉色宽松，加绒内衬，下摆抽绳字母装饰，袋鼠兜，</p>
                                        <p>本群专享优惠！已抢104件！</p>
                                    </div>
                                    <div class="chat_right">
                                        <div class="chat_right chart_right_wx">
                                            <img src="/web/images/WX.png" alt="微信">
                                        </div>
                                    </div>
                                    <p class="wx_creat">一键生成</p>
                                    <p class="wx_creat long_pic" id="transfer-long-pic" data-target="#create-pic-tpl-box">生成长图</p>
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
                        <p class="discount margin_top148"> <span class="coupun">券</span> {{ $v['coupon_price']}}元</p>
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
    @include('web.layouts.footer')

</div>
<!--模态框-->
<!--纯图模板-->
<div id="create-pic-tpl-box">
    <div id="create-pic-view-area" class="fl" data-ready="fall">
        <div id="area-left">
            <div class="title">
                <img src="" alt="天猫">
                <span>Abercrombie＆Fitch</span>
                <p class="title_zw">男装 贴花图案 T 恤 206049 </p>
                <p class="discount"> <span class="coupun">券</span> 20元</p>
                <p class="area_all_price">
                    <span>总价￥399</span>
                    <span>券后<span class="big_pic">￥379</span></span>
                </p>
            </div>
            <div id="area-right">
                <img src="/web/images/1.jpg" alt="">
                <p>长按识别二维码</p>
            </div>
            <div class="reco">
                <p>小编推荐：甜美粉色宽容，加绒软妹卫衣，女2017秋冬，新款连帽保暖，字母学生上衣，加绒内衬，下摆抽线字母装饰，袋鼠兜</p>
                <img src="/web/images/1.jpg" alt="">
            </div>
        </div>
        <!--右边布局-->
        <div id="area_right_box_btn">
            <p class="pic_sec">
                <img src="/web/images/S.png" alt="">
                <span>图片已生成</span>
            </p>
            <p class="copy_btn" id="copy_btn">复制图片</p>
            <p class="pic_save" id="pic_save">图片另存为</p>
        </div>
    </div>
</div>

</body>
<script src="/web/lib/jquery/dist/jquery.js"></script>
<script src="/js/layer/layer.js"></script>
<scrpit src="/web/lib/bootstrap/dist/js/bootstrap.min.js"></scrpit>
<script src="/web/js/com.js"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
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


    $('.transfer_link').click(function(){
        transfer_link_url="{{url('transferLink')}}";
        $.ajax({
            type: "POST",
            url: transfer_link_url,
            data: $('.qq_form').serialize(),
            dataType: "json",
            success: function (data) {
                if (data.code==200)  {
                    var html="<a href='https://s.click.taobao.com/y05scUw' target='_blank'> https://s.click.taobao.com/y05scUw</a>";
                    $('.share_url').html(html);
                }else{
                    layer.alert(data.msg, {
                        skin: 'layui-layer-lan' //样式类名
                        ,closeBtn: 0
                    });
                }
            }
        });
    });



    //弹出模态框
    $("#transfer-long-pic").on("click",function(){
        var mtk=document.getElementById('create-pic-tpl-box');
        mtk.style.display='block'
    })
    //    复制图片
    $("#copy_btn").on("click",function(){
        var mtk=document.getElementById('create-pic-tpl-box');
        mtk.style.display='none'
    })
    //    图片另存为
    $("#pic_save").on("click",function(){
        var mtk=document.getElementById('create-pic-tpl-box');
        mtk.style.display='none'
    })
</script>
</html>