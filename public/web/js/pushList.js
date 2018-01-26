$(function(){

    lazyload.init();
    var next_page = 1;
    var limit = 20;
    var flag = false;

//页面拉到底时自动加载更多
    $(window).scroll(function (event) {
        // 当前滚动条位置
        var wScrollY = window.scrollY;
        // 设备窗口的高度
        var wInnerH = window.innerHeight;
        // 滚动条总高度
        var bScrollH = document.body.scrollHeight;
        if (wScrollY + wInnerH >= bScrollH) {
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
                            var val_url = goods_url_head + '/' + $val.id + goods_url_ext;
                            var pic = $val.pic;

                            var short_title = $val.short_title;

                            var coupon_price = $val.coupon_price;
                            var sell_num = $val.sell_num;
                            var price = $val.price;
                            var commission_finally = $val.commission_finally;
                            var is_tmall = $val.is_tmall !== 0 ? '/web/images/tmail.png' : '/web/images/taobao.png';
                            html += "<div class='single'> <a href='" + val_url + "'target='_blank'> " +
                                "<img src='../../images/web/mrtp.jpg' data-img='" + pic + "' alt='" + short_title + "' title='" + short_title + "' class='img_size lazy'> </a> " +
                                "<div class='price_introduce'> <p class='title'><a href='" + val_url + "'target='_blank' class='click_open'>" + short_title + "</a> </p>" +
                                "<p class='discount'><span class='coupun'>券</span>" + " " + coupon_price + "元</p> <p class='mouth_num'>月销：<span>" + sell_num + "</span></p>" +
                                "<p class='coupon_back'><span class='small_word small_color'>券后:</span><span class='small_word'>￥</span><span>" + price + "</span></p>" +
                                " <p class='commission'><span class='small_word small_color'>佣金:</span><spanclass='small_word'>￥</span>" +
                                "<span>" + commission_finally + "</span></p> <p class='log_pro'><img src='" + is_tmall + "' alt='天猫'/></p></div></div>"
                        });
                        $(html).appendTo('.goods-list');
                    } else {
                        flag = true;
                        layer.msg('加载完了,以后我们努力给你更多!');
                    }

                }
            });
        }
    });





});


