$(function(){

    lazyload.init();
    var next_page =window.location.search.split('=')[1];
    if(next_page===undefined){
        next_page=1;
    }
    var limit = 20;
    var flag = false;

    //页面拉到底时自动加载更多
    $(window).scroll(function(){
        next_page= Number(next_page);
        var scrollTop = $(this).scrollTop();
        var scrollHeight = $(document).height();
        var windowHeight = $(this).height();
        var href=window.location.href;
        if(scrollHeight-scrollTop-windowHeight <=200){
            //请求
            next_page += 1
            if (flag) {
                return false;
            }
            $.get({
                type: "GET",
                url: href,
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

                            var coupon_price = $val.coupon_price;
                            var sell_num = $val.sell_num;
                            var price = $val.price;
                            var commission_finally = $val.commission_finally;
                            var is_tmall = $val.is_tmall !== 0 ? '/web/images/tmail.png' : '/web/images/taobao.png';
                            html += "<div class='single'> <a href='" + val_url + "'target='_blank'  class='click_open'> " +
                                "<img src='/web/images/mrtp.jpg' data-img='"+pic+".jpg"+"' title='"+short_title+"' class='img_size lazy'/> " +
                                "<div class='price_introduce'> <p class='title'>" + short_title + "</p>" +
                                "<p class='discount'><span class='coupun'>券</span>"+"<span class='prc_pyt'>"+coupon_price+"元</span></p> <p class='mouth_num'>月销：<span>" + sell_num + "</span></p>" +
                                "<p class='coupon_back'><span class='small_word small_color'>券后</span><span class='small_word'>￥</span><span>" + price + "</span></p>" +
                                " <p class='commission'><span class='small_word small_color'>佣金</span><spanclass='small_word'>￥</span>" +
                                "<span>" + commission_finally + "</span></p> <p class='log_pro'><img src='" + is_tmall + "' alt='天猫'/></p></div></a></div>"
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


    // //方法1
    // $('input[type=checkbox]').click(function(){
    //     console.log("1111111111111")
    //     $(this).attr('checked','checked').siblings().removeAttr('checked');
    // });
        var radioclick=1;
    $(".team2").on('click',function(){
        var team2=document.getElementsByClassName('team2');
        for(var i=0;i<team2.length;i++){
            team2[i].checked = false;
        }
        this.checked = true;
        if ($(this).prop('checked')) {
            if (radioclick % 2 == 0) {
                $(this).prop("checked", false);
            }
            radioclick++;
        }
    })
    var radioclick1=1;
    $(".team3").on('click',function(){
        var team3=document.getElementsByClassName('team3');
        for(var i=0;i<team3.length;i++){
            team3[i].checked = false;
        }
        this.checked = true;
        if ($(this).prop('checked')) {
            if (radioclick1 % 2 == 0) {
                $(this).prop("checked", false);
                console.log(this.value)
                this.value='0'
                console.log(this.value)
            }else{
                this.value='1'
            }
            radioclick1++;
        }
    })
    var radioclick2=1;
    $(".team4").on('click',function(){
        var team4=document.getElementsByClassName('team4');
        for(var i=0;i<team4.length;i++){
            team4[i].checked = false;
        }
        this.checked = true;
        if ($(this).prop('checked')) {
            if (radioclick2 % 2 == 0) {
                $(this).prop("checked", false);
                console.log(this.value)
                this.value='0'
                console.log(this.value)
            }else{
                console.log(this.value)
                this.value='1'
                console.log(this.value)
            }
            radioclick2++;
        }

    })
    var radioclick3=1;
    $(".team5").on('click',function(){
        var team5=document.getElementsByClassName('team5');
        for(var i=0;i<team5.length;i++){
            team5[i].checked = false;
        }
        this.checked = true;
        if ($(this).prop('checked')) {
            if (radioclick3 % 2 == 0) {
                $(this).prop("checked", false);
                console.log(this.value)
                this.value='0'
                console.log(this.value)

            }else{
                this.value='1'
            }
            radioclick3++;
        }
    })
});


//高级筛选
// $("#screen-btn").on("click",function(){
// //    获取选择栏目
//     var checked=document.getElementsByClassName('inputs');
//     var newArr = '';
//     //遍历选中框
//     for (var i = 0; i < checked.length; i++) {
//         if ($(checked[i]).prop('checked')) {
//             var name=checked[i].name;
//             var value=checked[i].value;
//
//             newArr += name+ "="+value+"&"
//         }
//     }
//
//     console.log(newArr)
// $.ajax({
//     type: "GET",
//     url:getListUrl,
//     data: newArr,
//     dataType: "JSON",
//     success:function(data){
//            console.log(data);
//         // if (data.data.length > 0) {
//         //     var html = '';
//         //     $.each(data.data, function ($key, $val) {
//         //         var val_url = goods_url_head + '/' + $val.id + goods_url_ext;
//         //         var pic = $val.pic;
//         //
//         //         var short_title = $val.short_title;
//         //         function removeAllSpace(short_title) {
//         //             return short_title.replace(/\s+/g, "");
//         //         }
//         //
//         //         var coupon_price = $val.coupon_price;
//         //         var sell_num = $val.sell_num;
//         //         var price = $val.price;
//         //         var commission_finally = $val.commission_finally;
//         //         var is_tmall = $val.is_tmall !== 0 ? '/web/images/tmail.png' : '/web/images/taobao.png';
//         //         html += "<div class='single'> <a href='" + val_url + "'target='_blank'  class='click_open'> " +
//         //             "<img src='/web/images/mrtp.jpg' data-img='"+pic+".jpg"+"' title='"+short_title+"' class='img_size lazy'/> " +
//         //             "<div class='price_introduce'> <p class='title'>" + short_title + "</p>" +
//         //             "<p class='discount'><span class='coupun'>券</span>"+"<span class='prc_pyt'>"+coupon_price+"元</span></p> <p class='mouth_num'>月销：<span>" + sell_num + "</span></p>" +
//         //             "<p class='coupon_back'><span class='small_word small_color'>券后</span><span class='small_word'>￥</span><span>" + price + "</span></p>" +
//         //             " <p class='commission'><span class='small_word small_color'>佣金</span><spanclass='small_word'>￥</span>" +
//         //             "<span>" + commission_finally + "</span></p> <p class='log_pro'><img src='" + is_tmall + "' alt='天猫'/></p></div></a></div>"
//         //     });
//         //     $(html).appendTo('.goods-list');
//         //     $("img").on("error", function () { $(this).attr("src", "/web/images/mrtp.jpg"); });
//         // } else if(data.data.length <0){
//         //     flag = true;
//         //     layer.msg('加载完了,以后我们努力给你更多!');
//         // }
//
//     }
//
// });
// })





