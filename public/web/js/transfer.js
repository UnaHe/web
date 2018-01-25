/**
 * Created by Lee on 2017/5/3.
 */
var goods =  {};
var goods_js = {};
var goods_es ={};
var goods_cj = {};
var goods_coupon = {};
var goods_better_tit = {};
var links_qq = {};
var links_wx = {};
var cj_select_quan = false;
var setTplInd = null;
var slideSta = false;
var qTransSta = true;
var wxTransSta = true;
var quanFun = quanItem();
var checkCjTimer;
var clearCjTimerNum = 0;
var authClick = {qq:false,wx:false,t:0};
var userAuthSlideTimer;
var total_pic_num = 8;

var transferHomePluginSta = "官网启动";

var OBJ_EDIT_PID = {
    qq_item:function(){
        return $(".spread-info .q-area .qq-head > p > .selected-pid > b").eq(0);
    },
    wx_item:function(){
        return $(".spread-info .wx-area .copy-comm-head >  p > .selected-pid > b").eq(0);
    },
    qq_link:function(){
        return $(".spread-info .q-area .qq-head > p > .selected-pid > a").eq(0);
    },
    wx_link:function(){
        return $(".spread-info .wx-area .copy-comm-head >  p > .selected-pid > a").eq(0);
    },
    // set_pid_new:'<a href="'+set_pid_url+'" style="color:blue;text-decoration: underline;">点此去设置</a>',
    tmp_pid:"",
    init:function(){
        var ths = this;
        this.qq_item().bind("focus",this.focus_css);
        this.wx_item().bind("focus",this.focus_css);
        this.qq_item().bind("blur",this.blur_css);
        this.wx_item().bind("blur",this.blur_css);

        $(".q-area .qq-head > p").click(function(){
            ths.qq_item().focus();
        });
        $(".wx-area .copy-comm-head >  p").click(function(){
            ths.wx_item().focus();
        });

    },
    focus_css:function(){
        $(this).css({"width":"245px"});
        var txt = $(this).text();
        if(!OBJ_EDIT_PID.check_pid(txt)){
            $(this).text("");
            OBJ_EDIT_PID.tmp_pid = "";
        }else {
            OBJ_EDIT_PID.tmp_pid = txt;
        }
    },
    blur_css:function(){
        var ths = $(this);
        ths.css({"width":"auto","min-width":"100px"});
        var txt = $.trim(ths.text());
        var link = ths.next("a");
        if(!OBJ_EDIT_PID.check_pid(txt)){
            if(OBJ_EDIT_PID.check_pid(OBJ_EDIT_PID.tmp_pid)){
                OBJ_EDIT_PID.save_pid(ths,OBJ_EDIT_PID.tmp_pid);
            }else {
                ths.text("无PID信息，可手动输入或");
                if(link.length <= 0){
                    $(OBJ_EDIT_PID.set_pid_new).insertAfter(ths);
                }
            }
        }else {
            if(link.length > 0){
                link.remove();
            }

            OBJ_EDIT_PID.save_pid(ths,txt);
        }
    },
    save_pid:function(item,pid){
        /**
         * 保存编辑的pid
         */
        var par = item.parents(".copy-box");
        par.find(".selected-pid .pid-number").text(pid);
        if(par.hasClass("q-area")) {
            //QQ的pid
            $("#qq_pid").val(pid);
        }else{
            $("#wx_pid").val(pid);
        }
    },
    check_pid : function (pid){
        var pid_rule = /^mm_\d+_\d+_\d+$/i;
        return pid_rule.test(pid);
    }
};

var PRODUCT_JC = {
    add:function(title,url,extend){
        var item = $(".goods-rectify").eq(0);
        var href = item.prop("href");
        extend = extend ? extend :"";
        href = href+"&name="+encodeURIComponent(title)+"&url="+encodeURIComponent(url)+extend;
        item.prop("href",href);
        item.show();
    },
    remove:function(){
        $(".goods-rectify").eq(0).hide();
    }
};

var GoodFun = {
    isJu : function(gid,fun,err){
        $.ajax({
            url:"https://detail.ju.taobao.com/detail/json/mobile_dynamic.do?item_id="+gid,
            type: 'get',
            dataType: 'jsonp',
            timeout: 10000,
            callback:'aa',
            success: fun,
            error:err
        });
    }
};

$(function () {
    var comBalanceWay = "#commission-balance-way";
    var transferSetTplLi = ".transfer-set-tpl ul li";
    var gid = $("#goods_id").val();
    var setTplType = false;

    //获取佣金结算方式
    $(".spread-info .spread-coupon ul li").each(function () {
        if($(this).hasClass("active")) {
            $(comBalanceWay).val($(this).data("val"));
        }
    });

    $(".spread-info .spread-coupon ul li").on("click", function () {
        $(this).addClass("active").siblings().removeClass("active");
        $(comBalanceWay).val($(this).data("val"));
    });

    //统计-判断是从官网和插件
    if(goods_page.activity_id != null) {
        transferHomePluginSta = "插件启动"
    }
    xctj("ec=load", "bs=1","pCode=qtkwww","ea=转链-" + transferHomePluginSta + "-PV统计","gid=" + $("#goods_id").val());

    //判断是否为轻搜搜后
    setTimeout(function () {
        var qs_sReg = new RegExp("qs_s");
        if(qs_sReg.test(window.location.href)) {
            xctj("ec=load", "bs=1", "pCode=qtkwww","ea=轻搜-转链-官网-搜后");
        }
    },300);

    //统计
    var getPidOptionsNum = 0;
    var getPidOptionsTimer = setInterval(function () {
        getPidOptionsNum++;
        if(getPidOptionsNum >= 30) {
            clearInterval(getPidOptionsTimer);
            return;
        }
        if($(".spread-main .q-area .pid-options li").length > 0) {
            //QQPID
            $(".spread-main .q-area .pid-options li").each(function () {
                $(this).addClass("common-bd-xCtJ-count");
                $(this).attr('data-params', 'ea=转链-QQPid切换-' + transferHomePluginSta + ',gid=' + $("#goods_id").val());
            });
            //WXPID
            $(".spread-main .wx-area .pid-options li").each(function () {
                $(this).addClass("common-bd-xCtJ-count");
                $(this).attr('data-params', 'ea=转链-微信Pid切换-' + transferHomePluginSta + ',gid=' + $("#goods_id").val());
            });
            clearInterval(getPidOptionsTimer);
        }
    }, 300);

    //短链接复制
    $(".copy-link-item a").on("click", function () {
        var html = "<div id='copyInput' class='copyInput'>" + $(this).prev("input").val() + "</div>";
        $("#copyInput").remove();
        $("body").append(html);
        ClipBoardComm(".short-link-btn");
    });

    //PID下拉
    pidSlideDown();

    //弹出框 - 设置模板
    $(".spread-info .set-tpl, .transfer-long-pic #set-tpl-btn").on("click", function (){
        var targetEle = $("#get-set-tpl").html();
        layer.open({
            type: 1,
            skin: 'qtk-set-pid transfer-set-tpl',
            area: ['600px'],
            title: '设置话术模板',
            shadeClose: true, //点击遮罩关闭
            content: targetEle,
            success: function () {
                //弹出框-模板切换
                //获取模板值
                $(".transfer-set-tpl #default-tpl0").show();
                setGetTpl();
                $(transferSetTplLi).each(function () {
                    if($(this).hasClass("active")) {
                        setTplInd = $(this).index();
                        setTplType = $(this).data("type");
                        $(".transfer-set-tpl .tpl-area").eq($(this).index()).show();
                    }
                });
                $(transferSetTplLi).on("click", function () {
                    setTplInd = $(this).index();
                    if(setTplInd != 3) {
                        setTplType = $(this).data("type");
                        $(this).addClass("active").siblings().removeClass("active");
                        $(".transfer-set-tpl textarea").hide();
                        $(".transfer-set-tpl textarea").eq($(this).index()).show();

                        var target_tpl = $(".transfer-set-tpl #default-tpl"+setTplInd);
                        $(".transfer-set-tpl .transfer-tpl-label").hide();
                        target_tpl.show();
                        tplEditFun();
                    } else {
                        layer.closeAll();
                    }
                });
                //清空模板
                $(".transfer-set-tpl .transfer-btn-area .clear-tpl").on("click", function () {
                    $(this).parents(".transfer-set-tpl").find(".tpl-area").each(function () {
                        if($(this).css("display") == "inline-block") {
                            $(this).val("");
                        }
                    });
                });
                //还原默认模板
                $(".transfer-set-tpl .transfer-btn-area .default-tpl").on("click", function () {
                    $(this).parents(".transfer-set-tpl").find(".tpl-area").each(function () {
                        if($(this).css("display") == "inline-block") {
                            if(setTplInd == 0) {
                                $(this).val(default_qq_code);
                            } else if(setTplInd == 1) {
                                $(this).val(default_wx_code);
                            } else if(setTplInd == 2) {
                                $(this).val(default_coupon_code);
                            }
                        }
                    });
                });
                tplEditFun();
            }
        });
    });

    //保存模板
    $("body").on("click", ".transfer-set-tpl .transfer-btn-area .save-tpl", function () {
        //var val = $(".transfer-set-tpl textarea").eq(setTplInd).val();
        var error = [];
        var code_data = {
            type:'all' ,
            wx_code: $.trim($(".transfer-set-tpl .transfer-wx-tpl").val()),
            qq_code:$.trim($(".transfer-set-tpl .transfer-qq-tpl").val()),
            none_code:$.trim($(".transfer-set-tpl .transfer-coupon-tpl").val()),
            long_pic:$.trim($(".transfer-set-tpl .transfer-pic-tpl").val())
        };
        if(getBLen(code_data.wx_code) <= 0){
            error.push("微信话术模板");
        }
        if(getBLen(code_data.qq_code)<= 0){
            error.push("QQ话术模板");
        }
        if(getBLen(code_data.none_code)<= 0){
            error.push("无券话术模板");
        }
        if(error.length > 0){
            layer.msg(error.join("、")+"不能为空，请填写话术模板");
            return;
        }
        if(getBLen(code_data.wx_code)>1000){
            error.push("微信话术模板");
        }
        if(getBLen(code_data.qq_code)>1000){
            error.push("QQ话术模板");
        }
        if(getBLen(code_data.none_code)>1000){
            error.push("无券话术模板");
        }
        if(error.length > 0){
            layer.msg(error.join("、")+"超过了1000个文字，保存失败");
            return;
        }
        $.ajax({
            url: '/index.php?r=transfer/saveTpl',
            type: 'post',
            data : code_data,
            dataType: 'json',
            timeout: 10000,
            success: function (res) {
                if(res.status == 0){
                    layer.msg("保存成功");
                    setTimeout(function(){
                        layer.closeAll();
                        var str;
                        $('#wx_code').val(code_data.wx_code);
                        str = setCode('wx_code');
                        $(".wx-area .copy-con-area").html(str);
                        $('#qq_code').val(code_data.qq_code);
                        str = setCode('qq_code');
                        $(".q-area .copy-con-area").html(str);
                        $('#none_code').val(code_data.none_code);
                        str = setCode('none_code');
                    },800)
                }
                if(res.status == 1){
                    layer.msg(res.data.msg);
                }
            }
        });
    });

    //设置用户名 标题
    $(".set-username .title").on("click",function(){
        if(page_auth_is_enable != '1'){
            updateAuthorizeManager($("#forUrl").attr("href"));
        }
    });

    //QQ一链生成
    $("#q-before-btn").on("click", function(){
        //判断是否有登录授权
        if(page_auth_is_enable != '1'){
            updateAuthorizeManager($("#forUrl").attr("href"));
        }else{
            var wenan = $("#js_detail_form input[name='wenan']").val();
            var wenan_p = $("#spread-copy-opts > p:first"); //YW
            if(!wenan && wenan_p.length > 0){
                $("#js_detail_form input[name='wenan']").val(wenan_p.find("span").text());
                wenan_p.click(); //YW
            }
            var pid = $("[name='qq_pid']").val();
            if(!OBJ_EDIT_PID.check_pid(pid)){
                return diffPidTbId($("#forUrl").prop("href"));
            }
            var param = $("#js_detail_form").serialize()+"&pid="+pid+"&type=qq&c="+goods_page.tao_code+"&s_c="+goods_page.s_url;
            $.ajax({ //YW
                url: $("#js_detail_form").prop('action'),
                data :param ,
                type: 'post',
                dataType: 'json',
                success: function (res) {
                    var str;
                    if(res.status == 0){
                        global_user_pids.set("qq_pid",pid);
                        goods.is_no_quan = res.data.no;
                        $("[name='s_click_link']").val(res.data.url);
                        $("[name='tao_code']").val(res.data.code);
                        links_qq.s_click_link = res.data.url;
                        links_qq.tao_code = res.data.code;
                        links_qq.emojicode = res.data.emojicode;
                        if(!goods.quan_id && !goods.quan_price && res.data.quan){
                            if(res.data.quan.quan_id){
                                goods.quan_id = res.data.quan.quan_id;
                            }
                            if(res.data.quan.price){
                                goods.quan_price = res.data.quan.price;
                                goods.used_price = transferPrice(goods.price - goods.quan_price);
                                goods.quan_over = res.data.quan.total - res.data.quan.remain;
                                if(goods.quan_over<=0){
                                    goods.quan_over = 0;
                                }
                                goods.quan_num = res.data.quan.remain;
                            }
                            if(res.data.quan.rate){
                                goods.yongjin = res.data.quan.rate
                            }
                            setFormHtml('qq');
                            setQuanHtml('qq');
                        }
                        str = setCode('qq_code','create');
                        $(".q-area .copy-con-area").html(str);

                        $("#q-before-btn").addClass("hide");
                        $("#q-copy-btn").removeClass("hide");

                        //复制初始
                        var txt = $(".q-area .copy-con-area").html();
                        txt = txt.replace(/内部/g, '');

                        if (ClipboardSupport == 0) {
                            layer.msg('浏览器版本过低，请升级或更换浏览器后重新复制！', {
                                    time: 2000
                                }
                            );
                        } else {
                            if(document.getElementById('copyInput')){
                                //存在复制内容框重置值
                                $('#copyInput').html(txt);
                            }else{
                                //不存在复制内容框设置
                                var copy = document.createElement('div');
                                copy.id = "copyInput";
                                copy.innerHTML = txt;
                                document.body.appendChild(copy);
                            }
                            if(!$(this).hasClass('copy_text_btn')){
                                $(this).addClass('copy_text_btn');
                            }

                            var copy = document.getElementById('copyInput');
                            copyFunction(copy);
                        }

                        if(res.data.times <= 0){
                            $("#transfer-num-tips").removeClass("hide");
                            $(".transfer .spread-info .spread-main .spread-con").css("height", "725px");
                        }
                    }else {
                        if(res.data.code == 6){
                            noneQuan(goods.goods_id);
                        }else {
                            if(res.data.code == 91001){
                                authClick.wx = false;
                                authClick.qq = true;
                                return updateAuthorizeManager(res.data.auth_url);
                            }
                            if(res.data.code == 91003 || res.data.code == 91007){
                                authClick.wx = false;
                                authClick.qq = true;
                                return diffPidTbId(res.data.auth_url);
                            }
                            if(res.data.code == 91008){
                                authClick.wx = true;
                                authClick.qq = false;
                                return updateAuthorizeManager(res.data.auth_url);
                            }
                            layer.msg(res.data.msg);
                        }
                    }
                },
                error: function () {
                    layer.msg("官方接口数据出错，请稍后再试！");
                }
            })
        }

    });

    //qq键复制
    $("#q-copy-btn").on("click", function(){
        //复制文案
        var txt = $(".q-area .copy-con-area").html();
        txt = txt.replace(/内部/g, '');

        if (ClipboardSupport == 0) {
            layer.msg('浏览器版本过低，请升级或更换浏览器后重新复制！', {
                    time: 2000
                }
            );
        } else {
            if(document.getElementById('copyInput')){
                //存在复制内容框重置值
                $('#copyInput').html(txt);
            }else{
                //不存在复制内容框设置
                var copy = document.createElement('div');
                copy.id = "copyInput";
                copy.innerHTML = txt;
                document.body.appendChild(copy);
            }
            if(!$(this).hasClass('copy_text_btn')){
                $(this).addClass('copy_text_btn');
            }

            var copy = document.getElementById('copyInput');
            copyFunction(copy);
        }
    });

    //微信一键生成
    $("#wx-before-btn").on("click", function() {
        if(page_auth_is_enable != '1'){
            $("#create-pic-view-area").data("ready",'error');
            //修改转长图为已修改
            longPicChangeSta = true;
            updateAuthorizeManager($("#forUrl").attr("href"));
        }else{
            var wenan = $("#js_detail_form input[name='wenan']").val();
            var wenan_p = $("#spread-copy-opts > p:first");
            if(!wenan && wenan_p.length > 0){
                $("#js_detail_form input[name='wenan']").val(wenan_p.find("span").text());
                wenan_p.click();
            }
            var pid = $("[name='wx_pid']").val();
            if(!OBJ_EDIT_PID.check_pid(pid)){
                $("#create-pic-view-area").data("ready",'error');
                //修改转长图为已修改
                longPicChangeSta = true;
                return diffPidTbId($("#forUrl").prop("href"));
            }
            var param = $("#js_detail_form").serialize()+"&pid="+pid+"&type=wx&c="+goods_page.tao_code+"&s_c="+goods_page.s_url;
            $.ajax({
                url: $("#js_detail_form").prop('action'),
                data :param ,
                type: 'post',
                dataType: 'json',
                success: function (res) {
                    var str;
                    if(res.status == 0){
                        global_user_pids.set("wx_pid",pid);
                        goods.is_no_quan = res.data.no;
                        $("[name='s_click_link']").val(res.data.url);
                        $("[name='tao_code']").val(res.data.code);
                        links_wx.s_click_link = res.data.url;
                        links_wx.tao_code = res.data.code;
                        links_wx.emojicode = res.data.emojicode;
                        if(!goods.quan_id && !goods.quan_price && res.data.quan){
                            if(res.data.quan.quan_id){
                                goods.quan_id = res.data.quan.quan_id;
                            }
                            if(res.data.quan.price){
                                goods.quan_price = res.data.quan.price;
                                goods.used_price = transferPrice(goods.price - goods.quan_price);
                                goods.quan_over = res.data.quan.total - res.data.quan.remain;
                                if(goods.quan_over<=0){
                                    goods.quan_over = 0;
                                }
                                goods.quan_num = res.data.quan.remain;
                            }
                            if(res.data.quan.rate){
                                goods.yongjin = res.data.quan.rate
                            }
                            setFormHtml('wx');
                            setQuanHtml('wx');
                        }
                        str = setCode('wx_code','create');
                        $(".wx-area .copy-con-area").html(str.replace("<span>{图片}</span><br/>",""));

                        $("#wx-before-btn").addClass("hide");
                        $("#wx-copy-btn").removeClass("hide");
                        $("#create-pic-view-area").data("ready",'ok');

                        //复制初始
                        var txt, imgSrc, html;
                        txt = $(".wx-area .copy-con-area").html();
                        txt = txt.replace(/内部/g, '');
                        imgSrc = $(".wx-area .wx-spread-pic img").attr("src");
                        html = "<img src='" + imgSrc + "'><br/>" + txt + "";

                        if (ClipboardSupport == 0) {
                            layer.msg('浏览器版本过低，请升级或更换浏览器后重新复制！', {
                                    time: 2000
                                }
                            );
                        } else {
                            if(document.getElementById('copyInput')){
                                //存在复制内容框重置值
                                $('#copyInput').html(html);
                            }else{
                                //不存在复制内容框设置
                                var copy = document.createElement('div');
                                copy.id = "copyInput";
                                copy.innerHTML = html;
                                document.body.appendChild(copy);

                            }
                            if(!$(this).hasClass('copy_text_btn')){
                                $(this).addClass('copy_text_btn');
                            }

                            var copyDom = document.getElementById('copyInput');
                            copyFunction(copyDom);
                        }

                        if(res.data.times <= 0){
                            $("#transfer-num-tips li").eq(1).show().find("span").eq(0).text(0);
                        }
                    } else {
                        $("#create-pic-view-area").data("ready",'error');
                        //修改转长图为已修改
                        longPicChangeSta = true;
                        if(res.data.code == 6){
                            noneQuan(goods.goods_id);
                        }else {
                            if(res.data.code == 91001){
                                authClick.wx = true;
                                authClick.qq = false;
                                return updateAuthorizeManager(res.data.auth_url);
                            }
                            if(res.data.code == 91003 || res.data.code == 91007 ){
                                authClick.wx = true;
                                authClick.qq = false;
                                return diffPidTbId(res.data.auth_url);
                            }
                            if(res.data.code == 91008){
                                authClick.wx = true;
                                authClick.qq = false;
                                return updateAuthorizeManager(res.data.auth_url);
                            }
                            layer.msg(res.data.msg);
                        }
                    }
                },
                error: function () {
                    $("#create-pic-view-area").data("ready",'error');
                    //修改转长图为已修改
                    longPicChangeSta = true;
                    layer.msg("官方接口数据出错，请稍后再试！");
                }
            })
        }

    });

    //WX复制
    $("#wx-copy-btn").click(function(){
        //复制文案
        var txt, imgSrc, html;
        txt = $(".wx-area .copy-con-area").html();
        txt = txt.replace(/内部/g, '');
        imgSrc = $(".wx-area .wx-spread-pic img").attr("src");
        html = "<img src='" + imgSrc + "'><br/>" + txt + "";

        if (ClipboardSupport == 0) {
            layer.msg('浏览器版本过低，请升级或更换浏览器后重新复制！', {
                    time: 2000
                }
            );
        } else {
            if(document.getElementById('copyInput')){
                //存在复制内容框重置值
                $('#copyInput').html(html);
            }else{
                //不存在复制内容框设置
                var copy = document.createElement('div');
                copy.id = "copyInput";
                copy.innerHTML = html;
                document.body.appendChild(copy);

            }
            if(!$(this).hasClass('copy_text_btn')){
                $(this).addClass('copy_text_btn');
            }

            var copyDom = document.getElementById('copyInput');
            copyFunction(copyDom);
        }
    });

    quanFun.none();
    //获取信息
    $.ajax({
        url: '/index.php?r=transfer/goods&goodsid='+gid,
        type: 'post',
        dataType: 'json',
        success: function (res) {
            if(res.status == 0){
                //$(".goods-seller-info").hide();
                mainShow();
                setWwwGoods(res.data);
                $(document).trigger("turn");
                $("#qtk_flagship_version").trigger("click");
                setDefaultCode('create');
                getHws(gid,true);
                PRODUCT_JC.add(res.data.title,res.data.url);

            }else {
                getHws(gid,false);
                PRODUCT_JC.remove();
            }
        }
    });


    //推荐商品
    $.ajax({
        url: '/index.php?r=transfer/recommendgoods&gid='+gid,
        type: 'post',
        dataType: 'json',
        timeout: 10000,
        success: function (res) {
            for(var i = 0; i < res.data.length; i++) {
                var splitComm = res.data[i].commission.replace("%","").split(".");
                res.data[i]["int"]= splitComm[0];
                res.data[i]["transferSta"] = transferHomePluginSta;
                if(splitComm[1] != undefined) {
                    res.data[i]["float"] = "." + Number(splitComm[1]);
                } else {
                    res.data[i]["float"] = ""
                }
            }
            var html = template('recommendGoods', res);
            $("#recommendGoodsList").html(html);
            mediaTipsIcon();
        }
    });

    //获取优质标题
    $.ajax({
        url:'/index.php?r=transfer/nicetitle&goodsid=' + gid,
        type: 'post',
        dataType: 'json',
        timeout: 10000,
        success: function (res) {
            if(res.data.length > 0) {
                $(".goods-info .goods-new-tit").removeClass("hide");
                $(".goods-info .no-goods-new-tit").addClass("hide");
                goods_better_tit = res.data;
                findBetterTit("js");
            }
        }
    });

    //获取图片
    $.ajax({
        url:'/index.php?r=transfer/nicepic&goodsid=' + gid,
        type: 'post',
        dataType: 'json',
        timeout: 10000,
        success: function (res) {
            var picArr = '';
            var len = 0;
            if(res.data.length >= total_pic_num) {
                len = total_pic_num
            } else {
                len = res.data.length;
            }
            if(res.data.length > 0) {
                for(var i = 0; i < len; i++) {
                    if(typeof res.data[i] != 'undefined'){
                        picArr += "<li class='common-bd-xCtJ-count' data-params='ea=优质主图' data-fun='transferCondition'><div class='pic-box'><img src='"+res.data[i] + "' ></div><div class='big-pic'><p>图片预览</p><img src='"+ res.data[i] + "' alt=''></div><i class='common-icons'></i></li>";
                    }
                }
                $("#spread-pic-list").html(picArr);
                $("#spread-pic-list li").eq(0).addClass("active");
                picListFun();
            }
        }
    });

    //获取优质文案 spread-copy-more
    $.ajax({
        url: '/index.php?r=transfer/nicetext&goodsid=' + gid,
        type: 'post',
        dataType: 'json',
        timeout: 10000,
        success: function (res) {
            var txtArr = "", moreArr = "";
            if(res.data.length > 5) {
                $("#spread-copy-more").show();
                for( i = 5; i < 10; i++) {
                    if(typeof res.data[i] != 'undefined') {
                        moreArr += "<p class='common-bd-xCtJ-count' data-params='ea=优质文案' data-fun='transferCondition'><em>" + (i + 1) + "</em><span>" + res.data[i] + "</span><i class='common-icons'></i></p>";
                    }
                }
                $("#spread-copy-more-opts").html(moreArr);

                for(i = 0; i < 5; i++) {
                    if(typeof res.data[i] != 'undefined') {
                        txtArr += "<p class='common-bd-xCtJ-count' data-params='ea=优质文案' data-fun='transferCondition'><em>" + (i + 1) + "</em><span>" + res.data[i] + "</span><i class='common-icons'></i></p>";
                    }
                }
                $("#spread-copy-opts").html(txtArr);
                moreCopy();
                selectCopyTxt();
            } else {
                if(res.data.length > 0) {
                    for(var i = 0; i < res.data.length; i++) {
                        if(typeof res.data[i] != 'undefined') {
                            txtArr += "<p class='common-bd-xCtJ-count' data-params='ea=优质文案' data-fun='transferCondition'><em>" + (i + 1) + "</em><span>" + res.data[i] + "</span></p>";
                        }
                    }
                    $("#spread-copy-opts").html(txtArr);
                    selectCopyTxt();
                } else {
                    $("#spread-copy-opts .no-data-content1").removeClass("hide");
                }
            }
            copyWenanSta("js");
            moreCopy();
            setTimeout(function(){
                var str = $("#js_detail_form input[name='wenan']").val();
                if(str.length == 0){
                    $("#spread-copy-opts p:first").eq(0).click();
                }
            },2000);
        }
    });

    $("#cj_select_quan").click(function(){
        var ths = $(this);
        cj_select_quan = true;
        var t = parseFloat(ths.attr('t'));
        goods.quan_price = parseFloat(ths.attr('jian'));
        goods.quan_num = parseFloat(ths.attr('sheng'));
        goods.quan_over = parseFloat(ths.attr('yiLing'));
        goods.m = parseFloat(ths.attr('man'));
        goods.quan_id = $("[name='activityId']").val();
        goods.price = $("[name='price']").val();
        goods.quan_link = "https://shop.m.taobao.com/shop/coupon.htm?seller_id="+goods.seller_id+"&activityId="+goods.quan_id;
        var price = transferPrice(goods.price);
        var used_price = transferPrice(goods.price - goods.quan_price);
        var target = $(".goods-info").eq(0);
        //不是单价可用券（单品价格不符合满减规则），那么券后价显示商品价格，不进行券金额减除计算。
        if((used_price> 0) && (t == "1" || (price >= goods.m && goods.m > 0))){
            if(goods.isYu){
                goods.used_price = transferPrice(parseFloat(goods.price) - parseFloat(goods_page.quan_price) - transferPrice(goods.di - goods.yu));
            }else {
                goods.used_price = used_price;
            }
            $(".select-coupon-caution:not(.hide)").addClass("hide");
        }else {
            goods.used_price = price;
            $(".select-coupon-caution").removeClass("hide");
        }
        target.find(".goods-area .goods-coupon .coupon-price").eq(0).text(goods.used_price);

        setFormHtml('cj');
        setQuanHtml('cj');

        $("#q-before-btn").removeClass("hide");
        $("#q-copy-btn").addClass("hide");
        $("#wx-before-btn").removeClass("hide");
        $("#wx-copy-btn").addClass("hide");
        $("#create-pic-view-area").data("ready",'fall');
        //修改转长图为已修改
        longPicChangeSta = true;
    });

    $("#cj_yongjin_ready").click(function(){
        var yongjin = $("[name='yongjin']").val();//佣金值
        var yType = $("[name='yongjin']").attr("yType");//佣金类型
        goods.yongjin = yongjin;
        modifyYongJin();
    });

    //插件列表显示
    var timer;
    $(".plan ul li").on("mouseenter", function () {
        if($(this).find("#qtk_single_bg_div").length != 0) {
            $(this).find(".plan-plugin-item").show();

            $(this).find(".plan-plugin-item").on("mouseenter", function () {
                clearTimeout(timer);
                $(this).show();
            });
        }
    });
    $(".plan ul li").on("mouseleave", function () {
        var This = this;
        timer = setTimeout(function () {
            $(This).find(".plan-plugin-item").hide();
        }, 100);

        $(this).find(".plan-plugin-item").on("mouseleave", function () {
            $(this).hide();
        });
    });

    //授权 显示 PID值
    if(typeof global_user_pids != 'undefined' && page_auth_is_enable == '1'){
        global_user_pids.init(function () {
            var qq_pid = global_user_pids.get("qq_pid");
            var wx_pix = global_user_pids.get("wx_pid");
            if(qq_pid && qq_pid!='null'&& qq_pid!=''){
                OBJ_EDIT_PID.save_pid(OBJ_EDIT_PID.qq_item(),qq_pid);
                if(OBJ_EDIT_PID.qq_link().length > 0){
                    OBJ_EDIT_PID.qq_link().remove();
                }
            }else {
                OBJ_EDIT_PID.qq_item().html("无PID信息，可手动输入或");
                $("#qq_pid").val("");
                if(OBJ_EDIT_PID.qq_link().length <= 0){
                    $(OBJ_EDIT_PID.set_pid_new).insertAfter(OBJ_EDIT_PID.qq_item());
                }
            }
            if(wx_pix && wx_pix!='null' && wx_pix!=''){
                OBJ_EDIT_PID.save_pid(OBJ_EDIT_PID.wx_item(),wx_pix);
                if(OBJ_EDIT_PID.wx_link().length > 0){
                    OBJ_EDIT_PID.wx_link().remove();
                }
            }else {
                OBJ_EDIT_PID.wx_item().html("无PID信息，可手动输入或");
                $("#wx_pid").val("");
                if(OBJ_EDIT_PID.wx_link().length <= 0){
                    $(OBJ_EDIT_PID.set_pid_new).insertAfter(OBJ_EDIT_PID.wx_item());
                }
            }
        });
    }

    OBJ_EDIT_PID.init();

    $(document).on("click", ".copy-box .copy-main .copy-con-area a", function () {
        openNewWind($(this).attr("href"));
    });

    //检测插件是否安装
    checkCjTimer = setInterval(function () {
        if(isInsallPlugin()) {
            var cjVersionCode = $("#qtk_flagship_version").data("version-code");
            if(cjVersionCode < 48) {
                var par = $("#transfer-plugin-status .uninstall");
                par.find("span").text("发现新版本插件，请");
                par.find("a").text("下载更新");
            }
            clearInterval(checkCjTimer);
        } else {
            var par = $("#transfer-plugin-status .uninstall");
            par.find("span").text("未安装轻淘客插件，请");
            par.find("a").text("下载使用");
            //如果没有检测到插件， 10秒之后停止获取。。
            if(clearCjTimerNum == 500) {
                clearInterval(checkCjTimer);
            }
            clearCjTimerNum++;
        }
    },50);

    //完成授权
    $("#oauth_ready").click(function(){
        window.location.reload(true);
    });

    GoodFun.isJu($("#goods_id").val(),function(json){
        if(typeof json.item == 'undefined'){
            $("#js_detail_form [name='juhuasuan']").val(0);
            return ;
        }
        GoodFun.start = parseInt(json.item.onlineStartTime/60000);
        GoodFun.end  = parseInt(json.item.onlineEndTime/60000);
        GoodFun.now = parseInt(new Date().getTime()/60000);
        if(GoodFun.now >= GoodFun.start && GoodFun.now <= GoodFun.end){
            $("#js_detail_form [name='juhuasuan']").val(1);
        }else {
            $("#js_detail_form [name='juhuasuan']").val(0);
        }
    });


    //友盟统计
    if(goods_page.activity_id == null) {
        //转链单页-PV统计-轻官网启动
        umDataStatistics("转链单页-PV统计-轻官网启动","点击","","","");
        //标题有切换
        $("body").on("click", ".transfer .goods-area .options-titles p", function () {
            umDataStatistics("转链单页-优质标题-轻官网启动","点击","","","");
        });
        //转链主图
        $("body").on("click", "#spread-pic-list li", function () {
            umDataStatistics("转链单页-优质主图-轻官网启动","点击","","","");
        });
        //优质文案
        $("body").on("click", "#spread-copy-more-opts p, #spread-copy-opts p", function () {
            umDataStatistics("转链单页-优质文案-轻官网启动","点击","","","");
        });
        //QQ一键生成
        $("#q-before-btn").on("click", function () {
            umDataStatistics("转链单页-QQ一键生成-轻官网启动","点击","","","");
        });
        //QQ复制
        $("#q-copy-btn").on("click", function() {
            umDataStatistics("转链单页-QQ复制文案-轻官网启动","点击","","","");
        });
        //微信一键生成
        $("#wx-before-btn").on("click", function () {
            umDataStatistics("转链单页-微信一键生成-轻官网启动","点击","","","");
        });
        //微信复制
        $("#wx-copy-btn").on("click", function () {
            umDataStatistics("转链单页-微信复制文案-轻官网启动","点击","","","");
        });
        //QQPID切换
        $("body").on("click", ".spread-info .q-area .pid-options li", function () {
            umDataStatistics("转链单页-QQPid切换-轻官网启动","点击","","","");
        });
        //微信PID切换
        $("body").on("click", ".spread-info .wx-area .pid-options li", function () {
            umDataStatistics("转链单页-微信Pid切换-轻官网启动","点击","","","");
        });
        //推广商品图片、标题、券
        $("body").on("click", "#recommendGoodsList .media-list-item .spread-item-pic, #recommendGoodsList .media-list-item .spread-item-title, #recommendGoodsList .media-list-item .spread-coupon-info span", function () {
            umDataStatistics("转链单页-推广商品-轻官网启动","点击","","","");
        });
    } else {
        //转链单页-PV统计-插件启动
        umDataStatistics("转链单页-PV统计-插件启动","点击","","","");
        //标题有切换
        $("body").on("click", ".transfer .goods-area .options-titles p", function () {
            umDataStatistics("转链单页-优质标题-插件启动","点击","","","");
        });
        //转链主图
        $("body").on("click", "#spread-pic-list li", function () {
            umDataStatistics("转链单页-优质主图-插件启动","点击","","","");
        });
        //优质文案
        $("body").on("click", "#spread-copy-more-opts p, #spread-copy-opts p", function () {
            umDataStatistics("转链单页-优质文案-插件启动","点击","","","");
        });
        //QQ一键生成
        $("#q-before-btn").on("click", function () {
            umDataStatistics("转链单页-QQ一键生成-插件启动","点击","","","");
        });
        //QQ复制
        $("#q-copy-btn").on("click", function() {
            umDataStatistics("转链单页-QQ复制文案-插件启动","点击","","","");
        });
        //微信一键生成
        $("#wx-before-btn").on("click", function () {
            umDataStatistics("转链单页-微信一键生成-插件启动","点击","","","");
        });
        //微信复制
        $("#wx-copy-btn").on("click", function () {
            umDataStatistics("转链单页-微信复制文案-插件启动","点击","","","");
        });
        //QQPID切换
        $("body").on("click", ".spread-info .q-area .pid-options li", function () {
            umDataStatistics("转链单页-QQPid切换-插件启动","点击","","","");
        });
        //微信PID切换
        $("body").on("click", ".spread-info .wx-area .pid-options li", function () {
            umDataStatistics("转链单页-微信Pid切换-插件启动","点击","","","");
        });
        //推广商品图片、标题、券
        $("body").on("click", "#recommendGoodsList .media-list-item .spread-item-pic, #recommendGoodsList .media-list-item .spread-item-title, #recommendGoodsList .media-list-item .spread-coupon-info span", function () {
            umDataStatistics("转链单页-推广商品-插件启动","点击","","","");
        });
    }

    //券信息修改
    $("#transfer-coupon-change").on("click", function () {
        if(goods_page.activity_id == null) {
            umDataStatistics("转链单页-修改券信息-轻官网启动","点击","","","");
            xctj("ec=click", "转链-修改券信息-轻官网启动","bs=1","pCode =qtkwww");
        } else {
            umDataStatistics("转链单页-修改券信息-插件启动","点击","","","");
            xctj("ec=click", "转链-修改券信息-插件启动","bs=1","pCode =qtkwww");
        }
    });

    //授权PID下拉。。如果下拉只有一个列表且等于授权信息则不显示。其它均显示 //开始
    //authSlideDown($(".set-username"));
    $(".set-username").on("mouseenter",function() {
        authSlideDown($(this), true);
    });
    $(".set-username").on("mouseleave",function() {
        userAuthSlideTimer = setTimeout(function () {
            $(".set-forUser").hide();
        }, 150);
    }); // 结束

    //下拉已授权PID选择
    $(".set-forUser li").on("click",function(){
        $(".set-username .title").text($(this).text());
        var authid = $(this).attr("authid");
        var js_wx_pid = "", js_qq_pid = "";
        $.post(" /index.php?r=userCenter/authenable",{ id:authid },function(data){
            if(data.status == 0){
                global_user_pids.set_tao(data.data.id);

                /**
                 * 设置qq及微信pid，优先级，本地缓存最优先，然后数据库次优先
                 */
                js_wx_pid = OBJ_EDIT_PID.check_pid(js_wx_pid) ? js_wx_pid : global_user_pids.get("wx_pid");
                js_wx_pid = OBJ_EDIT_PID.check_pid(js_wx_pid) ? js_wx_pid : data.data.pid;
                if(js_wx_pid && OBJ_EDIT_PID.check_pid(js_wx_pid)){
                    $(".wx-area .selected-pid .pid-name").text("微信");
                    OBJ_EDIT_PID.save_pid(OBJ_EDIT_PID.wx_item(),js_wx_pid);
                }else {
                    $(".wx-area .selected-pid .pid-name").text("微信");
                    OBJ_EDIT_PID.save_pid(OBJ_EDIT_PID.wx_item(),"");
                }

                js_qq_pid = OBJ_EDIT_PID.check_pid(js_qq_pid) ? js_qq_pid : global_user_pids.get("qq_pid");
                js_qq_pid = OBJ_EDIT_PID.check_pid(js_qq_pid) ? js_qq_pid : data.data.qq_pid;
                if(js_qq_pid && OBJ_EDIT_PID.check_pid(js_qq_pid)){
                    $(".qq-head .selected-pid .pid-name").text("QQ");
                    OBJ_EDIT_PID.save_pid(OBJ_EDIT_PID.qq_item(),js_qq_pid);
                }else {
                    $(".qq-head .selected-pid .pid-name").text("QQ");
                    OBJ_EDIT_PID.save_pid(OBJ_EDIT_PID.qq_item(),"");
                }
                OBJ_EDIT_PID.qq_item().blur();
                OBJ_EDIT_PID.wx_item().blur();

                if(page_auth_is_enable == 1) {
                    $(OBJ_EDIT_PID.wx_link()).attr("href", "javascript:;").attr("id", "transfer-set-wx-pid-btn");
                    $(OBJ_EDIT_PID.qq_link()).attr("href", "javascript:;").attr("id", "transfer-set-qq-pid-btn");
                }

                $(".copy-box .selected-pid a").removeClass("hide"); //显示点此去设置

                /**
                 * 切换账号后可以重新转链
                 */
                $("#q-before-btn").removeClass("hide");
                $("#q-copy-btn").addClass("hide");
                $("#wx-before-btn").removeClass("hide");
                $("#wx-copy-btn").addClass("hide");
                /**
                 * 重新转长图
                 */
                $("#create-pic-view-area").data("ready",'fall');
                //修改转长图为已修改
                longPicChangeSta = true;
            }
            if(data.status!=0){}
        });
        $(".set-forUser").hide();
    });

    //点击 点此去设置
    /** 判断是否授权 **/
    if(page_auth_is_enable == 0) { //判断未授权-无PID跳转到个人中心 授权管理
        $("#transfer-set-qq-pid-btn, #transfer-set-wx-pid-btn").attr("href", set_pid_url);
    }
    $("body").on("click",".change-pid, #transfer-set-qq-pid-btn, #transfer-set-wx-pid-btn",function(){
        if(page_auth_is_enable == 0) { //判断未授权-无PID跳转到个人中心 授权管理
            $("#transfer-set-qq-pid-btn, #transfer-set-wx-pid-btn").attr("href", set_pid_url);
            return;
        }
        var iptVal = $.trim($(".qq-head .selected-pid .pid-number").text());
        iptVal = OBJ_EDIT_PID.check_pid(iptVal) ? iptVal : "";
        var wiptVal = $.trim($(".wx-area .selected-pid .pid-number").text());
        wiptVal = OBJ_EDIT_PID.check_pid(wiptVal) ? wiptVal : "";
        $("body").css("overflow", "hidden");
        layer.open({
            type: 1,
            skin: 'transfer-pid-pid',
            area: ['770px', '330px'],
            title: "提示",
            shadeClose: true, //点击遮罩关闭
            content: "<p class='wrapper'><div class='qq-pid'>QQ推广渠道PID</div><div class='wx-pid'>微信推广渠道PID</div></p><div class='ipt-area'><input type='text' name='qq-pid' class='ipt-qq' value/><input type='text' name='wx-pid' class='ipt-wx' value/></div><p class='danger'>注意：请登录当前授权的联盟账号查询PID。</p><a href='http://pub.alimama.com/myunion.htm#!/manage/zone/zone?tab=3' class='el-a' target='_blank'>查询阿里妈妈PID</a><button>保存</button>   ",
            success: function () {
                //赋值
                $(".transfer-pid-pid .ipt-qq").val(iptVal);
                $(".transfer-pid-pid .ipt-wx").val(wiptVal);
                $(".transfer-pid-pid button").click(function(){
                    var param = {
                        id:global_user_pids.get_tao(),
                        pid: $.trim($(".transfer-pid-pid .ipt-wx").val()),
                        qq_pid:$.trim($(".transfer-pid-pid .ipt-qq").val())
                    };
                    $.post(" /index.php?r=userCenter/authpidedit",param,function(data){
                        if(data.status == 0){
                            OBJ_EDIT_PID.save_pid(OBJ_EDIT_PID.qq_item(),param.qq_pid);
                            OBJ_EDIT_PID.save_pid(OBJ_EDIT_PID.wx_item(),param.pid);
                            OBJ_EDIT_PID.qq_item().blur();
                            OBJ_EDIT_PID.wx_item().blur();
                            $("#create-pic-view-area").data("ready",'fall');
                            //修改转长图为已修改
                            longPicChangeSta = true;
                            layer.alert("修改成功！");
                            setTimeout(function(){
                                layer.closeAll();
                            },500);
                        }else{
                            layer.alert(data.data);
                        }

                    });
                });
            },
            end: function () {
                $("body").removeAttr("style");
            }
        });
    });
});

//多授权下拉展示
function authSlideDown(Ths, sta) {
    var authorId = $.trim(Ths.find(".title").attr("authid"));
    var slideEle = $(".set-forUser li");
    var slideParEle = $(".set-forUser");

    slideParEle.show();

    slideParEle.on("mouseenter",function() {
        clearInterval(userAuthSlideTimer);
    });
}

//权限管理--更新权限
function updateAuthorizeManager(url) {
    layer.closeAll();
    layer.open({
        type: 2,
        closeBtn: 1,
        title: '授权并登录',
        shadeClose: true,
        shade: 0.5,
        area: ['760px', '550px'],
        fixed: false, //不固定
        maxmin: true,
        content: [url, 'no']
    });
}

//PID与授权帐号不匹配
function diffPidTbId(url) {
    layer.closeAll();
    layer.open({
        type: 1,
        skin: 'transfer-pid-authorize',
        area: ['500px', '330px'],
        title: "提示",
        shadeClose: true, //点击遮罩关闭
        content: "<div class='title'>PID与授权帐号不匹配</div><div class='sub-title'><div class='desc'>请选择处理方式：</div><p>1、使用<span>联盟账号</span>对应<span>PID</span>；</p><p>2、切换<span>PID</span>所属的<span>联盟账号</span>。</p></div><div class='btn-group'><p><a class='change-pid' href='javascript:;'>更换PID</a><a class='authorize-reset' href='"+set_pid_url+"'>切换帐号</a></p><p><a href='/jump/auth_help' target='_blank'>使用帮助</a></p></div>",
        success: function () {
        }
    });
}

//渲染新标题
function findBetterTit(type) {
    if(type == "js") {
        var num = 0, _html = "";
        if(goods_better_tit.length > 0) {
            for(var j = 0; j < goods_better_tit.length; j++) {
                if(goods.title != goods_better_tit[j]) {
                    num++;
                }
            }
            if(num == goods_better_tit.length) {
                if(goods.title != undefined) {
                    goods_better_tit.unshift(goods.title);
                    goods_better_tit.length = 5;
                }
            }
            for(var i = 0; i < goods_better_tit.length; i++) {
                if(typeof goods_better_tit[i] != 'undefined'){
                    _html += "<p class='common-bd-xCtJ-count' data-params='ea=优质标题' data-fun='transferCondition'><em>" + (i + 1) + "</em><span>" + goods_better_tit[i] + "</span></p>";
                }
            }
            $(".goods-area .options-titles").html(_html);
            $(".goods-area .options-titles p").each(function () {
                if(goods.title == $(this).find("span").text()) {
                    $(this).addClass("active");
                }
            });
            moreNewTitle();
        }
    }
}

//优质文案
function copyWenanSta(type) {
    if(type == "js") {
        $("#spread-copy-opts p").each(function () {
            if(goods.wenan == $(this).find("span").text()) {
                $(this).addClass("active");
            }
        });
    }
}

//打开新窗口
function openNewWind(url) {
    var url = '<a id="openNewWind" class="hide" href="'+url+'" target="_blank"></a>';
    $("body").append(url);
    document.getElementById("openNewWind").click();
    $("#openNewWind").remove();
}

//复制方法
function ClipBoardComm(ths) {
    //复制方法
    var commClip = new Clipboard(ths, {
        target: function() {
            return document.getElementById('copyInput');
        }
    });
    setTimeout(function () {
        commClip.on('success', function(e) {
            layer.msg('已复制');
            e.clearSelection();
        });
        commClip.on('error', function(e) {
            //alert('您的浏览器不支持一键复制，请升级浏览器或更换浏览器');
            e.clearSelection();
        });
    }, 1000);
}

function setGood(data,type){
    goods.goods_id = data.item.itemId;
    goods.host = (data.seller.shopType == 'B') ? "https://detail.tmall.com/item.htm?id=" : "https://item.taobao.com/item.htm?id=";
    goods.goods_link = goods.host+goods.goods_id;
    if(!goods.title){
        goods.title = data.item.title;
    }
    goods.seller_id = data.seller.userId;
    var param = '';
    if(typeof data.apiStack[0].value != 'undefined' && data.apiStack[0].value !=""){
        param = JSON.parse(data.apiStack[0].value);
    }
    if(!goods.price || goods.activity_type >= 1){
        goods.price = transferPrice(getPrice(param));
    }
    goods.tao_old_price = transferPrice(getOldPrice(param));
    //goods.img = replaceReg(data.item.images[0]);
    if(param != ''){
        goods.sell_num = param.item.sellCount;
    }else {
        goods.sell_num = 0;
    }
    goods.favcount = data.item.favcount;
    if(typeof goods.quan_price != 'undefined'){
        goods.used_price = transferPrice(parseFloat(goods.price) - parseFloat(goods.quan_price));
        if(goods.used_price < 0){
            goods.used_price = goods.price;
            $(".select-coupon-caution").removeClass("hide");
        }
    }else {
        goods.used_price = goods.price;
    }

    if(typeof goods_page.quan_num != 'undefined' && (goods_page.activity_id || goods_page.activity_id == 'undefined')){
        goods.quan_num =goods_page.quan_num;
    }
    if(typeof goods_page.quan_over != 'undefined' && (goods_page.activity_id || goods_page.activity_id == 'undefined')){
        goods.quan_over =goods_page.quan_over;
    }
    goods.shopTitle = data.seller.shopName;
    goods.creditLevel = data.seller.creditLevel;

    goods_js = goods;
    //goods_js.pics = data.item.images;
    var target = $(".goods-info .goods-tit .goods-icons");
    if(data.seller.shopType == 'B'){
        goods.is_tmall = true;
        target.append('<span class="common-icons media-list-icons media-tips-icon media-list-tm-icon" data-txt="天猫"></span>');
    }else {
        goods.is_tmall = false;
        target.append('<span class="common-icons media-list-icons media-tips-icon media-list-tb-icon" data-txt="淘宝"></span>');
    }
    YuAction(param,type);
    mediaTipsIcon();
    setGoodsHtml(type);
    setFormHtml(type);
    COMMON.hws5(goods.goods_id,function(res){
        var str = res.ret[0];
        if(str.indexOf('ERRCODE_QUERY_DETAIL_FAIL') != -1){
            return ;
        }
        var data = res.data;
        goods.evaluateInfo = data.seller.evaluateInfo;
        goods.img = replaceReg(data.itemInfoModel.picsPath[0]);
        goods_js.pics = data.itemInfoModel.picsPath;
        sellerInfo();
        if(!goods.isYu){
            try{
                var param = '';
                if(typeof data.apiStack[0].value != 'undefined' && data.apiStack[0].value !=""){
                    param = JSON.parse(data.apiStack[0].value);
                }
                if(goods.price == 0 || goods.price == '0'){
                    if(param == ''){
                        window.location.href = goods_page.error_url;
                    }else {
                        goods.price = transferPrice(COMMON.hws5GetPrice(param));
                    }

                    if(typeof goods.quan_price != 'undefined'){
                        goods.used_price = transferPrice(parseFloat(goods.price) - parseFloat(goods.quan_price));
                        if(goods.used_price < 0){
                            goods.used_price = goods.price;
                            $(".select-coupon-caution").removeClass("hide");
                        }
                    }else {
                        goods.used_price = goods.price;
                    }
                }
            }catch (e){
                window.location.href = goods_page.error_url;
            }
        }
        setGoodsHtml(type);
        setFormHtml(type);
    });
}

//判断是否预售商品并执行相应操作
function YuAction(param,type){
    goods.isYu = false;
    goods.yu = 0;
    goods.di = 0;
    if(typeof param.price != 'undefined' && param.price.price!= 'undefined' && param.price.price.priceTitle!= 'undefined' && param.price.price.priceTitle == '定金'){
        if(param.price.subPrice.priceTitle == '总价'){
            goods.price = transferPrice(param.price.subPrice.priceText);
            goods.isYu = true;
            $(".goods-info .goods-area .coupon .coupon-txt").eq(0).text("到手价");
            goods.depositPrice = param.price.depositPrice.priceDesc;
            var re = /([\d\-]+).*?([\d\-]+)/;
            var arr = goods.depositPrice.match(re);
            if(transferPrice(arr[1]) > 0){
                goods.yu  = transferPrice(arr[1]);
            }
            if(transferPrice(arr[2]) > 0){
                goods.di  = transferPrice(arr[2]);
            }
            var price = transferPrice(goods.di - goods.yu);
            if(!isNaN(price) && price>0){
                $(".goods-coupon .db-trans-pre").removeClass("hide");
                $(".goods-coupon .db-trans-pre .yu").eq(0).text(goods.yu);
                $(".goods-coupon .db-trans-pre .di").eq(0).text(goods.di);
                if(typeof goods.quan_price != 'undefined'){
                    goods.used_price = transferPrice(parseFloat(goods.price) - parseFloat(goods.quan_price) - price);
                }else
                {
                    goods.used_price = transferPrice(parseFloat(goods.price) - price);
                }

            }else {
                $(".goods-coupon .db-trans-pre").remove();
            }
        }
    }

    if(goods.isYu){
        $.ajax({
            url:"/?r=transfer/s11Pre&goodsid="+goods.goods_id,
            type: 'get',
            dataType: 'json',
            timeout: 10000,
            success: function(json){
                var price = transferPrice(goods.di - goods.yu);
                if(json.status == 0){
                    if(isNaN(price) || price<= 0){
                        goods.yu = json.data.earnest;
                        goods.di = json.data.deductible;
                        price = transferPrice(goods.di - goods.yu);
                    }
                    if(json.data.quan_price >0 && !isNaN(price) && price>0){
                        goods.quan_price = transferPrice(json.data.quan_price);
                        goods.last_pay = transferPrice(parseFloat(goods.price) - parseFloat(goods.quan_price) - parseFloat(goods.di));
                        goods.sell_num = json.data.destine_number;
                        goods.quan_id = json.data.quan_id;
                        goods.seller_id = json.data.sellerid;
                        goods.quan_link = "https://shop.m.taobao.com/shop/coupon.htm?seller_id="+goods.seller_id+"&activityId="+goods.quan_id;
                        goods.used_price = transferPrice(parseFloat(goods.price) - parseFloat(goods.quan_price) - price);
                        if(json.data.yongjin > 0){
                            goods.yongjin = json.data.yongjin;
                        }
                        PRODUCT_JC.add(json.data.title,json.data.url,"&s11=1");
                        setGoodsHtml(type);
                        setFormHtml(type);
                    }else {
                        PRODUCT_JC.remove();
                    }
                }
            },
            error:function(){}
        });
    }
}
function setWwwGoods(data){
    goods_es = data;
    goods.goods_id = data.goodsid;
    goods.host = (data.is_tmall == '1') ? "https://detail.tmall.com/item.htm?id=" : "https://detail.tmall.com/item.htm?id=";
    goods.goods_link = goods.host+goods.goods_id;
    goods.title = data.title;
    goods.seller_id = data.sellerid;
    goods.is_tmall = (data.is_tmall == '1');

    //非活动商品才优先使用轻搜价格
    goods.activity_type = data.activity_type;
    goods.price = data.price;
    if(typeof data.used_price != 'undefined'&& !goods_page.activity_id){
        goods.used_price = data.used_price;
    }else {
        goods.used_price = transferPrice(parseFloat(goods.price) - parseFloat(goods_page.quan_price));
    }
    if(goods.used_price < 0){
        goods.used_price = goods.price;
    }
    if(typeof data.quan_id != 'undefined'&& !goods_page.activity_id){
        goods.is_no_quan = false;
        goods.quan_id = data.quan_id;
        goods.quan_link = "https://shop.m.taobao.com/shop/coupon.htm?seller_id="+goods.seller_id+"&activityId="+goods.quan_id;
    }else {
        goods.quan_id = goods_page.activity_id;
        goods.quan_link = "https://shop.m.taobao.com/shop/coupon.htm?seller_id="+goods.seller_id+"&activityId="+goods_page.quan_id;
    }
    if(typeof data.quan_num != 'undefined'&& (!goods_page.activity_id || goods_page.activity_id=='undefined')){
        goods.quan_num = data.quan_num;
    }else {
        goods.quan_num = goods_page.quan_num;
    }
    if(typeof data.wenan != 'undefined'){
        goods.wenan = data.wenan;
    }
    if(typeof data.yongjin != 'undefined'){
        goods.yongjin = data.yongjin;
    }
    if(typeof data.quan_over != 'undefined'&& (!goods_page.activity_id || goods_page.activity_id=='undefined')){
        goods.quan_over = data.quan_over;
    }else {
        goods.quan_over = goods_page.quan_over;
    }
    if(typeof data.quan_price != 'undefined'&& !goods_page.activity_id){
        goods.quan_price = data.quan_price;
    }else {
        goods.quan_price = goods_page.quan_price;
    }
    goods.online_num = data.online_num;
    //if(typeof data.dx != 'undefined' && !goods_page.activity_id){
    //    goods.dx = data.dx;
    //}else{
    //    goods.dx = goods_page.dx;
    //}
    goods.img = data.pic;
    goods.sell_num = data.sales_num;

    setTipHtml(data);
    mediaTipsIcon();
    //setGoodsHtml('www');
    //setFormHtml('www');
}

function setGoodsHtml(type){
    var target = $(".goods-info").eq(0);
    var tmp_img,arrLen;
    target.find(".goods-info-img a").eq(0).prop('href',goods.goods_link);
    target.find(".goods-info-img img").eq(0).prop('src',goods.img);
    if($("#spread-pic-list li").length > 0){
        $("#spread-pic-list li img").eq(0).prop('src',goods.img);
        $("#spread-pic-list li .big-pic img").eq(0).prop('src',goods.img);
    }else {
        $("#spread-pic-list").append('<li><div class="pic-box"><img src="'+goods.img+'"></div><div class="big-pic"><p>图片预览</p><img src="'+goods.img+'" alt=""></div><i class="common-icons"></i></li>');
    }
    if(type == 'js' && goods_js.pics && $("#spread-pic-list li").length < 5){
        var length = total_pic_num - $("#spread-pic-list li").length;
        if(goods_js.pics.length < length){
            arrLen = goods_js.pics.length;
        }else {
            arrLen = length;
        }
        for(var i=1;i<arrLen;i++){
            if(i>=1){
                tmp_img = replaceReg(goods_js.pics[i]);
                $("#spread-pic-list").append('<li><div class="pic-box"><img src="'+tmp_img+'"></div><div class="big-pic"><p>图片预览</p><img src="'+tmp_img+'" alt=""></div><i class="common-icons"></i></li>');
            }
        }
        picListFun();
    }
    $(".spread-main .copy-con img").attr("src", goods.img);
    target.find(".goods-area .goods-tit a").eq(0).prop('href',goods.goods_link);
    target.find(".goods-area .goods-tit .title").eq(0).text(goods.title);
    target.find(".goods-area .goods-tit .title").eq(0).attr("title", goods.title);
    //target.find(".goods-area .goods-coupon .sales .font-arial").eq(0).text(goods.sell_num);
    target.find(".goods-area .goods-coupon .old-price").eq(0).text(goods.price);
    setQuanHtml(type);
    findBetterTit(type);
    copyWenanSta(type);

    modifyYongJin();
}

function setFormHtml(type){
    var target = $("#js_detail_form");
    target.find("[name='title']").val(goods.title);
    target.find("[name='price']").val(goods.price);
    target.find("[name='sellerId']").val(goods.seller_id);
    target.find("[name='sell_num']").val(goods.sell_num);
    var img = target.find("[name='imageSrc']").val();
    if(type!=='cj' && img==''){
        target.find("[name='imageSrc']").val(goods.img);
    }
    if(typeof goods.quan_id != 'undefined'){
        target.find("[name='activityId']").val(goods.quan_id);
    }
    if(target.find("[name='activityId']").val() == 'c4ca4238a0b923820dcc509a6f75849b'){
        target.find("[name='activityId']").val("undefined");
    }
    if(target.find("[name='activityId']").val() == ''){
        target.find("[name='activityId']").val("none");
    }
    if(typeof goods.price != 'undefined'){
        target.find("[name='price']").val(goods.price );
    }
    if(typeof goods.used_price != 'undefined'){
        target.find("[name='used_price']").val(goods.used_price );
    }
    //if(typeof goods.dx != 'undefined'){
    //    target.find("[name='dx']").val(goods.dx );
    //}
    if(typeof goods.wenan != 'undefined'){
        target.find("[name='wenan']").val(goods.wenan );
    }
    if(typeof goods.quan_price != 'undefined'){
        target.find("[name='quan_price']").val(goods.quan_price );
    }
}

function getPrice(param){
    try{
        if(typeof param.price.price.priceText != 'undefined' && parseFloat(param.price.price.priceText) > 0){
            return param.price.price.priceText;
        }
    }catch (e){

    }

    return "0";
}

//更多标题右侧展开 5-10
function moreCopy() {
    var sta = false;
    $("#spread-copy-more span").text($(".spread-comm-tit .more-opts p").length);
    $(".spread-comm-tit .more").on("mouseenter", function () {
        sta = true;
        $(this).parents(".spread-comm-tit").find(".more-opts").show();
    });
    $(".spread-comm-tit .more-opts").hover(function () {
        sta = false;
    },function () {
        sta = true;
        $(this).parents(".spread-comm-tit").find(".more-opts").hide();
    });
    $(".spread-comm-tit .more").on("mouseleave", function () {
        setTimeout(function () {
            if(sta) {
                $("#spread-copy-more-opts").hide();
            }
        },150);
    });
    $(".spread-comm-tit .more-opts p").on("click", function () {
        $(".spread-con .copy-options p").removeClass("active");
        $(this).addClass("active").siblings().removeClass("active");
        $("#js_detail_form input[name='wenan']").val($(this).find("span").text());
        $(".copy-main .copy-con .today").text($(this).find("span").text());
        $(this).parents(".more-opts").hide();
        //修改转长图为已修改
        longPicChangeSta = true;
        setDefaultCode();
    });
}

//选择优质文案
function selectCopyTxt() {
    $(".copy-options p").on("click", function (){
        $(".spread-con .copy-options p").removeClass("active");
        $(this).addClass("active").siblings().removeClass("active");
        $("#js_detail_form input[name='wenan']").val($(this).find("span").text());
        $(".copy-main .copy-con .reason").text($(this).find("span").text());
        //修改转长图为已修改
        longPicChangeSta = true;
        setDefaultCode();
    });
}

//优质标题下拉
function moreNewTitle() {
    $(".goods-area .find-title").on("mouseenter", function () {
        if($(this).find(".options-titles p").length != 0) {
            $(this).find(".options-titles").show();
        }
    });
    $(".goods-area .find-title").on("mouseleave", function () {
        $(this).find(".options-titles").hide();
    });
    $(".goods-area .options-titles p").on("click", function () {
        $(this).addClass("active").siblings().removeClass("active");
        $(".goods-tit .title").text($(this).find("span").text());
        $("#js_detail_form input[name='title']").val($(this).find("span").text());
        $(".copy-main .copy-con .today").text($(this).find("span").text());
        $(".goods-area .options-titles").hide();
        //修改转长图为已修改
        longPicChangeSta = true;
        setDefaultCode();
    });
}

//PID下拉
function pidSlideDown() {
    $(".copy-box .copy-comm-head").on("mouseenter", function () {
        if($(this).find(".pid-options li").length > 0) {
            $(this).find(".pid-options").show();
            if($(".pid-options").height() >= 160) {
                $(".pid-options").css("overflow-y", "scroll").css("height", "155px");
            }
        }
        if($(this).find(".un-login").text().length > 0) {
            $(this).find(".un-login").show();
        }
    });
    $(".copy-box .copy-comm-head").on("mouseleave", function () {
        $(this).find(".pid-options, .un-login").hide();
    });
    $("body").on("click", ".copy-box .pid-options li", function () {
        var par = $(this).parents(".copy-box");
        var old_pid = $.trim(par.find(".copy-comm-head .selected-pid .pid-number").text());
        var old_name = $.trim(par.find(".copy-comm-head .selected-pid .pid-name").text());
        var new_pid =$.trim($(this).find(".pid-number").text());
        var new_name =$.trim($(this).find(".pid-name").text());
        par.find(".copy-comm-head .selected-pid .pid-name").text(new_name);
        par.find(".copy-comm-head .selected-pid .pid-number").text(new_pid);
        if(par.hasClass("q-area")) {
            par.find(".selected-pid a").addClass("hide");
            $("#js_user_form input[name='qq_pid']").val(new_pid);
            $("#q-before-btn").removeClass("hide");
            $("#q-copy-btn").addClass("hide");
            addPidItemLi($(this).parents(".qq-head").find(".pid-options"),old_name,old_pid);
        } else {
            par.find(".selected-pid a").addClass("hide");
            $("#js_user_form input[name='wx_pid']").val(new_pid);
            $("#wx-before-btn").removeClass("hide");
            $("#wx-copy-btn").addClass("hide");
            $("#create-pic-view-area").data("ready",'fall');
            //修改转长图为已修改
            longPicChangeSta = true;
            addPidItemLi($(this).parents(".wx-area").find(".pid-options"),old_name,old_pid);
        }
        $(".copy-box .copy-comm-head .pid-options").hide();
    });
}

function addPidItemLi(obj , old_name , old_pid){
    if(!OBJ_EDIT_PID.check_pid(old_pid)){
        return;
    }
    var lis = obj.find(".pid-number");
    if(lis.length <= 0){
        return;
    }
    for (var i=0;i<lis.length; i++){
        if($.trim(lis.eq(i).text()) == old_pid){
            return;
        }
    }
    obj.append('<li class="common-bd-xCtJ-count"><span class="pid-name">'+old_name+'</span> | <span class="pid-number">'+old_pid+'</span></li>');
}

//选择图片
function picListFun() {
    var target = $(".pic-list li");
    target.on("click", function () {
        $(this).addClass("active").siblings().removeClass("active");
        $(".copy-main .copy-con img").attr("src", $(this).find("img").attr("src"));
        $("#js_detail_form input[name='imageSrc']").val($(this).find("img").attr("src"));
        setDefaultCode();
        //修改转长图为已修改
        longPicChangeSta = true;
    });
    target.eq(0).click();
    function is_qq(src){
        var par = /thumbnail.qingtaoke.com/;
        return par.test(src);
    }
    setTimeout(function(){
        var target = $(".pic-list li");
        var num = target.length;
        var i = 0;

        if(num >= 6){
            for(i=0;i<num ;i++){
                if(is_qq(target.eq(i).find("img").prop("src"))){
                    target.eq(i).click();
                    break;
                }

            }
        }
    },1000);
}

function getOldPrice(param){
    try{
        if(typeof param.price.extraPrices[0].priceText != 'undefined' && parseFloat(param.price.extraPrices[0].priceText) > 0){
            return param.price.extraPrices[0].priceText;
        }

        if(typeof param.price.newExtraPrices[0].priceText != 'undefined' && parseFloat(param.price.newExtraPrices[0].priceText) > 0){
            return param.price.newExtraPrices[0].priceText;
        }
    }
    catch (e){

    }
    return '0';
}

//模板编辑功能
function tplEditFun(closeEdit) {
    // 定义最后光标对象
    var lastEditRange = 0;
    var selection;
    var imgMsg;
    //编辑框点击事件
    var editTplContentEle, txtArea;
    if(setTplInd == 0) {
        editTplContentEle = ".transfer-set-tpl .transfer-qq-tpl";
    } else if (setTplInd == 1) {
        editTplContentEle = ".transfer-set-tpl .transfer-wx-tpl";
    } else if (setTplInd == 2) {
        editTplContentEle = ".transfer-set-tpl .transfer-coupon-tpl";
    } else if (setTplInd == 3) {
        editTplContentEle = ".transfer-set-tpl .transfer-pic-tpl";
    }
    var tplLabelAEle = $(".transfer-set-tpl .transfer-tpl-label a");
    $(editTplContentEle).on("click", function () {
        // 获取选定对象
        selection = getSelection();
        // 设置最后光标对象
        lastEditRange = selection.getRangeAt(0);
    });

    //编辑框按键弹起事件
    $(editTplContentEle).on("keyup", function () {
        // 获取选定对象
        selection = getSelection();
        // 设置最后光标对象
        lastEditRange = selection.getRangeAt(0);
    });

    //解除事件绑定
    tplLabelAEle.unbind();

    //点击事件
    tplLabelAEle.on("click", function () {
        //获取输入框
        if(setTplInd == 0) {
            txtArea = $(".transfer-set-tpl .transfer-qq-tpl")[0];
        } else if(setTplInd == 1) {
            txtArea = $(".transfer-set-tpl .transfer-wx-tpl")[0];
        } else if( setTplInd == 2) {
            txtArea = $(".transfer-set-tpl .transfer-coupon-tpl")[0];
        } else if( setTplInd == 3) {
            txtArea = $(".transfer-set-tpl .transfer-pic-tpl")[0];
        }
        //var regExp = new RegExp($(this).text()); //限制所有
        var regExp = new RegExp("{图片}"); //只限制图片
        var content = txtArea.value;
        layer.close(imgMsg);
        if(regExp.exec(content) && $(this).index() == 0) {
            imgMsg = layer.msg("图片变量只能用一次");
            return;
        }
        var start = txtArea.selectionStart; //初始位置
        txtArea.value = content.substring(0, txtArea.selectionStart) + $(this).text() + content.substring(txtArea.selectionEnd, content.length);
        var position = start + $(this).text().length;
        if(setTplInd == 0) {
            $(".transfer-set-tpl .transfer-qq-tpl").focus();
        } else if(setTplInd == 1) {
            $(".transfer-set-tpl .transfer-wx-tpl").focus();
        } else if( setTplInd == 2) {
            $(".transfer-set-tpl .transfer-coupon-tpl").focus();
        } else if( setTplInd == 3) {
            $(".transfer-set-tpl .transfer-pic-tpl").focus();
        }
        txtArea.setSelectionRange(position, position);
    });
}

function isAli($qid) {
    if($qid == 'c4ca4238a0b923820dcc509a6f75849b'){
        return true;
    }

    return false;
}

function setQuanHtml(type){
    var target = $(".goods-info").eq(0);
    if(typeof goods.quan_id != 'undefined' && !goods_page.activity_id){
        target.find(".goods-area .goods-coupon .coupon-price").eq(0).text(goods.used_price);
    }else {
        if(typeof goods.used_price != 'undefined'){
            target.find(".goods-area .goods-coupon .coupon-price").eq(0).text(goods.used_price);
        }else {
            target.find(".goods-area .goods-coupon .coupon-price").eq(0).text("");
        }
        if(goods_page.activity_id && type == 'js'){
            var used_price = transferPrice(parseFloat(goods.price) - parseFloat(goods_page.quan_price));
            if((used_price > 0) && (goods_page.t == 1 || (goods.price>=goods_page.m && goods_page.m>0))){
                goods.m = goods_page.m;
                goods.used_price = used_price;
            }else {
                goods.used_price = transferPrice(parseFloat(goods.price));
                $(".select-coupon-caution").removeClass("hide");
            }
            target.find(".goods-area .goods-coupon .coupon-price").eq(0).text(goods.used_price);
            $("#js_detail_form input[name='used_price']").val(goods.used_price);
            if(goods_page.quan_price){
                goods.quan_price = goods_page.quan_price;
            }
        }
    }

    var quan = $(".js_quan");
    var width;

    if(type=='www' && goods_page.activity_id && goods.seller_id){
        if(isAli(goods_page.activity_id)){
            goods.quan_link = 'http://pub.alimama.com/promo/search/index.htm?q=' + encodeURIComponent(goods.host + goods.goods_id)+"&yxjh=-1";
        }else{
            goods.quan_link = "https://shop.m.taobao.com/shop/coupon.htm?seller_id="+goods.seller_id+"&activityId="+goods_page.activity_id;
        }
        quan.find("a").eq(0).prop("href",goods.quan_link);
    }
    if((type=='js'||type=='www') && goods_page.quan_price && !goods.quan_price){
        goods.quan_price = goods_page.quan_price;
    }
    if(cj_select_quan||goods_page.activity_id){
        quanFun.show();
    }
    if(typeof goods.quan_id != 'undefined' && (type!='www' || (type=='www' && !goods_page.activity_id) )){

        if(isAli(goods.quan_id)){
            goods.quan_link = 'http://pub.alimama.com/promo/search/index.htm?q=' + encodeURIComponent(goods.host + goods.goods_id)+"&yxjh=-1";
        }else{
            goods.quan_link = "https://shop.m.taobao.com/shop/coupon.htm?seller_id="+goods.seller_id+"&activityId="+goods.quan_id;
        }

        quan.find("a").eq(0).prop("href",goods.quan_link)
            .removeClass("media-tips-icon-click");
        quan.find("a i").eq(0).text(goods.quan_price);
        quan.find(".media-coupon-box .js_quan_num").eq(0).text(goods.quan_over);
        quan.find(".media-coupon-box .js_quan_over").eq(0).text(parseInt(goods.quan_over)+parseInt(goods.quan_num));
        width = parseInt(goods.quan_over)*100/(parseInt(goods.quan_over)+parseInt(goods.quan_num));
        quan.find(".media-coupon-box .media-top-coupon-line i").eq(0).css("width",width+"%");
        quanFun.show();
    }
    if((typeof goods.quan_id == 'undefined') && (type=='qq' ||  type=='wx' || goods_page.activity_id=='undefined')){
        quan.find("a").eq(0).prop("href",'javascript:;')
            .attr("data-txt","阿里妈妈优惠券无法单独领取，请转链后到二合一页面领取")
            .attr("data-left","280")
            .addClass("media-tips-icon-click");
        quan.find("a i").eq(0).text(goods.quan_price);
        quan.find(".media-coupon-box .js_quan_num").eq(0).text(goods.quan_over);
        quan.find(".media-coupon-box .js_quan_over").eq(0).text(parseInt(goods.quan_over)+parseInt(goods.quan_num));
        width = parseInt(goods.quan_over)*100/(parseInt(goods.quan_over)+parseInt(goods.quan_num));
        quan.find(".media-coupon-box .media-top-coupon-line i").eq(0).css("width",width+"%");
        if(!goods.is_no_quan){
            quanFun.show();
        }
        mediaTipsIcon();
    }
    modifyYongJin();
}

function getHws(gid,ok){
    //先尝试走h6接口，若失败，则改为h5接口
    COMMON.hws6(gid,function(res){
        var str = res.ret[0];
        if(str.indexOf('ERRCODE_QUERY_DETAIL_FAIL') != -1){
            window.location.href = goods_page.error_url;
            return ;
        }
        try{
            goods.goods_id = res.data.item.itemId
        }catch (e){
            window.location.href = goods_page.error_url;
            return ;
        }
        $(".goods-seller-info").show();
        mainShow();
        setGood(res.data,'js');
        $(document).trigger("turn");
        $("#qtk_flagship_version").trigger("click");
        setDefaultCode('create');
    },function(){
        goods.shopTitle = "店铺信息";
        if(!ok){
            $.ajax({
                url:"/?r=transfer/s11Pre&goodsid="+gid,
                type: 'get',
                dataType: 'json',
                timeout: 10000,
                success: function(json){
                    var price = 0;
                    if(json.status == 0){
                        goods.isYu = true;
                        goods.goods_id = gid;
                        goods.yu = parseFloat(json.data.earnest);
                        goods.di = parseFloat(json.data.deductible);
                        goods.host = "https://detail.tmall.com/item.htm?id=";
                        goods.goods_link = goods.host+goods.goods_id;
                        $(".goods-coupon .db-trans-pre .yu").eq(0).text(goods.yu);
                        $(".goods-coupon .db-trans-pre .di").eq(0).text(goods.di);
                        $(".goods-coupon .db-trans-pre").removeClass("hide");
                        price = transferPrice(goods.di - goods.yu);
                        if(json.data.quan_price >0 && !isNaN(price) && price>0){
                            $(".goods-info .goods-area .coupon .coupon-txt").eq(0).text("到手价");
                            goods.quan_price = transferPrice(json.data.quan_price);
                            goods.price = transferPrice(json.data.price);
                            goods.title = json.data.title;
                            goods.img = json.data.pic;
                            goods.last_pay = transferPrice(parseFloat(goods.price) - parseFloat(goods.quan_price) - parseFloat(goods.di));
                            goods.sell_num = json.data.destine_number;
                            goods.quan_id = json.data.quan_id;
                            goods.seller_id = json.data.sellerid;
                            goods.quan_link = "https://shop.m.taobao.com/shop/coupon.htm?seller_id="+goods.seller_id+"&activityId="+goods.quan_id;
                            goods.used_price = transferPrice(parseFloat(goods.price) - parseFloat(goods.quan_price) - price);
                            if(json.data.yongjin > 0){
                                goods.yongjin = json.data.yongjin;
                            }
                            PRODUCT_JC.add(json.data.title,json.data.url,"&s11=1");
                            mainShow();
                            setGoodsHtml('s11');
                            setFormHtml('s11');
                            setDefaultCode('create');
                        }else {
                            PRODUCT_JC.remove();
                        }
                    }else {
                        window.location.href = goods_page.error_url;
                    }
                },
                error:function(){}
            });
        }else {
            setGoodsHtml('www');
            setFormHtml('www');
            sellerInfo();
            var target = $(".goods-info .goods-tit .goods-icons");
            if(goods.is_tmall){
                target.append('<span class="common-icons media-list-icons media-tips-icon media-list-tm-icon" data-txt="天猫"></span>');
            }else {
                target.append('<span class="common-icons media-list-icons media-tips-icon media-list-tb-icon" data-txt="淘宝"></span>');
            }
        }

    });
}

function setGetTpl() {
    $(".transfer-set-tpl .transfer-wx-tpl").val($("#wx_code").val());
    $(".transfer-set-tpl .transfer-qq-tpl").val($("#qq_code").val());
    $(".transfer-set-tpl .transfer-coupon-tpl").val($("#none_code").val());
    $(".transfer-set-tpl .transfer-pic-tpl").val($("#long_pic").val());
}

function setTipHtml(data){
    var target = $(".goods-info .goods-tit .goods-icons");
    target.find("span").remove();
    if(data.is_jyj == 1){
        target.append('<span class="common-icons media-list-icons media-tips-icon media-list-jyj-icon" data-txt="极有家"></span>');
    }

    if(data.is_yfx == 1){
        target.append('<span class="common-icons media-list-icons media-tips-icon media-list-xian-icon" data-txt="赠运费险"></span>');
    }
    if(data.is_herald_ju == 1){
        target.append('<span class="common-icons media-list-icons media-tips-icon media-list-notice-icon" data-txt="聚划算预告"></span>');
    }
    if(data.is_xinpin == 1){
        target.append('<span class="common-icons media-list-icons media-tips-icon media-list-today-icon" data-txt="今日新品"></span>');
    }
    if(data.is_ju == 1){
        target.append('<span class="common-icons media-list-icons media-tips-icon media-list-ju-icon" data-txt="聚划算"></span>');
    }
    if(data.is_tqg == 1){
        target.append('<span class="common-icons media-list-icons media-tips-icon media-list-qiang-icon" data-txt="淘抢购"></span>');
    }
    if(data.is_ht == 1){
        target.append('<span class="common-icons media-list-icons media-tips-icon media-list-ht-icon" data-txt="海淘"></span>');
    }
    if(data.is_gold == 1){
        target.append('<span class="common-icons media-list-icons media-tips-icon media-list-gold-icon" data-txt="金牌卖家"></span>');
    }
    if(data.is_activity_s12 == 1){
        target.append('<span class="common-icons media-list-icons media-tips-icon media-list-s12-icon" data-txt="1212狂欢"></span>');
    }
}

//四舍五入末尾去0
function transferPrice(num , index) {
    var newNum;
    if(!index){
        index = 2
    }
    num = parseFloat(num);
    newNum = Number(num.toFixed(index));
    return newNum;
}

function setCode(type,flag){
    var str;
    if((goods_page.tao_code && goods_page.quan_has=='0') || goods.is_no_quan){
        str =getNoneTpl();
    }else {
        str=getHasTpl(type);
    }
    //优先使用双十一预售模板
    if(goods.isYu){
        str = getYuTpl(type);
    }
    if(!str){
        return;
    }
    str = str.replace(/\<s/g, '＜s');
    str = str.replace(/\<S/g, '＜S');
    str = str.replace(/\<a/g, '＜a');
    str = str.replace(/\<A>/g, '＜A');
    str = str.replace(/内部/g, '');

    //尾款
    if(typeof goods.last_pay != 'undefined'){
        str = str.replace(/\{尾款\}/g,goods.last_pay);
    }
    //定金
    if(typeof goods.yu != 'undefined'){
        str = str.replace(/\{定金\}/g,goods.yu);
    }
    //抵扣
    if(typeof goods.di != 'undefined'){
        str = str.replace(/\{抵扣金额\}/g,goods.di);
    }

    //判断标题无内容时去掉
    var title = $("#js_detail_form input[name='title']").val();
    if(title.length >= 1) {
        str = str.replace(/\{标题\}/g, title);
    } else {
        str = str.replace(/\{标题\}\n/g, "<span>{标题}</span>");
    }
    var img = $("#js_detail_form input[name='imageSrc']").val();
    if(type == "wx_code") {
        str = str.replace(/\{图片\}/g,'<span>{图片}</span>');
    } else {
        str = str.replace(/\{图片\}/g,'<img src="'+img+'" alt="'+title+'">');
    }
    var used_price = $("[name='used_price']").val();
    if(used_price){
        str = str.replace(/\{券后价\}/g, used_price);
    }else {
        str = str.replace(/\{券后价\}/g, '<span>{券后价}</span>');
    }

    if(goods.quan_price){
        str = str.replace(/\{优惠券面额\}/g, goods.quan_price);
    }else {
        str = str.replace(/\{优惠券面额\}/g, '<span>{优惠券面额}</span>');
    }
    //判断推广文案无内容时去掉
    var wenan = $("[name='wenan']").val();
    if(wenan.length > 0) {
        str = str.replace(/\{推广文案\}/g, wenan);
    } else {
        str = str.replace(/\{推广文案\}/g, "<span>{推广文案}</span>");
    }

    str = str.replace(/\{短连接\}/g, "{短链接}");
    var s_url =  sUrl(type);
    if(type == 'qq_code'){
        if(s_url.length > 0){
            str = str.replace(/\{短链接\}/g, "：<a href='" + s_url + "' rel='nofollow' target='_blank'>" + s_url + "</a>");
        }else{
            str = str.replace(/\{短链接\}/g, "<span>{短链接}</span>");
        }
    }else {
        str = str.replace(/\{短链接\}/g, "");
    }
    var code =  taoCode(type);
    if(code.length > 0){
        str = str.replace(/\{淘口令\}/g, code);
    }else{
        str = str.replace(/\{淘口令\}/g, "<span>{淘口令}</span>");
    }

    var emojicode = emojiCode(type);
    if(emojicode.length > 0){
        str = str.replace(/\{多符号淘口令\}/g, emojicode);
    }else{
        str = str.replace(/\{多符号淘口令\}/g, "<span>{多符号淘口令}</span>");
    }

    str = str.replace(/\{商品价格\}/g, goods.price);
    if(typeof goods.tao_old_price != 'undefined'&& typeof goods.tao_old_price > 0 ){
        str = str.replace(/\{折扣\}/g, Number((parseFloat(goods.price)*10/parseFloat(goods.tao_old_price)).toFixed(1))+"折");
    }else {
        str = str.replace(/\(\{折扣\}\)/g, "");
        str = str.replace(/\（\{折扣\}\）/g, "");
        str = str.replace(/\{\{折扣\}\}/g, "");
        str = str.replace(/\[\{折扣\}\]/g, "");
        str = str.replace(/\【\{折扣\}\】/g, "");
        str = str.replace(/\{折扣\}/g, "");
    }

    var sellNum = $("[name='sell_num']").val();
    if(sellNum.length > 0) {
        str = str.replace(/\{月销量\}/g, $("[name='sell_num']").val());
    } else {
        str = str.replace(/\{月销量\}/g, "<span>{月销量}</span>");
    }

    str = str.replace(/\{商品链接\}/g, "<a href='" + goods.goods_link + "' rel='nofollow' target='_blank'>" + goods.goods_link + "</a>");

    if(goods.quan_link != undefined && goods.quan_link != "" && goods.quan_link != null && !isAli(goods.quan_id)) {
        str = str.replace(/\{领券链接\}/g, "<a href='" + goods.quan_link + "' rel='nofollow' target='_blank'>" + goods.quan_link + "</a>");
    } else {
        str = str.replace(/\{领券链接\}/g, "<span></span>");
    }

    str = str.replace("<span>{图片}<\/span><br\/>", "").replace(/\n/g, "<br/>");
    return str.replace(/^<br\/>/,"");
}

function sUrl(type){
    if(type == 'wx_code' && typeof links_wx.s_click_link != 'undefined'){
        return links_wx.s_click_link;
    }
    if(type == 'qq_code' && typeof links_qq.s_click_link != 'undefined'){
        return links_qq.s_click_link;
    }
    return "";
}

function taoCode(type){
    if(type == 'wx_code' && typeof links_wx.tao_code != 'undefined'){
        return links_wx.tao_code;
    }
    if(type == 'qq_code' && typeof links_qq.tao_code != 'undefined'){
        return links_qq.tao_code;
    }
    return "";
}

function emojiCode(type){
    if(type == 'wx_code' && typeof links_wx.emojicode != 'undefined'){
        return links_wx.emojicode;
    }
    if(type == 'qq_code' && typeof links_qq.emojicode != 'undefined'){
        return links_qq.emojicode;
    }
    return "";
}

function setDefaultCode(flag){
    var str;
    str = setCode('wx_code',flag);
    $(".wx-area .copy-con-area").html(str.replace("<span>{图片}</span><br/>",""));
    str = setCode('qq_code',flag);
    $(".q-area .copy-con-area").html(str);
}

function mainShow(){
    $(".transfer").eq(0).removeClass("hide");
    $("footer").removeClass("hide");
}

function getHasTpl(type){
    var str;
    if(type == 'wx_code'){
        if(!$.trim($("#wx_code").val())) {
            str = default_wx_code.replace(/\n/g,"<br/>");
        } else {
            str = $("#wx_code").val().replace(/\n/g,"<br/>");
        }
    }else if(type == 'qq_code'){
        if(!$.trim($("#qq_code").val())) {
            str = default_qq_code.replace(/\n/g,"<br/>");
        } else {
            str = $("#qq_code").val().replace(/\n/g,"<br/>");
        }
    }
    return str;
}

function getYuTpl(type){
    var str = '';
    if(type != 'wx_code'){
        str = '{图片}<br />';
    }
    return str + '{标题}<br />\
双十一预售价{商品价格}元，定金{定金}元抵{抵扣金额}元<br />\
领券再减{优惠券面额}元<br />\
尾款仅需付【{尾款}元】<br />\
专享优惠！已定购{月销量}件<br />\
商品链接{短链接}；或复制这条信息{淘口令}，打开☞手机淘宝☜即可查看并下单！';
}

function getNoneTpl(){
    var str;
    if(!$.trim($("#none_code").val())) {
        str = default_coupon_code.replace(/\n/g,"<br/>");
    } else {
        str = $("#none_code").val().replace(/\n/g,"<br/>");
    }
    return str;
}

function quanItem(){
    return {
        show:function(){
            $(".goods-info .goods-area .coupon-box > div:not(#transfer-plugin-coupon,.hide)").addClass("hide");
            $(".goods-info .goods-area .coupon-box .have-quan-info").removeClass("hide");
            $(".goods-info .goods-area .coupon-box .have-quan-info .js_quan").removeClass("hide");
            goods.is_no_quan = false;
        },
        hide:function(){
            $(".goods-info .goods-area .coupon-box > div:not(#transfer-plugin-coupon,.hide)").addClass("hide");
            $(".goods-info .goods-area .coupon-box .coupon-loading").removeClass("hide");
        },
        find:function(){
            $(".goods-info .goods-area .coupon-box > div:not(#transfer-plugin-coupon,.hide)").addClass("hide");
            $(".goods-info .goods-area .coupon-box .find-better-coupon").removeClass("hide");
        },
        none:function(){
            $(".goods-info .goods-area .coupon-box > div:not(#transfer-plugin-coupon,.hide)").addClass("hide");
            $(".goods-info .goods-area .coupon-box .js_quan_none").removeClass("hide");
            goods.is_no_quan = true;
        }
    }
}

function replaceReg(str,reg){
    if(!reg){
        reg = /[A-Z]/g;
    }
    str = str.replace(reg,function(m){return "*" + m.toLowerCase()}) + "_310x310.jpg";
    str = str.replace(/(\w*.(?:alicdn.com|tbcdn.cn|taobaocdn.com))/g, "imgproxy.qingtaoke.com");
    if(str.indexOf("//") == 0){
        str = "http:"+str;
    }
    return str;
}

function noneQuan(gid){
    layer.open({
        type: 1,
        skin: 'qtk-set-pid transfer-none-coupon',
        area: ['400px', '160px'],
        title: "提示",
        shadeClose: true, //点击遮罩关闭
        content: "<div class='content'>无券商品请使用 <a href='http://pub.alimama.com/promo/search/index.htm?queryType=2&q=https%3A%2F%2Fdetail.tmall.com%2Fitem.htm%3Fid%3D" + gid + "&yxjh=-1' rel='nofollow'>淘宝联盟官方转链</a></div>",
        success: function () {
            $(".transfer-none-coupon .content a").on("click", function () {
                layer.closeAll();
            });
        }
    });
}

function modifyYongJin(){
    var arr,head,back,yongjin,y;
    var target = $(".goods-info").eq(0);
    if(typeof goods.yongjin != 'undefined'){
        yongjin = goods.yongjin;
        arr = yongjin.split(".");
        head = arr[0];
        if(typeof arr[1] != 'undefined'){
            back = '.'+arr[1]+"%";
        }else {
            back = "%";
        }
        //target.find(".goods-area .goods-coupon .commission .num").eq(0).text(head);
        //target.find(".goods-area .goods-coupon .commission .txt").eq(0).text(back);
        target.find('.goods-content .percent .font-arial').eq(0).text(head+back);
        if(typeof goods.used_price != 'undefined'){
            y = transferPrice(parseFloat(goods.yongjin) * goods.used_price/100,1);
        }else {
            y = transferPrice(parseFloat(goods.yongjin) * goods.price/100,1);
        }
        target.find(".goods-content .brokerage .font-arial").eq(0).html("&yen; " + y);
    }

    if(typeof goods.favcount != 'undefined'){
        target.find(".goods-content .collection .font-arial").eq(0).text(goods.favcount);
    }

    if(typeof goods.sell_num != 'undefined'){
        target.find(".goods-content .sales .font-arial").eq(0).text(goods.sell_num);
    }
    if(typeof goods.online_num != 'undefined' && goods.online_num > 0){
        target.find(".goods-coupon .online-num em").eq(0).text(goods.online_num);
    }else {
        target.find(".goods-coupon .online-num").eq(0).remove();
    }
}

function sellerInfo(){
    var target = $(".goods-info .goods-seller-info");
    if(typeof goods.shopTitle!= 'undefined'){
        target.find(".title p.fl").eq(0).text(goods.shopTitle);
    }
    if(goods.is_tmall == 1){
        target.find('.shop-years').removeClass("hide");
        target.find('.comment').addClass("hide");
    }else {
        target.find('.shop-years').addClass("hide");
        target.find('.comment').removeClass("hide");
    }
    if(typeof goods.evaluateInfo != 'undefined'){
        for(var i in goods.evaluateInfo){
            if(goods.evaluateInfo[i].title == '描述相符'){
                target.find(".comprehensive .cate .desc span").eq(0).text(goods.evaluateInfo[i].score);
                target.find(".comprehensive .percent .desc span").eq(0).text(transferHeiLow.percent(goods.evaluateInfo[i].highGap));
                var level = transferHeiLow.level(goods.evaluateInfo[i].highGap);
                target.find(".comprehensive .percent .desc b").eq(0).text(level);
                target.find(".comprehensive .percent .desc em, .comprehensive .percent .desc span").addClass(transferHeiLow.cls(level));
            }

            if(goods.evaluateInfo[i].title == '服务态度'){
                target.find(".comprehensive .cate .server span").eq(0).text(goods.evaluateInfo[i].score);
                target.find(".comprehensive .percent .server span").eq(0).text(transferHeiLow.percent(goods.evaluateInfo[i].highGap));
                var level = transferHeiLow.level(goods.evaluateInfo[i].highGap);
                target.find(".comprehensive .percent .server b").eq(0).text(level);
                target.find(".comprehensive .percent .server em, .comprehensive .percent .server span").addClass(transferHeiLow.cls(level));
            }

            if(goods.evaluateInfo[i].title == '发货速度'){
                target.find(".comprehensive .cate .speed span").eq(0).text(goods.evaluateInfo[i].score);
                target.find(".comprehensive .percent .speed span").eq(0).text(transferHeiLow.percent(goods.evaluateInfo[i].highGap));
                var level = transferHeiLow.level(goods.evaluateInfo[i].highGap);
                target.find(".comprehensive .percent .speed b").eq(0).text(level);
                target.find(".comprehensive .percent .speed em, .comprehensive .percent .speed span").addClass(transferHeiLow.cls(level));
            }
        }
    }

    if(typeof goods.creditLevel!= 'undefined'){
        var level = parseInt(goods.creditLevel);
        if(level%5 == 0){
            $("#seller-credit-level").html(transferSellerLevel.create(parseInt(level/5),5));
        }else {
            $("#seller-credit-level").html(transferSellerLevel.create(parseInt(level/5+1),level%5));
        }

    }

    COMMON.goodsInfo(goods.goods_id,function(info){
        if(typeof info.data.shop_year != 'undefined' && info.data.shop_year>=2){
            target.find(".shop-years .icon-years").html(info.data.shop_year);
            target.find(".shop-years .shop span").eq(0).html(info.data.shop_year);
        }

        if(typeof info.data.bad_comment != 'undefined'){
            target.find(".comment .bad span").eq(0).html(info.data.bad_comment);
        }
        if(typeof info.data.good_comment != 'undefined'){
            target.find(".comment .good span").eq(0).html(info.data.good_comment);
        }
        if(typeof info.data.in_comment != 'undefined'){
            target.find(".comment .mid span").eq(0).html(info.data.in_comment);
        }

        if(typeof info.data.shop_type != 'undefined' && info.data.shop_type != '' && info.data.shop_type ){
            target.find(".comprehensive .tit span").eq(0).html(info.data.shop_type);
        }
    });
}