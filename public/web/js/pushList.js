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
        var scrollTop = $(this).scrollTop();
        var scrollHeight = $(document).height();
        var windowHeight = $(this).height();
        var single_num=document.getElementsByTagName('single_num');
        if(window.location.search!=''&&single_num.length>20){
        if(scrollHeight-scrollTop-windowHeight <=30){
            //请求
            next_page += 1
            if (flag) {
                return false;
            }
            var sendData={};
            console.log("11111111111111")
            console.log(this)
//         var sort=document.getElementsByClassName(".tab_nav_active");
//
// console.log(sort)
            //获取分类
            var active_category=$(".active")[0].id;
            console.log(active_category)
            //    获取搜索词
            var keyword=$('#search_value').val();
            console.log(keyword)
            //    获取筛选条件
            var checked=document.getElementsByClassName('inputs');
            var isTmall,isYfx,isHaitao,isJyj,isTwenty,isNine,isJuhuashuan,isTaoqianggou,isQjd,isJpseller,today;
            //遍历选中框
            for (var i = 0; i < checked.length; i++) {
                if ($(checked[i]).prop('checked')) {
                    var name=checked[i].name;
                    var value=checked[i].value;
                    if(name=='today'){
                        today=value
                    }else if(name=='isTmall'){
                        isTmall=value
                    }else if(name=='isJpseller'){
                        isJpseller=value
                    }else if(name=='isQjd'){
                        isQjd=value
                    }else if(name=='isTaoqianggou'){
                        isTaoqianggou=value
                    }else if(name=='isJuhuashuan'){
                        isJuhuashuan=value
                    }else if(name=='isNine'){
                        isNine=value
                    }else if(name=='isTwenty'){
                        isTwenty=value
                    }else if(name=='isJyj'){
                        isJyj=value
                    }else if(name=='isHaitao'){
                        isHaitao=value
                    }else if(name=='isYfx'){
                        isYfx=value
                    }
                }
            }
            // console.log(newArr)
            //获取分类
            var active_category=$(".active")[0].id;
            console.log(active_category)
            //    获取券区间筛选条件
            var minCouponPrice=$(".in_clock").val();
            var maxCouponPrice=$(".in_clock0").val();
            var minPrice=$(".in_clock1").val();
            var maxPrice=$(".in_clock2").val();
            var minCommission=$(".in_clock3").val();
            var minSellNum=$(".in_clock4").val();
            console.log( minCouponPrice,maxCouponPrice,minPrice, maxPrice,minCommission,minSellNum)
            sendData= {
                minCouponPrice: minCouponPrice,
                maxCouponPrice: maxCouponPrice,
                minPrice:minPrice,
                maxPrice:maxPrice,
                minCommission:minCommission,
                minSellNum: minSellNum,
                keyword:keyword,
                // sort:sort,
                today:today,
                isTmall:isTmall,
                isJpseller:isJpseller,
                isQjd:isQjd,
                isTaoqianggou:isTaoqianggou,
                isJuhuashuan:isJuhuashuan,
                isNine: isNine,
                isTwenty:isTwenty,
                isJyj:isJyj,
                isHaitao: isHaitao,
                isYfx:isYfx,
                page: next_page,
                limit: limit,
            category:active_category
            }
            $.get({
                type: "GET",
                url: getListUrl,
                data:  sendData,
                dataType: "json",
                success: function (data) {
                    if (data.data.length > 0) {
                        console.log(data.data)
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
                    } else{
                        flag = true;

                    }
                }
            });
        }
        }else if(single_num.length>20){
            console.log(window)
            if(scrollHeight-scrollTop-windowHeight <=30){
                //请求
                next_page += 1
                if (flag) {
                    return false;
                }
                var sendData={};
                console.log("11111111111111")
                console.log(this)
                //    获取搜索词
                var keyword=$('#search_value').val();
                console.log(keyword)
                //    获取筛选条件
                var checked=document.getElementsByClassName('inputs');
                var isTmall,isYfx,isHaitao,isJyj,isTwenty,isNine,isJuhuashuan,isTaoqianggou,isQjd,isJpseller,today;
                //遍历选中框
                for (var i = 0; i < checked.length; i++) {
                    if ($(checked[i]).prop('checked')) {
                        var name=checked[i].name;
                        var value=checked[i].value;
                        if(name=='today'){
                            today=value
                        }else if(name=='isTmall'){
                            isTmall=value
                        }else if(name=='isJpseller'){
                            isJpseller=value
                        }else if(name=='isQjd'){
                            isQjd=value
                        }else if(name=='isTaoqianggou'){
                            isTaoqianggou=value
                        }else if(name=='isJuhuashuan'){
                            isJuhuashuan=value
                        }else if(name=='isNine'){
                            isNine=value
                        }else if(name=='isTwenty'){
                            isTwenty=value
                        }else if(name=='isJyj'){
                            isJyj=value
                        }else if(name=='isHaitao'){
                            isHaitao=value
                        }else if(name=='isYfx'){
                            isYfx=value
                        }
                    }
                }
                // console.log(newArr)
                //    获取券区间筛选条件
                var minCouponPrice=$(".in_clock").val();
                var maxCouponPrice=$(".in_clock0").val();
                var minPrice=$(".in_clock1").val();
                var maxPrice=$(".in_clock2").val();
                var minCommission=$(".in_clock3").val();
                var minSellNum=$(".in_clock4").val();
                console.log( minCouponPrice,maxCouponPrice,minPrice, maxPrice,minCommission,minSellNum)
                sendData= {
                    minCouponPrice: minCouponPrice,
                    maxCouponPrice: maxCouponPrice,
                    minPrice:minPrice,
                    maxPrice:maxPrice,
                    minCommission:minCommission,
                    minSellNum: minSellNum,
                    keyword:keyword,
                    // sort:sort,
                    today:today,
                    isTmall:isTmall,
                    isJpseller:isJpseller,
                    isQjd:isQjd,
                    isTaoqianggou:isTaoqianggou,
                    isJuhuashuan:isJuhuashuan,
                    isNine: isNine,
                    isTwenty:isTwenty,
                    isJyj:isJyj,
                    isHaitao: isHaitao,
                    isYfx:isYfx,
                    page: next_page,
                    limit: limit,
                    category:active_category
                }
                $.get({
                    type: "GET",
                    url: getListUrl,
                    data:  sendData,
                    dataType: "json",
                    success: function (data) {
                        if (data.data.length > 0) {
                            console.log(data.data)
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
        }
    });

    //图片解析出错
    $("img").on("error", function () {
        $(this).attr("src", "/web/images/mrtp.jpg");
    });
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

$(".common").on("click",function(){
    var sendData={};
    console.log("11111111111111")
    console.log(this)
    var nav_tab=$('.tab_nav span');
    console.log(nav_tab)
    // var sort;
    // for(var i=0;i<nav_tab.length;i++){
    //     if(nav_tab[i].className = 'tab_nav_active'){
    //         sort=this.id;
    //     }
    // }
    //获取分类
    var active_category=$(".active")[0].id;
         console.log(active_category)
    //    获取搜索词
    var keyword=$('#search_value').val();
    console.log(keyword)
    //    获取筛选条件
    var checked=document.getElementsByClassName('inputs');
    var isTmall,isYfx,isHaitao,isJyj,isTwenty,isNine,isJuhuashuan,isTaoqianggou,isQjd,isJpseller,today;
    //遍历选中框
    for (var i = 0; i < checked.length; i++) {
        if ($(checked[i]).prop('checked')) {
            var name=checked[i].name;
            var value=checked[i].value;
            if(name=='today'){
                today=value
            }else if(name=='isTmall'){
                isTmall=value
            }else if(name=='isJpseller'){
                isJpseller=value
            }else if(name=='isQjd'){
                isQjd=value
            }else if(name=='isTaoqianggou'){
                isTaoqianggou=value
            }else if(name=='isJuhuashuan'){
                isJuhuashuan=value
            }else if(name=='isNine'){
                isNine=value
            }else if(name=='isTwenty'){
                isTwenty=value
            }else if(name=='isJyj'){
                isJyj=value
            }else if(name=='isHaitao'){
                isHaitao=value
            }else if(name=='isYfx'){
                isYfx=value
            }
        }
    }
    // console.log(newArr)
    //    获取券区间筛选条件
    var minCouponPrice=$(".in_clock").val();
    var maxCouponPrice=$(".in_clock0").val();
    var minPrice=$(".in_clock1").val();
    var maxPrice=$(".in_clock2").val();
    var minCommission=$(".in_clock3").val();
    var minSellNum=$(".in_clock4").val();
    console.log( minCouponPrice,maxCouponPrice,minPrice, maxPrice,minCommission,minSellNum)
    sendData= {
        minCouponPrice: minCouponPrice,
        maxCouponPrice: maxCouponPrice,
        minPrice:minPrice,
        maxPrice:maxPrice,
        minCommission:minCommission,
        minSellNum: minSellNum,
        keyword:keyword,
        // sort:sort,
        page:1,
        today:today,
        isTmall:isTmall,
        isJpseller:isJpseller,
        isQjd:isQjd,
        isTaoqianggou:isTaoqianggou,
        isJuhuashuan:isJuhuashuan,
        isNine: isNine,
        isTwenty:isTwenty,
        isJyj:isJyj,
        isHaitao: isHaitao,
        isYfx:isYfx,
        category:active_category
    }
    //    发送请求获取数据
    $.get({
        type: "GET",
        url: '/goods',
        data:sendData,
        dataType: "json",
        success:function(data){
            console.log(data.data)
            if (data.data.length > 0) {
                var html = '';
                console.log(html)
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
                    console.log(coupon_price,sell_num)
                    var is_tmall = $val.is_tmall !== 0 ? '/web/images/tmail.png' : '/web/images/taobao.png';
                    html += "<div class='single'> <a href='" + val_url + "'target='_blank'> " +
                        "<img src='/web/images/mrtp.jpg' data-img='"+pic+".jpg"+"' title='"+short_title+"' class='img_size lazy'/> </a> " +
                        "<div class='price_introduce'> <p class='title'><a href='" + val_url + "'target='_blank' class='click_open'>" + short_title + "</a> </p>" +
                        "<p class='discount'><span class='coupun'>券</span>"+"<span class='prc_pyt'>"+coupon_price+"元</span></p> <p class='mouth_num'>月销：<span>" + sell_num + "</span></p>" +
                        "<p class='coupon_back'><span class='small_word small_color'>券后</span><span class='small_word'>￥</span><span>" + price + "</span></p>" +
                        " <p class='commission'><span class='small_word small_color'>佣金</span><spanclass='small_word'>￥</span>" +
                        "<span>" + commission_finally + "</span></p> <p class='log_pro'><img src='" + is_tmall + "' alt='天猫'/></p></div></div>"
                });
                document.getElementById("goods-list").innerHTML=html;
                $("img").on("error", function () { $(this).attr("src", "/web/images/mrtp.jpg"); });
            } else if(data.data.length <0){
                layer.msg('加载完了,以后我们努力给你更多!');
            }
        }
    })
})



//tab栏获取数据

$(".prod_type_box li").on('click',function(){
    var sendData={};
    console.log("11111111111111")
    console.log(this)
    var nav_tab=$('.prod_type_list li');
    var nav_tabs=$('.tab_nav span');
          nav_tabs =nav_tabs[0]
    console.log(nav_tab)
    // nav_tabs.className = 'tab_nav_active';
    console.log(nav_tab)
    for(var i=0;i<nav_tab.length;i++){
        console.log(nav_tab[i])
        nav_tab[i].className = '';
    }
    this.className = 'active';
    console.log(this)
    //获取分类
    var active_category=this.id;
    console.log(active_category)
    //获取排序
    var sort=$(".tab_nav_active")[0].id;
    console.log(sort)

    //    获取搜索词
    var keyword=$('#search_value').val();
    console.log(keyword)
    //    获取筛选条件
    var checked=document.getElementsByClassName('inputs');
    var isTmall,isYfx,isHaitao,isJyj,isTwenty,isNine,isJuhuashuan,isTaoqianggou,isQjd,isJpseller,today;
    //遍历选中框
    for (var i = 0; i < checked.length; i++) {
        if ($(checked[i]).prop('checked')) {
            var name=checked[i].name;
            var value=checked[i].value;
            if(name=='today'){
                today=value
            }else if(name=='isTmall'){
                isTmall=value
            }else if(name=='isJpseller'){
                isJpseller=value
            }else if(name=='isQjd'){
                isQjd=value
            }else if(name=='isTaoqianggou'){
                isTaoqianggou=value
            }else if(name=='isJuhuashuan'){
                isJuhuashuan=value
            }else if(name=='isNine'){
                isNine=value
            }else if(name=='isTwenty'){
                isTwenty=value
            }else if(name=='isJyj'){
                isJyj=value
            }else if(name=='isHaitao'){
                isHaitao=value
            }else if(name=='isYfx'){
                isYfx=value
            }
        }
    }
    // console.log(newArr)
    //    获取券区间筛选条件
    var minCouponPrice=$(".in_clock").val();
    var maxCouponPrice=$(".in_clock0").val();
    var minPrice=$(".in_clock1").val();
    var maxPrice=$(".in_clock2").val();
    var minCommission=$(".in_clock3").val();
    var minSellNum=$(".in_clock4").val();
    console.log( minCouponPrice,maxCouponPrice,minPrice, maxPrice,minCommission,minSellNum)
    sendData= {
        minCouponPrice: minCouponPrice,
        maxCouponPrice: maxCouponPrice,
        minPrice:minPrice,
        maxPrice:maxPrice,
        minCommission:minCommission,
        minSellNum: minSellNum,
        keyword:keyword,
        page:1,
        today:today,
        isTmall:isTmall,
        isJpseller:isJpseller,
        isQjd:isQjd,
        isTaoqianggou:isTaoqianggou,
        isJuhuashuan:isJuhuashuan,
        isNine: isNine,
        isTwenty:isTwenty,
        isJyj:isJyj,
        isHaitao: isHaitao,
        isYfx:isYfx,
        category:active_category,
        sort:sort
    }
    //    发送请求获取数据
    $.get({
        type: "GET",
        url:getListUrl,
        data:sendData,
        dataType: "json",
        success:function(data){
            console.log(data)
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
                document.getElementById("goods-list").innerHTML=html;
                $("img").on("error", function () { $(this).attr("src", "/web/images/mrtp.jpg"); });
            } else if(data.data.length <0){
                layer.msg('加载完了,以后我们努力给你更多!');
            }
        }
    })


})



//分类栏获取数据
$(".tab_nav span").on('click',function(){
    var sendData={};
    console.log("11111111111111")
    var nav_tab=$('.tab_nav span');
    console.log(nav_tab)
    for(var i=0;i<nav_tab.length;i++){
        console.log(nav_tab[i])
        nav_tab[i].className = '';
    }


    this.className = 'tab_nav_active';
    var sort=this.id;
    //获取分类
    var active_category=$(".active")[1].id;
    console.log(active_category)
    //    获取搜索词
    var keyword=$('#search_value').val();
    console.log(keyword)
    //    获取筛选条件
    var checked=document.getElementsByClassName('inputs');
    var isTmall,isYfx,isHaitao,isJyj,isTwenty,isNine,isJuhuashuan,isTaoqianggou,isQjd,isJpseller,today;
    //遍历选中框
    for (var i = 0; i < checked.length; i++) {
        if ($(checked[i]).prop('checked')) {
            var name=checked[i].name;
            var value=checked[i].value;
            if(name=='today'){
                today=value
            }else if(name=='isTmall'){
                isTmall=value
            }else if(name=='isJpseller'){
                isJpseller=value
            }else if(name=='isQjd'){
                isQjd=value
            }else if(name=='isTaoqianggou'){
                isTaoqianggou=value
            }else if(name=='isJuhuashuan'){
                isJuhuashuan=value
            }else if(name=='isNine'){
                isNine=value
            }else if(name=='isTwenty'){
                isTwenty=value
            }else if(name=='isJyj'){
                isJyj=value
            }else if(name=='isHaitao'){
                isHaitao=value
            }else if(name=='isYfx'){
                isYfx=value
            }
        }
    }
    // console.log(newArr)
    //    获取券区间筛选条件
    var minCouponPrice=$(".in_clock").val();
    var maxCouponPrice=$(".in_clock0").val();
    var minPrice=$(".in_clock1").val();
    var maxPrice=$(".in_clock2").val();
    var minCommission=$(".in_clock3").val();
    var minSellNum=$(".in_clock4").val();
    console.log( minCouponPrice,maxCouponPrice,minPrice, maxPrice,minCommission,minSellNum)
    sendData= {
        minCouponPrice: minCouponPrice,
        maxCouponPrice: maxCouponPrice,
        minPrice:minPrice,
        maxPrice:maxPrice,
        minCommission:minCommission,
        minSellNum: minSellNum,
        keyword:keyword,
        sort:sort,
        page:1,
        today:today,
        isTmall:isTmall,
        isJpseller:isJpseller,
        isQjd:isQjd,
        isTaoqianggou:isTaoqianggou,
        isJuhuashuan:isJuhuashuan,
        isNine: isNine,
        isTwenty:isTwenty,
        isJyj:isJyj,
        isHaitao: isHaitao,
        isYfx:isYfx,
        category:active_category
    }
    //    发送请求获取数据
    $.get({
        type: "GET",
        url:getListUrl,
        data:sendData,
        dataType: "json",
        success:function(data){
            console.log(data)
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
                document.getElementById("goods-list").innerHTML=html;
                $("img").on("error", function () { $(this).attr("src", "/web/images/mrtp.jpg"); });
            } else if(data.data.length <0){
                layer.msg('加载完了,以后我们努力给你更多!');
            }
        }
    })
})






