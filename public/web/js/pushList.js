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
                            var val_url = goods_url_head + '/' + $val.id + goods_url_ext;
                            var pic = $val.pic;

                            var short_title = $val.short_title;
                            function removeAllSpace(short_title) {
                                return short_title.replace(/\s+/g, "");
                            }
                            if (short_title.length > 13) {
                                short_title = short_title.substr(0, 13) + '...'
                            }
                            var coupon_price = $val.coupon_price;
                            var sell_num = $val.sell_num;
                            var price = $val.price;
                            var commission_finally = $val.commission_finally;
                            var is_tmall = $val.is_tmall !== 0 ? '/web/images/tmail.png' : '/web/images/taobao.png';
                            html += "<div class='single'> <a href='" + val_url + "'target='_blank'> " +
                                "<img src='/web/images/mrtp.jpg' data-img='"+pic+"' alt='"+short_title+"' title='"+short_title+"' class='img_size lazy'> </a> " +
                                "<div class='price_introduce'> <p class='title'><a href='" + val_url + "'target='_blank' class='click_open'>" + short_title + "</a> </p>" +
                                "<p class='discount'><span class='coupun'>券</span>"+" "+coupon_price +"元</p> <p class='mouth_num'>月销：<span>" + sell_num + "</span></p>" +
                                "<p class='coupon_back'><span class='small_word small_color'>券后:</span><span class='small_word'>￥</span><span>" + price + "</span></p>" +
                                " <p class='commission'><span class='small_word small_color'>佣金:</span><spanclass='small_word'>￥</span>" +
                                "<span>" + commission_finally + "</span></p> <p class='log_pro'><img src='" + is_tmall + "' alt='天猫'/></p></div></div>"
                        });
                        $(html).appendTo('.goods-list');
                    } else if(data.data.length <0){
                        flag = true;
                        layer.msg('加载完了,以后我们努力给你更多!');
                    }
                }
            });
        }
    });
    $('.inputs').click(function(){
        $.each($('.inputs'),function($key,$val){
            $($val).prop('checked',false);
        })
        $(this).prop('checked',true);
    });




});


