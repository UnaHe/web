/**
 * Created by Leester on 2016/11/21.
 */
var user_login = false;
var ClipboardSupport = 0;
var globalQingSouSearchSta = null;
var globalTransferFromSta = null;
var urlTitReg = new RegExp("&title=");
var andReg = new RegExp("&");
var wsCache = new WebStorageCache();
    var nextYear = new Date();
nextYear.setFullYear(nextYear.getFullYear() + 1);
var global_user_pids = {
    qq_key:"global_user_pids_qq",
    wx_key:"global_user_pids_wx",
    tao_name:'global_user_pids_tao_name',
    set_tao:function(val){
        //设置授权的id
        localStorage.setItem(this.tao_name, val);
    },
    get_tao:function(){
        var result = localStorage.getItem(this.tao_name);
        return (result == 'null' || result=='') ? '' : result;
    },
    key:function(key){
        //根据淘宝name生成key
        var result = localStorage.getItem(this.tao_name);
        result = (result == 'null' || result=='')? "" : result;
        return key+result;
    },
    get:function(type){
        var result;
        if(type == 'wx_pid'){
            result = localStorage.getItem(this.key(this.wx_key));
        }else {
            result = localStorage.getItem(this.key(this.qq_key));
        }
        if(result == 'null' || result==''){
            return '';
        }
        return result;
    },
    set:function(type , val){
        if(typeof val == 'undefined' || val == null || val == 'null' ){
            val = "";
        }
        if(type == 'wx_pid'){
            localStorage.setItem(this.key(this.wx_key), val);
        }else {
            localStorage.setItem(this.key(this.qq_key), val);
        }
    },
    clear: function (type) {
        if(type == 'wx_pid'){
            localStorage.clear(this.key(this.wx_key));
        }else {
            localStorage.clear(this.key(this.qq_key));
        }
    },
    init:function(Fun){
        var ths = this;
        if(!this.get('wx_pid') || !this.get('qq_pid') || (this.get_tao() == '')){
            $.ajax({
                url:"/index.php?r=userCenter/getPids",
                method : 'GET',
                dataType:'json',
                timeout : 10000,
                success : function (json) {
                    if(json.status == 0 && json.data.id){
                        ths.set_tao(json.data.id);
                        if(!ths.get('wx_pid')){
                            ths.set('wx_pid',json.data.wx_pid);
                        }
                        if(!ths.get('qq_pid')){
                            ths.set('qq_pid',json.data.qq_pid);
                        }
                        Fun();
                    }
                }
            });
        }else {
            Fun();
        }
    }
};

var COMMON = {
    isEmail:function(email){
        var p = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9-][a-zA-Z0-9.-]*\.[a-zA-Z]{2,6}$/;
        return p.test(email);
    },
    hws6:function(goodsid,callback,err){
        $.ajax({
            url:'https://acs.m.taobao.com/h5/mtop.taobao.detail.getdetail/6.0/?data=%7B"itemNumId"%3A"'+goodsid+'"%7D',
            method : 'GET',
            dataType: 'jsonp',
            timeout : 30000,
            success : function (json) {
                callback(json);
            },
            error:err
        });
    },
    hws5:function(goodsid,callback,err){
        $.ajax({
            url: 'http://hws.m.taobao.com/cache/wdetail/5.0/?id='+goodsid,
            method : 'GET',
            dataType: 'jsonp',
            timeout : 30000,
            success : function (json) {
                callback(json);
            },
            error:err
        });
    },
    hws5GetPrice:function(param){
        var str,strs;
        for(var i in param.data.itemInfoModel.priceUnits){
            if(param.data.itemInfoModel.priceUnits[i].display == '1'){
                str = param.data.itemInfoModel.priceUnits[i].price;
                if(str.indexOf("-") != -1){
                    strs = str.split("-");
                    return strs[0];
                }else {
                    return str;
                }
            }
        }
    },
    goodsInfo:function(goodsid , callBack,err){
        $.ajax({
            url:"/index.php?r=transfer/info&goodsid="+goodsid,
            method : 'GET',
            dataType:'json',
            timeout : 30000,
            success : function (json) {
                callBack(json);
            },
            error:err
        });
    },
    check_pid : function (pid){
        var pid_rule = /^mm_\d+_\d+_\d+$/i;
        return pid_rule.test(pid);
    },
    words:function(word , callback,err){
        $.ajax({
            url:"/index.php?r=default/ajaxWord&kw="+word,
            method : 'GET',
            dataType:'json',
            timeout : 30000,
            success : function (json) {
                callback(json);
            },
            error:err
        });
    },
    showList:function(list,obj){
        var target = obj,item;
        target.html("").hide();
        if(list.length > 0){
            for (var i in list){
                item = $('<li><a href="/qingsou?title='+list[i]+'&f=1" >'+list[i]+'</a></li>');
                target.append(item);
            }
            target.show();
        }
    }
};
var headerNotice = {
    update:false,
    updateDone:false,
    updateDo:function(tmp_fun){
        if(this.update && !this.updateDone){
            this.updateDone = true;
            $.ajax({
                url:"/",
                method : 'GET',
                data:{type:'fix',r:'/userMsg/visit'},
                dataType:'json',
                timeout : 10000,
                success : function (json) {
                }
            });
            $.ajax({
                url:"/",
                method : 'GET',
                data:{type:'fb',r:'/userMsg/visit'},
                dataType:'json',
                timeout : 10000,
                success : function (json) {
                }
            });
            tmp_fun()
        }
    },
    hide:function(){
        $("#mask-notice-dialog .main").animate({
            left: $(window).width() - (parseInt($("#mask-notice-dialog .main").css("width")) / 2) + "px",
            width: 0,
            height: 0
        }, 400);
        $("#mask-notice-dialog").fadeOut(400);
    },
    viewItem : function(home_notice,list){
        var i,tmp,read_tag,listRead,sys = false,err = false,back = false;
        for (i=0;i<list.length;i++){
            tmp = list[i];
            if(tmp.type == '0'){
                read_tag = tmp.is_read == '0' ? '<em></em>':'';
                listRead = tmp.is_read == '0' ? '':' msg-read';
                sys = true;
                home_notice.find(".clearfix .notice-list").append('<div class="list-item' + listRead + '"> <div class="fl icon">'+read_tag+'<span></span></div> <div class="fr con"> <a href="/?r=/qtkNotice/detail&id='+tmp.arc_id+'&type=sys"> <div class="title">'+tmp.title+'</div> <div class="info">'+resetTxtLine(tmp.msg, 60)+'</div> </a> <div class="more"> <div class="fr data">'+tmp.time+'</div> </div> </div> </div>');
            }
            if(tmp.type == '2'){
                back = true;
                read_tag = tmp.is_read == '0' ? '<em></em>':'';
                listRead = tmp.is_read == '0' ? '':' msg-read';
                home_notice.find(".clearfix .notice-list").append('<div class="list-item' + listRead + '"> <div class="fl icon fb">'+read_tag+'<span></span></div> <div class="fr con"> <div class="title">回复：'+tmp.msg+'</div><div class="info"> <div class="info-fb"> <div>反馈问题：'+resetTxtLine(tmp.content, 60)+'</div></div> </div> <div class="more">  <div class="fr data">'+tmp.time+'</div> </div> </div> </div>');
            }
            if(tmp.type == '1'){
                err = true;
                read_tag = tmp.is_read == '0' ? '<em></em>':'';
                listRead = tmp.is_read == '0' ? '':' msg-read';
                home_notice.find(".clearfix .notice-list").append('<div class="list-item' + listRead + '"> <div class="fl icon err">'+read_tag+'<span></span></div> <div class="fr con"> <div class="title">回复：'+tmp.msg+'</div><a href="/detail/'+tmp.goods_id+'" target="_blank">  <div class="info info-err"> <div class="fl err-img"> <img src="'+tmp.pic+'" alt=""> </div> <div class="fl err-txt"> <div class="tit">'+tmp.title+'</div> <div class="err-fb"> <div>商品纠错：</div> <div class="fb-txt">'+tmp.content+'</div> </div> </div> </div></a> <div class="more"> <div class="fr data">'+tmp.time+'</div> </div> </div> </div>');
            }
            if(err){
                this.update = true;
            }
            if(back){
                this.update = true;
            }
        }
    }
};

//显示字体行数
function resetTxtLine(txt, len) {
    if(txt.length > len) {
        return txt.substring(0,len) + "...";
    } else {
        return txt;
    }
}

//统计
var xcCountFun = {
    headSearch: function(Ths, tjStr) {  //轻搜首页-头部搜索
        var kw = ""; //获取搜索的关键字
        if($(Ths).parents(".head-search-box").length === 1) {
            kw = $(Ths).parents(".head-search-box").find("input").val();
        } else {
            kw = $(Ths).parents(".f-search-box").find("input").val();
        }
        if(kw != "") {
            tjStr = tjStr.replace(');', ',"kw=' + '' + kw + '"' + ");");
        }
        eval(tjStr);
    },
    searchBeforeAfter: function (Ths, tjStr) {  //轻搜首页-搜前搜索后
        if($.trim($(Ths).text()) != "全部") {
            var brandReg = new RegExp("品牌");
            var sortTxt = $(Ths).parents("li").data("cate");
            checkVerifyFun.checkSearchSta();
            if(brandReg.test(tjStr)) {
                tjStr = tjStr.replace("ea=", "ea=轻搜首页-" + globalQingSouSearchSta + "-");
            } else if(sortTxt === "sort") {
                tjStr = tjStr.replace("ea=", "ea=轻搜首页-排序-" + globalQingSouSearchSta + "-");
            } else {
                tjStr = tjStr.replace("ea=", "ea=轻搜首页-筛选-" + globalQingSouSearchSta + "-");
            }
            eval(tjStr);
        }
    },
    filterSelection: function (Ths, tjStr) { //轻搜 价格、佣金比例等搜索
        var par = $(Ths).parents(".high-filter-box-main");
        checkVerifyFun.checkSearchSta();
        par.find(".h-f-item.a-item").each(function () {
            $(this).find("a").each(function () {
                if($(this).hasClass("active")) {
                    var txt = $.trim($(this).text());
                    eval(tjStr.replace("ea=", "ea=轻搜-筛选-" + globalQingSouSearchSta + "-" + txt));
                }
            });
        });
        par.find(".h-f-item.ipt-item").each(function () {
            $(this).each(function () {
                $(this).find(".g-item").each(function ()　{
                    var iptVal = "";
                    $(this).find("span input").each(function () {
                        iptVal = $(this).val();
                    });
                    if(iptVal.length > 0) {
                        var txt = $(this).find(".opt-tit").text().replace("≥", "");
                        eval(tjStr.replace("ea=", "ea=轻搜-筛选-" + globalQingSouSearchSta + "-" + txt));
                    }
                });
            });
        });
    },
    boutiqueSearch: function(Ths, tjStr) { //人工精选 搜索
        var me = $(Ths);
        var searchTypeTxt = $.trim(me.parents(".common-header-search").find(".header-search-keywords p").text());
        var kw = $.trim($("#topSearchInput").val()); //获取搜索的关键字
        if(kw != "") { //如果存在关键词需统计
            tjStr = tjStr.replace(');', ',"kw=' + '' + kw + '"' + ");");
        }
        eval(tjStr.replace("索", "索-" + searchTypeTxt));
        eval(tjStr);
    },
    boutiqueRecom: function (Ths, tjStr) {
        eval(tjStr);
        var par = $(Ths).parents(".boutique-box");
        var sId = par.data("s-id");
        var adId = par.data("ad-id");
        var adGId = par.data("ad-gid");
        if(sId != undefined && adId != undefined) {
            tjStr = tjStr.replace(');', ',"ds=web","at=crs","gid=' + '' + adGId + '","cn=' + '' + sId + '","ci=' + '' + adId + '"' + ");");
            eval(tjStr);
        }
    },
    transferCondition: function (Ths, tjStr) { //用于转链 标题、主图、文案
        tjStr = tjStr.replace("ea=", "ea=转链-" + transferHomePluginSta + "-");
        tjStr = tjStr.replace(');', ',"gid=' + '' + $("#goods_id").val() + '"' + ");");
        eval(tjStr);
    },
    transferCjCondition: function (Ths, tjStr) { //用于转链 标题、主图、文案
        tjStr = tjStr.replace(');', ',"gid=' + '' + $("#goods_id").val() + '"' + ");");
        eval(tjStr);
    },
    transferRecommend:function (Ths, tjStr) {
        eval(tjStr);
        var par = $(Ths).parents(".media-list-item");
        var sId = par.data("ad_site_id");
        var adId = par.data("ad_id");
        var adGid = par.data("ad_gid");
        if(sId != undefined && adId != undefined) {
            tjStr = tjStr.replace(');', ',"ds=web","at=crs","gid=' + '' + adGid + '","cn=' + '' + sId + '","ci=' + '' + adId + '"' + ");");
            eval(tjStr);
        }
    },
    searchMediaItem: function (Ths, tjStr) {
        checkVerifyFun.checkSearchSta();
        var err = new RegExp("商品纠错");
        if(err.test(tjStr)) {
            tjStr = tjStr.replace("ea=商品纠错", "ea=" + globalQingSouSearchSta + "-商品纠错");
        } else {
            tjStr = tjStr.replace("ea=轻搜", "ea=轻搜-" + globalQingSouSearchSta);
        }
        tjStr = tjStr.replace("eg=", "eg=" + checkVerifyFun.getNowPage());
        tjStr = tjStr.replace("edx=", "edx=" + $(Ths).parents(".media-list-item").data("ind"));
        var hostUrl = window.location.href;
        var searchTxt = hostUrl.match(/title\=([^&]*)&?/);
        if(searchTxt != null) {
            if(searchTxt[1].length > 0) {
                tjStr = tjStr.replace(');', ',"kw=' + '' + decodeURI(searchTxt[1]) + '"' + ");");
            }
        }
        eval(tjStr);
        var itemPar = $(Ths).parents(".media-list-item");
        if(itemPar.attr("data-type") === "ad") {
            var ind = itemPar.attr("data-ind");
            tjStr = tjStr.replace(');', ',"eg=1","edx=' + '' + ind + '"' + ");");
            tjStr = tjStr.replace('ea=轻搜-', 'ea=轻搜-ggw-'); //ggw 广告位
            eval(tjStr);
        }
    },
    transferLongPic: function (Ths, tjStr) { //转长图
        if(goods_page.activity_id === null) {
            tjStr = tjStr.replace("ea=转链-", "ea=转链-官网-");
        } else {
            tjStr = tjStr.replace("ea=转链-", "ea=转链-插件-");
        }
        eval(tjStr.replace("gid=", "gid=" + goods.goods_id));
    },
    dbMerchant: function (Ths, tjStr) {//双11招商统计
        eval(tjStr);
        var gid = $(Ths).data("gid");
        if(gid != undefined) {
            tjStr = tjStr.replace("商品","招商商品");
            tjStr = tjStr.replace(');', ',"gid=' + '' + gid + '"' + ");");
            eval(tjStr);
        }
    }
};

$(function () {

    checkIsIeE();

    if (typeof Clipboard != "undefined") {
        ClipboardSupport = 1;
    } else {
        ClipboardSupport = 0;
    }

    //共用变量
    var fixedSearch = $(".fixed-search");
    var goTop = $(".go-top-btn");
    var searchKw = $(".header-search-keywords p");
    var dropDownLi = $(".header-search-drop-down li");
    var seIptArea = $(".header-search-input-box");
    var clearIpt= ".clear-input-btn";
    var rankFixed = ".rank-fixed-top";
    var hideSta = true;
    var dropDownSta = false;

    //回到顶部TOP值
    goTopRe();

    var defSTopNum = $(window).scrollTop();
    //判断页面滑动高度大于150的时候 显示吸顶搜索 和 回到顶部箭头
    if(defSTopNum > 500) {
        fixedSearch.show();
        $(rankFixed).slideDown(200);
    }

    //显示吸顶搜索 和 回到顶部箭头
    $(window).scroll(function () {
        var scrollTop = $(this).scrollTop();
        var scrollHeight = $(document).height();
        var windowHeight = $(this).height();
        if(scrollTop > 500) {
            $(".main-new-msg-fixed").addClass("new-msg-fixed");
            fixedSearch.slideDown(200);
            $(rankFixed).slideDown(200);
        } else  {
            fixedSearch.slideUp(200);
            $(rankFixed).slideUp(200);
            $(".main-new-msg-fixed").removeClass("new-msg-fixed");
        }
        if (scrollHeight - (scrollTop + windowHeight) <= 20) {
            //加载更多
            if($(".home-page").length != 0) {
                //addItem();
            }
        }

        //消息中心
        if(scrollTop >= 200) {
            $("#v3-notice a").addClass("bg-black");
        }
        if(scrollTop <= 148) {
            $("#v3-notice a").removeClass("bg-black");
        }

        if (scrollHeight - (scrollTop + windowHeight) <= 1000) {
            //精品榜单-加载更多
            if($(".rank-today").length != 0) {
                //rankListItem();
            }
        }
    });

    //回到顶部
    goTop.click(function () {
        $('body,html').animate({
            scrollTop: 0
        },200);
    });

    //显示搜索下拉列表
    $(".header-search-keywords").hover(function() {
        dropDownSta = false;
        var ths = $(this);
        //判断 默认关键字在下拉列表中不显示
        var keyW = $(".header-get-keywords").text();
        dropDownLi.each(function () {
            if($(this).text() == keyW) {
                $(this).addClass("hide");
            } else {
                $(this).removeClass("hide");
            }
        });
        ths.children(".header-search-drop-down").slideDown(150);
    },function() {
        var ths = $(this);
        dropDownSta = true;
        setTimeout(function (){
            if(dropDownSta) {
                ths.children(".header-search-drop-down").slideUp(150);
            }
        }, 300);
    });
    $(".header-search-keywords ul").hover(function () {
        dropDownSta = true;
    },function () {
        dropDownSta = false;
    });

    //点击下拉选项获值和赋值参数
    dropDownLi.click(function () {
        var ths = $(this);
        var i = ths.index();
        if($(this).text() == "只搜品牌"){
            $("#headerSearchIpt").attr("placeholder","请输入要搜索的商品品牌");
            $("#topSearchInput").attr("placeholder","请输入要搜索的商品品牌");
        }
        else if($(this).text() == "只搜标题"){
            $("#headerSearchIpt").attr("placeholder","请输入要搜索的商品标题");
            $("#topSearchInput").attr("placeholder","请输入要搜索的商品标题");
        }
        else{
            $("#headerSearchIpt").attr("placeholder","请输入要搜索的内容、商品链接、商品ID或品牌");
            $("#topSearchInput").attr("placeholder","请输入要搜索的内容、商品链接、商品ID或品牌");
        }
        $(".search-keywords-val").val(ths.attr("data-val"));
        searchKw.text((dropDownLi).eq(i).text());
        $(".header-search-drop-down").slideUp(100);
        ths.parents(".header-search-keywords").find("i").removeClass("");
    });

    //筛选显示操作按钮
    $(".advanced-select ul li input").focus(function () {
        var ths = $(this);
        if(!$(".advanced-select").hasClass("advanced-filter-input")) {
            ths.parents(".advanced-select").addClass("advanced-filter-input");
        }
    });

    //清空筛选框
    $(".advanced-filter-cancel").click(function () {
        $(".ad-filter-input li input").val("");
    });

    //高级搜索显示确定和清空按钮
    $(".advanced-filter-box ul li input").focus(function () {
        var ths = $(this);
        if(!$(".advanced-filter").hasClass("advanced-filter-input")) {
            ths.parents(".advanced-filter").addClass("advanced-filter-input");
        }
        $(".advanced-filter-cancel").click(function () {
            $(".ad-filter-input li input").val("");
        });
    });

    //共用方法，检测只能输入文字
    $(".input-is-number").on('input',function () {
        var ths = $(this);
        var min = parseFloat(ths.attr('data-min'));
        var max = parseFloat(ths.attr('data-max'));
        var txt = ths.val();
        var inputTxt = parseFloat(txt);
        var ok = false;
        if(!isNaN(inputTxt)) {
            if((!isNaN(max) && !isNaN(min)) && (max >= inputTxt && inputTxt >= min)){
                ok = true;
            }
            if(isNaN(max) && !isNaN(min) && (inputTxt >= min)){
                ok = true;
            }
            if(isNaN(min) && !isNaN(max) && (inputTxt <= max)){
                ok = true;
            }
            if(isNaN(min) && isNaN(max)){
                ok = true;
            }
        }
        if(ok){
            isCatReload && $('input[name="cat"]').val(0);
            if(ths.hasClass("ipt-decimal")) {
                ths.val(this.value.replace(/[^\-?\d.]/g,''));
            } else {
                ths.val(parseInt(txt));
            }
        }else {
            if(!isNaN(max) && inputTxt > max){
                ths.val(max);
                return ;
            }
            if(!isNaN(min) && inputTxt < min){
                ths.val(min);
                return ;
            }
            ths.val('');
        }
    }).on('blur',function(){
        var inputTxt = parseFloat($(this).val());
        $(this).val(isNaN(inputTxt)?'':inputTxt);
    });

    $('input[name="title"]').on('input',function(){
        var val = this.value;
        if(val.length > 0){
            $(this).next('.clear-input-btn').fadeIn();
        }else {
            $(this).next('.clear-input-btn').fadeOut();
        }
    });

    //意见反馈
    $(".feedback").click(function () {
        //友盟意见反馈点击数
        umDataStatistics("轻搜-意见反馈","点击","","","");
    });

    //商品纠错
    $("#createDom").on("click",".commodity-correction",function () {
        //友盟商品纠错点击数
        umDataStatistics("轻搜-商品纠错","点击","","","");
    });

    //搜索框移动上去显示删除图标
    seIptArea.hover(function () {
        hideSta = false;
        $(clearIpt).show();
    }, function () {
        if(seIptArea.val().length <= 1) {
            hideSta = true;
            $(clearIpt).hide();
        }
    });

    //判断输入文字时显示按钮 并同步显示文字
    seIptArea.keyup(function() {
        if($(this).context.id == "topSearchInput") {
            document.getElementById("headerSearchIpt").value=document.getElementById("topSearchInput").value;
        } else {
            document.getElementById("topSearchInput").value=document.getElementById("headerSearchIpt").value;
        }
        $(clearIpt).show();
    });

    //判断点击时 大于1的时候 显示清除按钮
    seIptArea.focus(function () {
        if($(this).val().length >= 1) {
            $(clearIpt).show();
        }
    });

    //判断清除按钮 推动焦点时隐藏
    seIptArea.blur(function () {
        if(hideSta) {
            $(clearIpt).hide();
        }
    });

    //复制功能
    $("body").on("mouseenter", ".media-list-copy-fun .mediaOneKeyCopyBtn", function () {
        var ths = $(this);
        var parents;
        if(ths.parents(".media-top-list").length == 1) {
            var offSetRight = ($(window).width()) - (ths.parents(".media-top-list").offset().left + 280 + 120);
            parents = ths.parents(".media-top-list");
            showSmallPic(ths,".media-top-btn");
        } else {
            var offSetRight = ($(window).width()) - (ths.parents(".media-list-item").offset().left + 280);
            if(ths.hasClass("v2-copy-btn")) {
                var smallPicUrl = ths.parents(".media-list-item").find("img.media-list-img").data("copy-img");
                parents = ths.parents(".v2-list-btm-btn");
                parents.find("img.media-small-pic").attr("src", smallPicUrl);
            } else {
                parents = ths.parents(".media-one-key-box");
                showSmallPic(ths,".media-one-key-copy");
            }
        }
        if(offSetRight < 300) {
            parents.find(".media-list-text-box b").addClass("triangle-right");
            $(".media-list-text-box").addClass("media-list-text-left");
        }
        parents.find(".media-list-text-box").show();
    });
    $(".media-list-copy-fun").on("mouseleave", ".mediaOneKeyCopyBtn", function () {
        var ths = $(this);
        if(ths.parents(".media-top-list").length == 1) {
            var par = ths.parents(".media-top-btn");
            $(".media-list-text-box").removeClass("media-list-text-left");
            par.find(".media-list-text-box b").removeClass("triangle-right");
            par.find(".media-list-text-box").hide();
        } else {
            $(".media-list-text-box").removeClass("media-list-text-left");
            var par;
            if(ths.hasClass("v2-copy-btn")) {
                par = ths.parents(".v2-list-btm-btn");
            } else {
                par = ths.parents(".media-one-key-box");
            }
            par.find(".media-list-text-box b").removeClass("triangle-right");
            par.find(".media-list-text-box").hide();
        }
    });

    //清除输入框文字
    $(clearIpt).hover(function(){
        hideSta = false;
    },function(){
        hideSta = true;
    });
    $(clearIpt).on("click", function () {
        $(".header-search-input-area").val('');
        //判断是吸顶搜索还是头部搜索
        if($(this).hasClass("top-search")) {
            $("#topSearchInput").focus();
        } else {
            $("#headerSearchIpt").focus();
        }
        $(this).hide();
    });

    $(window).resize(function () {
        goTopRe();
    });

    //判断榜单页面没有下拉
    if($(".common-nav ul li").eq(2).hasClass("common-nav-active")) {
        $(".common-qtk-drop-down").remove();
    }

    //共用下拉菜单
    var liSta = true,slideBox = false;
    $(".common-drop-down ul.drop-nav li").mouseenter(function () {
        if($.trim($(this).text()) == "大数据榜单") {
            var dropBox = ".common-qtk-drop-down";
            liSta = true;
            $(dropBox).slideDown(200);
            $(dropBox).mouseenter(function () {
                slideBox = true;
            });
            $(dropBox).mouseleave(function () {
                slideBox = false;
                setTimeout(function () {
                    if(liSta == false && slideBox == false) {
                        $(dropBox).stop().slideUp(100);
                    }
                }, 150);
            });
        }
    });
    $(".common-drop-down ul.drop-nav li").mouseleave(function () {
        liSta = false;
        setTimeout(function () {
            if(liSta == false && slideBox == false) {
                var dropBox = ".common-qtk-drop-down";
                $(dropBox).stop().slideUp(100);
            }
        }, 150);
    });

    //意见反馈 切换
    if($(".common-feedback-page").length == 1) {
        $(".common-feedback-page .select-checkbox label").on("click", function () {
            var ind = $(this).index();
            var par = $(".common-feedback-page .common-feedback-submit");
            if(ind == 1) {
                par.find(".cj-server").removeClass("hide");
                par.find(".content-head").addClass("hide");
            } else {
                par.find(".cj-server").addClass("hide");
                par.find(".content-head").removeClass("hide");
            }
        });

        $(".common-feedback-page .contact-email").blur(function () {
            var val = $(this).val();
            if(!COMMON.isEmail(val)) {
                $(this).parents(".common-feedback-ipt").addClass("err");
            } else {
                $(this).parents(".common-feedback-ipt").removeClass("err");
            }
        });
    }

    //XCTJ共用方法
    $(".common-xCtJ-count").on("click", function (ev) {
        console.log($(this).context.nodeName)
        // if($(this).context.nodeName == "INPUT") {
        //     return false;
        // }
        countCommonFun($(this));
    });

    //统计回车
    $(".common-xCtJ-count").keyup(function (ev) {
        if(ev.keyCode === 13 && $(this).context.nodeName == "INPUT") {
            countCommonFun($(this));
        }
    });

    //XCTJ委托共用方法
    $("body").on("click", ".common-bd-xCtJ-count", function () {
        if($(this).context.nodeName == "INPUT") {
            return false;
        }
        countCommonFun($(this));
    });

    //人工精选顶部搜索、轻网站、榜单、插件共用统计
    $(".common-one-head .common-header-search-btn").on("click", function () {
        var txt = $(".common-one-head p.header-get-keywords").text();
        umDataStatistics("人工精选-头部搜索-"+txt,"点击","","","");
        umDataStatistics("人工精选-头部搜索-","点击","","","");
    });
    $(".common-one-head .common-header-search-input input").keyup(function (ev) { //轻搜页面 轻搜-头部搜索 键盘事件搜索
        if(ev.keyCode == 13) {
            var txt = $(".common-one-head p.header-get-keywords").text();
            umDataStatistics("人工精选-头部搜索-"+txt,"点击","","","");
            umDataStatistics("人工精选-头部搜索-","点击","","","");
            //XC统计吸顶轻搜键盘事件
            countCommonFun($(this).parents(".common-header-search").find(".common-header-search-btn"));
        }
    });

    var slide_up_t,filter_box_up_t;
    $("body").on("click",function(){
        filter_box_up_t = setTimeout(function(){
            $("#high-filter-box").slideUp(150);
        },100);
        slide_up_t = setTimeout(function(){
            $("#nav-drop-down-box").slideUp(150);
        },100);
    }).on("click","#nav-drop-down-box :not(a)",function(){
        clearTimeout(slide_up_t);
        return false;
    }).on("click","#high-filter-box :not(a)",function(){
        clearTimeout(filter_box_up_t);
        return false;
    });

    //V3 导航
    $("#v3-nav .nav-more-op").on("click", function () {
        if($("#drop-down-select-options .float a").length >= 3) {
            $("#nav-drop-down-box").css("height", "154px");
        } else {
            $("#nav-drop-down-box").css("height", "113px");
        }
        if($(this).parents("#v3-nav").find(".nav-drop-down").css("display") === "none") {
            clearTimeout(slide_up_t);
            $("#nav-drop-down-box").slideDown(100);
        } else {
            $("#nav-drop-down-box").slideUp(100);
        }
        return false;
    });
    $("#nav-drop-down-cancel").on("click", function () {
        $("#nav-drop-down-box").slideUp(150);
    });

    $("body").on("click", "#drop-down-selected a, #drop-down-selected a em", function () {
        var _html = "";
        if($(this).context.nodeName == "EM") {
            var par = $(this).parents("a");
            _html = par[0].outerHTML;
            $("#drop-down-select-options .float").append(_html);
            par.remove();
        } else {
            var ths = $(this);
            if($.trim(ths.text()) === "商品库") {
                return false;
            }
            _html = $(this)[0].outerHTML;
            if(ths.find("em").length) {
                $("#drop-down-select-options .float").append(_html);
            }
            ths.remove();
        }
        if($("#drop-down-select-options .float a").length >= 3) {
            $("#nav-drop-down-box").css("height", "154px");
        } else {
            $("#nav-drop-down-box").css("height", "113px");
        }
        clearTimeout(slide_up_t);
        return false;
    });

    $("body").on("click", "#drop-down-select-options a, #drop-down-select-options a em", function () {
        var _html = "";
        if($(this).context.nodeName == "EM") {
            var par = $(this).parents("a");
            _html = par[0].outerHTML;
            $("#drop-down-selected .float").append(_html);
            par.remove();
        } else {
            _html = $(this)[0].outerHTML;
            var ths = $(this);
            $("#drop-down-selected .float").append(_html);
            ths.remove();
        }
        if($("#drop-down-select-options .float a").length >= 3) {
            $("#nav-drop-down-box").css("height", "154px");
        } else {
            $("#nav-drop-down-box").css("height", "113px");
        }
        clearTimeout(slide_up_t);
    });

    //V3 高级筛选
    $("#high-filter-btn").on("click", function () {
        clearTimeout(filter_box_up_t);
        if($(this).parents("#v3-filter").find(".high-filter-box").css("display") === "none") {
            $("#high-filter-box").slideDown(150);
        } else {
            $("#high-filter-box").slideUp(150);
        }
        return false;
    });
    $("#h-f-cancel").on("click", function () {
        $("#high-filter-box").slideUp(150);
    });
    //高级筛选 下拉获取值
    $("#high-filter-box .g-item input").on("mouseover", function () {
        $(this).parents(".g-item").find("ul").slideDown(150);
    });
    $("#high-filter-box .options").on("click",function(){
        return false;
    });
    $("#high-filter-box .g-item ul li").on("click", function () {
        var val = $(this).text();
        var par = $(this).parents("span");
        var txtReg = new RegExp(",");
        if(txtReg.test(val)) {
            val = val.replace(",", "");
        }
        par.find("input").val(val);
        $(this).parents("ul").slideUp(150);
    });

    //V3 header 解决方案下拉
    var headerTimer;
    $("#v3-header li").mouseenter(function () {
        if($.trim($(this).text()) === "解决方案") {
            if($("#header-drop-down").css("display") === "none") {
                var par = $(this).parents(".head-nav");
                par.addClass("hover");
                $("#header-drop-down").stop().slideDown(150);
            }
        } else {
            $("#header-drop-down").stop().slideUp(150);
        }
    });
    $("#header-drop-down").mouseenter(function () {
        clearTimeout(headerTimer);
    });
    $("#header-drop-down").mouseleave(function () {
        headerTimer = setTimeout(function () {
            var par = $(this).parents(".head-nav");
            par.removeClass("hover");
            $("#header-drop-down").stop().slideUp(150);
        }, 200);
    });

    //v3,设置栏目
    $("#nav-drop-down-cfm").on("click",function(){
        clearTimeout(slide_up_t);
        var menu = [],target = $("#drop-down-select-options a"),i;
        for(i=0;i<target.length;i++){
            menu.push(target.eq(i).data("val"))
        }
        $.ajax({
            url:"/index.php?r=default/ajaxMenu",
            method : 'GET',
            dataType:'json',
            data:{menu:menu},
            timeout : 10000,
            success : function (json) {
                if(json.status == 1) {
                    var selectDom = $("#drop-down-selected .float").html();
                    var optionDom = $("#drop-down-select-options .float").html();
                    var obj = {
                        select: selectDom,
                        option: optionDom
                    };
                    window.localStorage.setItem("navOptions", JSON.stringify(obj));
                    window.location.href = '/login?ref=default';
                    return false;
                }
                if(json.status == 0){
                    layer.msg("设置成功");
                    window.location.reload();
                }else {
                    if(json.data == '请先登录。'){
                        return window.location.href = GlobalLoginUrl;
                    }else {
                        layer.msg("设置失败，请稍后重试。");
                    }

                }
            },
            error:function(){
                layer.msg("通讯失败，请检查您的网络。");
            }
        });
    });

    var getNavOpts = window.localStorage.getItem("navOptions");
    if(getNavOpts != null) {
        var navOpsLen = getNavOpts.length;
        if(navOpsLen > 0) {
            var getJsonParse = JSON.parse(getNavOpts);
            $("#drop-down-selected .float").html("").html(getJsonParse.select);
            $("#drop-down-select-options .float").html("").html(getJsonParse.option);
            $("#nav-drop-down-box").slideDown(150);
            window.localStorage.setItem("navOptions", "");
        }
    }

    //金牌卖家 聚划算 等显示
    mediaTipsIcon();

    //导航搜索
    $("#v3-header .head-nav-box .con span").unbind().on("click", function () {
        var ths = $(this),target = $("#v3-header .head-nav-box .con input");
        target.focus();
        if($.trim(target.val()).length > 0 && ths.parents(".con").hasClass("active")){
            ths.closest("form").submit();
        }
        ths.parents(".con").addClass("active");
    });
    $("#v3-header .head-nav-box .con input").unbind().blur(function () {
        var ths = $(this);
        if(ths.parents(".con").hasClass("active")){
            setTimeout(function () {
                ths.parents(".con").removeClass("active");
            },300);
        }
    });

    //V3清除所有
    $(".v3-common-search-clear").on("click", function () {
        var par = $(this).parents(".head-search-box, .f-search-box");
        par.find("#topSearchInput, #headerSearchIpt").val("");
        $(this).hide();
    });
});

//清除所有内容

function countCommonFun(me) {
    var p = me.data("params"); //参数
    var selfFun = me.data("fun"); //事件参数
    var pArr = p.split(',');
    var xctjString = null;
    xctjString = 'xctj("ec=click", "bs=1", "pCode=qtkwww",';
    var pStr = '';
    //循环写入参数
    for(var i=0; i< pArr.length;i++){
        if(!pArr[i]){
            continue;
        }
        if(i == 0){
            pStr += '"'+ pArr[i] +'"';
        }else {
            pStr += ',"' + pArr[i] + '"';
        }
    }
    xctjString += pStr + ');';

    //判断是否有函数参数
    if(selfFun != undefined) {
        xcCountFun[selfFun](me[0], xctjString);
    } else {
        eval(xctjString);
    }
}

function checkEmail(obj){
    var target = $(obj);
    var email = $.trim(target.val());
    if(email.length > 0 && !COMMON.isEmail(email)){
        layer.msg("邮箱格式错误");
        //target.focus();
        return false;
    }
    return true;
}

function feekback(obj) {
    var target = $(obj).closest("form").find("[name='email']");
    var email = $.trim(target.val());
    if(email.length > 0 && !COMMON.isEmail(email)){
        layer.msg("邮箱格式错误");
        //target.focus();
        return ;
    }
    $.post('/index.php?r=default/feedback',$(obj).closest('form').serialize(),function(data){
        if(data.status){
            var parents = $(obj).parents(".common-feedback-box");
            parents.find("textarea").val("");
            parents.find("input[name='title']").val("");
            parents.find("input[name='contect']").val("");
            var allNum = parseInt(parents.find(".common-feedback-submit span b").text());
            parents.find(".common-feedback-submit span b").text(allNum + 1);
            layer.alert(data.data.msg,{closeBtn: false},function () {
                layer.closeAll();
            });
        }else {
            layer.msg(data.data.msg);
        }
    },'json');
}

function fix(obj){
    obj = $(obj);
    $.post(obj.prop('action'),obj.serialize(),function(data){
        if(data.status){
            obj.find("textarea").val("");
            obj.find("input[name='qq']").val("");
            var allNum = parseInt(obj.find(".commodity-submit span b").text());
            obj.find(".commodity-submit span b").text(allNum + 1);
            layer.alert(data.data.msg,{closeBtn: false},function () {
                layer.closeAll();
            });
        }else {
            layer.msg(data.data.msg);
        }
    },'json');
}


/**判断登录
 * loginfun 登录成功后执行的函数
 * unloginfun 没有登录执行的方法 不传值默认会登录登录提示
 * **/
function islogin(loginfun,unloginfun) {
    if(user_login){
        loginfun();
        return;
    }
    $.get('/index.php?r=login/islogin', function (data) {
        if (data.data) {
            user_login = true;
            setTimeout(function(){
                user_login = false;
            },600000);
            loginfun();
        }else{
            if(unloginfun)unloginfun();
            else {
                layer.confirm("请您先登录",function () {
                    var url = $(".login-site").eq(0).prop('href');
                    url = url?url:'/login?ref=default';
                    window.location.href = url;
                });
            }
        }
    });
}

//判断输入的价格小于数字几时显示几
/*参数两个
 *1. dom 就是当前的 dom节点
 *2. num 就是判断小于数字几时显示几
 * */
function numLess(dom, num) {
    var val = dom.val();
    if(val < num) {
        dom.val(num);
    }
}

//商品纠错下拉选择
$("body").on("mouseover",".commodity-correction-ipt",function (e) {
    var ths = $(this);
    var related = getRelated(e);
    if(this != related && !contains(this, related)) {
        ths.find("ul").slideDown(100);
        $("."+ths.context.className+" ul li").click(function (e) {
            e.stopPropagation();
            ths.find(".commodity-correction-type").text($(this).text());
            ths.find(".commodity-correction-type").attr("data-val",$(this).attr("data-val"));
            ths.find('input[name="err_type"]').val($(this).attr("data-val"));
            ths.find("ul").slideUp(100);
        });
    }
});

$("body").on("mouseout",".commodity-correction-ipt",function (e) {
    var related = getRelated(e);
    if(this != related && !contains(this, related)) {
        $(this).find("ul").slideUp(100);
    }
});

//判断两个a中是否包含b
function contains(a, b) {
    return a.contains ? a != b && a.contains(b) : !!(a.compareDocumentPosition(b) & 16);
}
function getRelated(e) {
    var related;
    var type = e.type.toLowerCase(); //这里获取事件名字
    if(type == 'mouseover') {
        related = e.relatedTarget || e.fromElement
    } else if(type = 'mouseout') {
        related = e.relatedTarget || e.toElement
    }
    return related;
}

//判断只能输入数字
function onlyNum(ths) {
    ths.val(ths.val().replace(/\D/g,''));
}

//测试版本
function checkIsIeE() {
    if(window.navigator.appName == "Microsoft Internet Explorer") {
        if(document.documentMode == "8") {
            layer.alert("IE8内核浏览器无法显示部分功能，为了感受更好的体验，请切换chrome内核(极速模式)浏览！",{title: "友情提示",zIndex:200000,closeBtn:false},function(index) {
                if(index == 1) {
                    layer.closeAll();
                    $("#compatibleIeTips").remove();
                }
            });
            $("body").append(compatibleIeTips);
        }
    }
}

var compatibleIeTips = '<div id="compatibleIeTips" class="common-icons">提示IE8兼容</div>';

//回到顶部
function goTopRe() {
    var goTop = $(".goTopThree");
    if($(window).width() <= 1516) {
        goTop.fadeIn();
        goTop.css("left","auto").css("right", 0);
    } else {
        var win_with = $(window).width()/2;
        goTop.css("left", (win_with + 600+110) + "px");
        goTop.fadeIn();
    }
}

//显示小图
function showSmallPic(ths,pEle) {
    var parents = $(ths).parents(pEle);
    var smallImgUrl = parents.find("img.media-small-pic").attr("data-copy-img");
    parents.find("img.media-small-pic").attr("src", smallImgUrl);
}

//检查是否安装插件
function isInsallPlugin() {
    if($("#qtk_flagship_version").length > 0) {
        return true;
    } else {
        return false;
    }
}

//layer tips打开关闭
function mediaTipsIcon() {
    $(".media-tips-icon").hover(function () {
        var typeNum = $(this).data("type");
        var msg = $(this).data("txt");
        var offsetNum = $(this).data("offset");
        if(typeof msg == 'undefined' || msg==''){
            return;
        }
        layer.tips($(this).data("txt"), $(this), {
            tips: [2, '#ff6600'],
            time: 3000000,
            maxWidth: "212px",
            success: function(layero) {
                layero.find(".layui-layer-content").addClass("media-sm-tips").css("margin-top","-7px");
                if(typeNum == 3) {
                    layero.find(".layui-layer-content").css("margin-top","-4px");
                } else if(offsetNum != undefined && typeof offsetNum === "number") {
                    layero.find(".layui-layer-content").css("margin-top", offsetNum + "px");
                } else if(typeNum === 4) {
                    layero.find(".layui-layer-content").css("margin-top", "134px");
                }
            }

        });
    },function () {
        layer.closeAll('tips');
    });

    $(".media-tips-icon-click").click(function(){
        var msg = $(this).data("txt");
        /*var left = $(this).data("left");*/
        var left = 67;
        if(typeof msg == 'undefined' || msg==''){
            return;
        }
        layer.tips($(this).data("txt"), $(this), {
            tips: [2, '#ff6600'],
            time: 300000,
            maxWidth: "212px",
            success: function(layero) {
                layero.find(".layui-layer-content").addClass("media-sm-tips").css("margin-top","3px");
                if(left){
                    layero.find(".layui-layer-content").css("margin-left",left+"px");
                }
                setTimeout(function(){
                    layer.closeAll('tips');
                },2000);
            }

        });
    });
}

(function (ele) {
    //删除当前选项
    if($(ele).data("del") == "del-ths") {
        $(ele).each(function () {
            var txt = $(this).find(".drop-down-txt").text();
            $(this).find(".drop-down-box li").each(function () {
                if($(this).find("a").text() == txt) {
                    $(this).remove();
                }
            });
        });
    }
    $( ele ).hover(function () {
        var txt = $(this).find(".drop-down-txt");
        var val = $(this).find(".drop-down-val");
        var ulEle = $(this).find(".drop-down-box");
        ulEle.hide();
        ulEle.show();
        ulEle.find("li").on("click", function () {
            txt.text($(this).text());
            if($(this).find("a").data("val") != undefined) {
                val.val($(this).find("a").data("val"));
            }
            ulEle.hide(100);
        });
    }, function () {
        $( ele ).find(".drop-down-box").hide();
    });
})(".common-drop-down");

/**倒计时
 *参数：时间戳 元素选项
 * **/
function getCountDown(timestamp,opt){
    if(typeof sys_time != "undefined") {
        var s_time = sys_time;
        var timer = setInterval(function(){
            var t = timestamp * 1000 - s_time * 1000;
            if(t < 0) {
                var parent = $(opt.mEle).parents("p.downtime-ele");
                parent.hide();
                parent.prev("p.downtime-end").show();
                clearInterval(timer);
                return;
            }
            var hour=Math.floor(t/1000/60/60%24);
            var min=Math.floor(t/1000/60%60);
            var sec=Math.floor(t/1000%60);

            if (min < 10) {
                min = "0" + min;
            }
            if (sec < 10) {
                sec = "0" + sec;
            }
            if(opt) {
                $(opt.mEle).text(min);
                $(opt.sEle).text(sec);
            }
            s_time = s_time + 1;
        },1000);
    }
}


/*友盟数据统计埋点
 * cate string 表示事件发生在谁身上 *
 * action string 表示访客跟元素交互的行为动作 *
 * label string 用于更详细的描述事件
 * value int 用于填写打分型事件的分值
 * eleId string 填写事件元素的div元素id *
 */
function umDataStatistics(cate, action, label, value, eleId) {
    _czc.push(["_trackEvent",cate,action,label,value,eleId]);
}

//首页及人工精选高级筛选 列表获取友盟数据统计共用样式
function getAdListFun(ele, txtName, action) {
    $(ele).on("click", function () {
        var ths = $(this);
        var txt = $.trim(ths.find("span").text());
        var eleId = ths.attr("id");
        txt = txt.replace(/[\s\d\（\）\(\)]/ig,"");
        if(txt != "全部") {
            var newTxt = txtName+txt;
            umDataStatistics(newTxt,action,"","",eleId);
        }
    });
}

function getBLen(str) {
    if (str == null) return 0;
    if (typeof str != "string"){
        str += "";
    }
    return str.replace(/[^\x00-\xff]/g,"01").length;
}

window.onload = function(){
    var $txt = $(".header-search-keywords p").text();
    if($txt == "只搜标题只搜标题"){
        $("#headerSearchIpt").attr("placeholder","请输入要搜索的商品标题")
    }
    else if($txt == "只搜品牌只搜品牌"){
        $("#headerSearchIpt").attr("placeholder","请输入要搜索的商品品牌")
    }
    else{
        $("#headerSearchIpt").attr("placeholder","关键词 / 链接 / 品牌 / ID")
    }
};

//判断PC或移动端
function conditionIsPc() {
    var userAgentInfo = navigator.userAgent;
    var Agents = new Array("Android", "iPhone", "SymbianOS", "Windows Phone", "iPad", "iPod", "Mac", "mac");
    var flag = true;
    for(var v = 0; v < Agents.length; v++) {
        if(userAgentInfo.indexOf(Agents[v]) > 0) {
            flag = false;
            break;
        }
    }
    return flag;
}

//检测搜索状态
var checkVerifyFun = {
    //检测搜索状态-搜前、搜后
    checkSearchSta : function () {
        var searchSta = $("#v3-filter .filter-item a").length; // 0 为搜索前。大于0为搜索后
        if(searchSta > 0) {
            globalQingSouSearchSta = "搜后"
        } else {
            globalQingSouSearchSta = "搜前"
        }
    },
    //获取当前页面
    getNowPage: function () {
        if ($(".home-page .page-box2").length === 0) {
            return 1;
        } else {
            var pageNum = null;
            $(".home-page .page-box2 li").each(function () {
                if($(this).find("a").hasClass("page-curr")) {
                    pageNum = $.trim($(this).find("a").text());
                }
            });
            return parseInt(pageNum);
        }
    }
}

//禁滚动及上下左右滚动 开始
var keys = [37, 38, 39, 40];
function preventDefault(e) {
    e = e || window.event;
    if(e.preventDefault)
        e.preventDefault();
    e.returnValue = false;
}
function keydown(e) {
    for(var i = keys.length; i--;) {
        if(e.keyCode === keys[i]) {
            preventDefault(e);
            return;
        }
    }
}
function wheel(e) {
    preventDefault(e);
}
function disable_scroll() {
    if(window.addEventListener) {
        window.addEventListener('DOMMouseScroll', wheel, false);
    }
    window.onmousewheel = document.onmousewheel = wheel;
    document.onkeydown = keydown;
}
function enable_scroll() {
    if(window.removeEventListener) {
        window.removeEventListener('DOMMouseScroll', wheel, false);
    }
    window.onmousewheel = document.onmousewheel = document.onkeydown = null;
}
//禁滚动及上下左右滚动 结束

//店铺等级
//level 1为红心，2为钻石，3为蓝冠，4为黄冠
//num 为数量
var transferSellerLevel = {
    create: function (level, num) {
        var _html = "";
        var dom = this.html(level);
        if(dom === null) {
            _html = "等级类别出错或不存在"
        } else {
            for(var i = 0; i < num; i++) {
                _html += dom;
            }
        }
        return _html;
    },
    html: function (l) {
        switch(l) {
            case 1:
                return '<span class="common-icons"></span>';
                break;
            case 2:
                return '<span class="common-icons diamond"></span>';
                break;
            case 3:
                return '<span class="common-icons blue-crown"></span>';
                break;
            case 4:
                return '<span class="common-icons yellow-crown"></span>';
                break;
            default:
                return null;
        }
    }
};

//与同行业相比
var transferHeiLow= {
    level: function (num) {
        if(num < 0) {
            return "低于"
        } else if (num == 0) {
            return "持平"
        } else if (num > 0) {
            return "高于"
        }
    },
    percent: function (num) {
        if((num - 0) == 0) {
            return "--"
        } else if(num < 0) {
            return parseFloat(Math.abs(num)) + "%"
        } else {
            return parseFloat(num) + "%"
        }
    },
    cls: function (level) {
        if(level === "低于") {
            return " down"
        } else if (level === "高于") {
            return " up"
        }
    }
};

//设置一键复制
var copyFunction = function(copy){
    var clipboard = new Clipboard('.copy_text_btn', {
        target: function() {
            return copy;
        }
    });

    clipboard.on('success', function(e) {
        layer.msg('已复制',{
                time: 2000
            }
        );
        e.clearSelection();
    });

    clipboard.on('error', function(e) {
        layer.msg('复制失败，请升级或更换浏览器后重新复制！',{
                time: 2000
            }
        );
        e.clearSelection();
    });
};

//获取浏览器名称及版本号
function getExplorerInfo() {
    var explorer = window.navigator.userAgent.toLowerCase();
    //ie
    if (explorer.indexOf("msie") >= 0) {
        var ver = explorer.match(/msie ([\d.]+)/)[1];
        return { type: "IE", version: ver };
    }
    //firefox
    else if (explorer.indexOf("firefox") >= 0) {
        var ver = explorer.match(/firefox\/([\d.]+)/)[1];
        return { type: "Firefox", version: ver };
    }
    //Chrome
    else if (explorer.indexOf("chrome") >= 0) {
        var ver = explorer.match(/chrome\/([\d.]+)/)[1];
        return { type: "Chrome", version: ver };
    }
    //Opera
    else if (explorer.indexOf("opera") >= 0) {
        var ver = explorer.match(/opera.([\d.]+)/)[1];
        return { type: "Opera", version: ver };
    }
    //Safari
    else if (explorer.indexOf("Safari") >= 0) {
        var ver = explorer.match(/version\/([\d.]+)/)[1];
        return { type: "Safari", version: ver };
    }
}

//加入收藏
function AddFavorite(sURL, sTitle) {
    try {
        window.external.addFavorite(sURL, sTitle);
    } catch (e) {
        try {
            window.sidebar.addPanel(sTitle, sURL, "");
        } catch (e) {
            alert("加入收藏失败，请使用Ctrl+D进行添加");
        }
    }
}

//禁止页面滚动