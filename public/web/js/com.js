/**
 * Created by tk on 2018/1/23.
 */
$(function () {
    //设置csrf-token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /**
     * 主要的POST提交请求
     */
    $('.sub_btn').click(function () {
        $(this).attr('disabled', true);
        $.ajax({
            type: "POST",
            url: formPost,
            data: $('form').serialize(),
            dataType: "json",
            success: function (data) {
                if (data.code == 200) {
                    var msg = data.data.message == '' ? '操作成功' : data.data.message;
                    layer.msg(msg);
                    window.location.reload();
                } else {
                    var msg = data.msg.msg == '' ? '操作失败' : data.msg.msg;
                    layer.msg(msg);
                    $(this).attr('disabled', false);
                }
            }
        });
    });
    /**
     * 需要跳转的ajax请求
     */
    $('.am-btn-sm').click(function (e) {
        $(e).attr('disabled', true);
        $.ajax({
            type: "POST",
            url: formPost,
            data: $('form').serialize(),
            dataType: "json",
            success: function (data) {
                if (data.code == 200) {
                    var msg = data.data.message;
                    msg = msg ? msg : '操作成功';
                    layer.msg(msg);
                    window.location.href = url;
                } else {
                    layer.alert(data.msg.msg, {
                        skin: 'layui-layer-lan' //样式类名
                        , closeBtn: 0
                    });
                    $(e).attr('disabled', false);
                }
            }
        });
    });





    //登录授权
    $('.auth-login').click(function () {
        e = layer.open({
            type: 2,
            title: '授权并登陆',
            shadeClose: true,
            shade: 0.8,
            area: ['760px', '550px'],
            content: authUrl, //iframe的url
        });

    });


    //头部登录下拉菜单点击后样式修改
    $('.user_menu').click(function () {
        $(this).css('color', '#E1B05A')
    });


    //头部登录下拉菜单
    $(".dropdown-toggle").on("click", function () {
        $(".dropdown-menu").slideDown();
        if (!$(this).hasClass('click_down')) {
            $(this).addClass('click_down')
        } else {
            $(".dropdown-menu").slideUp();
            $(this).removeClass('click_down')
        }
    });
//兼容placeholder----------------------IE版
//     $(function () {
//         jQuery('[placeholder]').focus(function () {
//             var input = jQuery(this);
//             if (input.val() == input.attr('placeholder')) {
//                 input.val('');
//                 input.removeClass('placeholder');
//             }
//         }).blur(function () {
//             var input = jQuery(this);
//             if (input.val() == '' || input.val() == input.attr('placeholder')) {
//                 input.addClass('placeholder');
//                 input.val(input.attr('placeholder'));
//             }
//         }).blur().parents('form').submit(function () {
//             jQuery(this).find('[placeholder]').each(function () {
//                 var input = jQuery(this);
//                 if (input.val() == input.attr('placeholder')) {
//                     input.val('');
//                 }
//             })
//         });
//     })

    $(".btn-C").on('click',function(){

        $("#searchForm").submit()
//         var keyword=$("#search_value").val();
//         if(keyword!=''){
//             var sendData={};
//             console.log("11111111111111")
//             console.log(this)
// //         var sort=document.getElementsByClassName(".tab_nav_active");
//             //    获取搜索词
//             var keyword=$('#search_value').val();
//             console.log(keyword)
//             //    获取筛选条件
//             var checked=document.getElementsByClassName('inputs');
//             var isTmall,isYfx,isHaitao,isJyj,isTwenty,isNine,isJuhuashuan,isTaoqianggou,isQjd,isJpseller,today;
//             //遍历选中框
//             for (var i = 0; i < checked.length; i++) {
//                 if ($(checked[i]).prop('checked')) {
//                     var name=checked[i].name;
//                     var value=checked[i].value;
//                     if(name=='today'){
//                         today=value
//                     }else if(name=='isTmall'){
//                         isTmall=value
//                     }else if(name=='isJpseller'){
//                         isJpseller=value
//                     }else if(name=='isQjd'){
//                         isQjd=value
//                     }else if(name=='isTaoqianggou'){
//                         isTaoqianggou=value
//                     }else if(name=='isJuhuashuan'){
//                         isJuhuashuan=value
//                     }else if(name=='isNine'){
//                         isNine=value
//                     }else if(name=='isTwenty'){
//                         isTwenty=value
//                     }else if(name=='isJyj'){
//                         isJyj=value
//                     }else if(name=='isHaitao'){
//                         isHaitao=value
//                     }else if(name=='isYfx'){
//                         isYfx=value
//                     }
//                 }
//             }
//             // console.log(newArr)
//             //    获取券区间筛选条件
//             var minCouponPrice=$(".in_clock").val();
//             var maxCouponPrice=$(".in_clock0").val();
//             var minPrice=$(".in_clock1").val();
//             var maxPrice=$(".in_clock2").val();
//             var minCommission=$(".in_clock3").val();
//             var minSellNum=$(".in_clock4").val();
//             console.log( minCouponPrice,maxCouponPrice,minPrice, maxPrice,minCommission,minSellNum)
//             sendData= {
//                 minCouponPrice: minCouponPrice,
//                 maxCouponPrice: maxCouponPrice,
//                 minPrice:minPrice,
//                 maxPrice:maxPrice,
//                 minCommission:minCommission,
//                 minSellNum: minSellNum,
//                 keyword:keyword,
//                 // sort:sort,
//                 page:1,
//                 today:today,
//                 isTmall:isTmall,
//                 isJpseller:isJpseller,
//                 isQjd:isQjd,
//                 isTaoqianggou:isTaoqianggou,
//                 isJuhuashuan:isJuhuashuan,
//                 isNine: isNine,
//                 isTwenty:isTwenty,
//                 isJyj:isJyj,
//                 isHaitao: isHaitao,
//                 isYfx:isYfx
//             }
//             //    发送请求获取数据
//             $.ajax({
//                 type: "GET",
//                 url: '/goods',
//                 data:sendData,
//                 dataType: "json",
//                 success:function(data){
//                     console.log(data.data)
//                     if (data.data.length > 0) {
//                         var html = '';
//                         console.log(html)
//                         $.each(data.data, function ($key, $val) {
//                             var val_url = goods_url_head + '/' + $val.id;
//                             var pic = $val.pic;
//
//                             var short_title = $val.short_title;
//                             function removeAllSpace(short_title) {
//                                 return short_title.replace(/\s+/g, "");
//                             }
//                             var coupon_price = $val.coupon_price;
//                             var sell_num = $val.sell_num;
//                             var price = $val.price;
//                             var commission_finally = $val.commission_finally;
//                             console.log(coupon_price,sell_num)
//                             var is_tmall = $val.is_tmall !== 0 ? '/web/images/tmail.png' : '/web/images/taobao.png';
//                             html += "<div class='single'> <a href='" + val_url + "'target='_blank'> " +
//                                 "<img src='/web/images/mrtp.jpg' data-img='"+pic+".jpg"+"' title='"+short_title+"' class='img_size lazy'/> </a> " +
//                                 "<div class='price_introduce'> <p class='title'><a href='" + val_url + "'target='_blank' class='click_open'>" + short_title + "</a> </p>" +
//                                 "<p class='discount'><span class='coupun'>券</span>"+"<span class='prc_pyt'>"+coupon_price+"元</span></p> <p class='mouth_num'>月销：<span>" + sell_num + "</span></p>" +
//                                 "<p class='coupon_back'><span class='small_word small_color'>券后</span><span class='small_word'>￥</span><span>" + price + "</span></p>" +
//                                 " <p class='commission'><span class='small_word small_color'>佣金</span><spanclass='small_word'>￥</span>" +
//                                 "<span>" + commission_finally + "</span></p> <p class='log_pro'><img src='" + is_tmall + "' alt='天猫'/></p></div></div>"
//                         });
//                         document.getElementById("goods-list").innerHTML=html;
//                         $("img").on("error", function () { $(this).attr("src", "/web/images/mrtp.jpg"); });
//                     } else if(data.data.length <0){
//                         layer.closeAll('loading');
//                         layer.msg('加载完了,以后我们努力给你更多!');
//                     }
//                 }
//             })
//         }else{
//             layer.msg('请输入关键字')
//         }


    })
    /**
     *获取手机验证码
     */
    var time = 60;
    $("#clock").on("click",function(){
        var username=$("#username").val();
        if(username!=''){
            var show_user=document.getElementById('show_username');
            show_user.style.display='none'
            if (time < 60) {
                return false;
            }
            var interval = setInterval(function () {
                if (time > 0) {
                    $("#clock").text(time + '秒后获取');
                    time--;
                } else {
                    clearInterval(interval)
                    $("#clock").html("获取手机验证码");
                    time = 60;
                }
            }, 1000);

            $.ajax({
                type: "POST",
                url: getCodeUrl,
                data: {username: $("#username").val()},
                dataType: "json",
                success: function (data) {
                    if (data.code == 200) {
                        $("#codeId").val(data.data[0]);
                    } else {
                        layer.alert(data.msg.msg, {
                            skin: 'layui-layer-lan' //样式类名
                            , closeBtn: 0
                        }, function () {
                            window.location.reload()
                        });

                    }
                }
            });
        }else{
            var show_user=document.getElementById('show_username')
            show_user.style.display='block'
        }
    })
});

//判断浏览器

function IEVersion() {
    var userAgent = navigator.userAgent; //取得浏览器的userAgent字符串
    var isIE = userAgent.indexOf("compatible") > -1 && userAgent.indexOf("MSIE") > -1; //判断是否IE<11浏览器
    var isEdge = userAgent.indexOf("Edge") > -1 && !isIE; //判断是否IE的Edge浏览器
    var isIE11 = userAgent.indexOf('Trident') > -1 && userAgent.indexOf("rv:11.0") > -1;
    if (isIE) {
        var reIE = new RegExp("MSIE (\\d+\\.\\d+);");
        reIE.test(userAgent);
        var fIEVersion = parseFloat(RegExp["$1"]);
        if (fIEVersion > 9) {
          layer.msg('请升级浏览器哦！！！')
        }
    }
}
