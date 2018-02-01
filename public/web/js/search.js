$(function(){

    lazyload.init();
    var next_page = 1;
    var limit = 20;
    var flag = false;


    //页面拉到底时自动加载更多
    $(window).scroll(function(){
        var scrollTop = $(this).scrollTop();
        var scrollHeight = $(document).height();
        var windowHeight = $(this).height();
        if(scrollHeight-scrollTop-windowHeight <=600){
            //请求
            next_page += 1
            if (flag) {
                return false;
            }
            $.get({
                type: "GET",
                url: getListUrl,
                data: {page: next_page, limit: limit},
                dataType: "json",
                success: function (data) {
                    if (data.data.length > 0) {
                        var html = '';
                        $.each(data.data, function ($key, $val) {
                            var val_url = goods_url_head + '/' + $val.id;
                            var pic = $val.pic;

                            var short_title = $val.short_title;
                            function removeAllSpace(short_title) {
                                return short_title.replace(/\s+/g, "");
                            }

                            var coupon_price = $val.coupon_price;
                            var sell_num = $val.sell_num;
                            var price = $val.price;
                            var commission_finally = $val.commission_finally;
                            var is_tmall = $val.is_tmall !== 0 ? '/web/images/tmail.png' : '/web/images/taobao.png';
                            html += "<div class='single'> <a href='" + val_url + "'target='_blank'> " +
                                "<img src='/web/images/mrtp.jpg' data-img='"+pic+".jpg"+"' title='"+short_title+"' class='img_size lazy'/> </a> " +
                                "<div class='price_introduce'> <p class='title'><a href='" + val_url + "'target='_blank' class='click_open'>" + short_title + "</a> </p>" +
                                "<p class='discount'><span class='coupun'>券</span>"+"<span class='prc_pyt'>"+coupon_price+"元</span></p> <p class='mouth_num'>月销：<span>" + sell_num + "</span></p>" +
                                "<p class='coupon_back'><span class='small_word small_color'>券后</span><span class='small_word'>￥</span><span>" + price + "</span></p>" +
                                " <p class='commission'><span class='small_word small_color'>佣金</span><spanclass='small_word'>￥</span>" +
                                "<span>" + commission_finally + "</span></p> <p class='log_pro'><img src='" + is_tmall + "' alt='天猫'/></p></div></div>"
                        });
                        $(html).appendTo('.goods-list');
                        $("img").on("error", function () { $(this).attr("src", "/web/images/mrtp.jpg"); });
                    } else if(data.data.length <0){
                        flag = true;
                        layer.msg('加载完了,以后我们努力给你更多!');
                    }
                }
            });
        }
    });

    //图片解析出错
    $("img").on("error", function () {
        $(this).attr("src", "/web/images/mrtp.jpg");
    });


    var radioclick=1;
    $(".team2").on('click',function(){
        var team2=document.getElementsByClassName('team2');
        if ($(this).prop('checked')) {
            if (radioclick % 2 == 0) {
                $(this).prop("checked", false);
            }
            radioclick++;
        }else{
            $(this).prop("checked", true);
            radioclick++;
        }

    })
    var radioclick1=1;
    $(".team3").on('click',function(){
        var team2=document.getElementsByClassName('team2');
        if ($(this).prop('checked')) {
            if (radioclick1 % 2 == 0) {
                $(this).prop("checked", false);
            }
            radioclick1++;
        }else{
            $(this).prop("checked", true);
            radioclick1++;
        }

    })
    var radioclick2=1;
    $(".team4").on('click',function(){
        var team2=document.getElementsByClassName('team2');
        if ($(this).prop('checked')) {
            if (radioclick2 % 2 == 0) {
                $(this).prop("checked", false);
            }
            radioclick2++;
        }else{
            $(this).prop("checked", true);
            radioclick2++;
        }

    })
    var radioclick3=1;
    $(".team5").on('click',function(){
        var team2=document.getElementsByClassName('team2');
        if ($(this).prop('checked')) {
            if (radioclick3 % 2 == 0) {
                $(this).prop("checked", false);
            }
            radioclick3++;
        }else{
            $(this).prop("checked", true);
            radioclick3++;
        }

    })



    $(".common").on("click",function(){
console.log(11111111111111111111)
        var kerword=document.getElementById('search_value').value;
        //    获取选择栏目
        var checked=document.getElementsByClassName('inputs');
        var newArr = '';
        //遍历选中框
        for (var i = 0; i < checked.length; i++) {
            if ($(checked[i]).prop('checked')) {
                var name=checked[i].name;
                var value=checked[i].value;
            }
        }


    })

});