var LONG_PIC = {
    item_list : {
        _tag:{
            name:'图标',
            pan:"＜{name}＞(.*?)＜\/{name}＞",
            reg:"<{tag} class='{class}' {other}>$1</{tag}>",
            pan_back:"<{tag}.*?class=[\'\"]{class}[\'\"].*?>(.*?)<\/{tag}>",
            reg_back:"＜{name}＞$1＜/{name}＞",
            demo_pan : "＜{name}＞(.*?)＜\/{name}＞",
            demo_reg : "<div class='{class} grid-stack-item' data-gs-x='0' data-gs-y='0' data-gs-width='1' data-gs-height='1'><div class='grid-stack-item-content'>$1</div></div>",
            tag:"div",
            class:"common-icons tag-icon",
            other:''
        },
        _title:{
            name:'短标题',
            pan:"＜{name}＞(.*?)＜\/{name}＞",
            reg:"<{tag} class='{class}' {other}>$1</{tag}>",
            pan_back:"<{tag}.*?class=[\'\"]{class}[\'\"].*?>(.*?)<\/{tag}>",
            reg_back:"＜{name}＞$1＜/{name}＞",
            demo_pan : "＜{name}＞(.*?)＜\/{name}＞",
            demo_reg : "<div class='{class} grid-stack-item' data-gs-x='0' data-gs-y='0' data-gs-width='1' data-gs-height='1'><div class='grid-stack-item-content'>$1</div></div>",
            tag:"div",
            class:"title",
            other:''
        },
        _wenan:{
            name:'推广文案',
            pan:"＜{name}＞(.*?)＜\/{name}＞",
            reg:"<{tag} class='{class}' {other}>推广文案<span>$1</span></{tag}>",
            pan_back:"<{tag}.*?class=[\'\"]{class}[\'\"].*?>(.*?)<\/{tag}>",
            reg_back:"＜{name}＞$1＜/{name}＞",
            demo_pan : "＜{name}＞(.*?)＜\/{name}＞",
            demo_reg : "<div class='{class} grid-stack-item' data-gs-x='0' data-gs-y='0' data-gs-width='1' data-gs-height='1'><div class='grid-stack-item-content'>$1</div></div>",
            tag:"div",
            class:"wenan",
            other:''
        },
        _price:{
            name:'商品价格',
            pan:"＜{name}＞(.*?)＜\/{name}＞",
            reg:"<{tag} class='{class}' {other}>原价<span>$1</span></{tag}>",
            pan_back:"<{tag}.*?class=[\'\"]{class}[\'\"].*?>(.*?)<\/{tag}>",
            reg_back:"＜{name}＞$1＜/{name}＞",
            demo_pan : "＜{name}＞(.*?)＜\/{name}＞",
            demo_reg : "<div class='{class} grid-stack-item' data-gs-x='0' data-gs-y='0' data-gs-width='1' data-gs-height='1'><div class='grid-stack-item-content'>$1</div></div>",
            tag:"div",
            class:"price",
            other:''
        },
        _used_price:{
            name:'券后价',
            pan:"＜{name}＞(.*?)＜\/{name}＞",
            reg:"<{tag} class='{class}' {other}>券后&yen;<span>$1</span></{tag}>",
            pan_back:"<{tag}.*?class=[\'\"]{class}[\'\"].*?>(.*?)<\/{tag}>",
            reg_back:"＜{name}＞$1＜/{name}＞",
            demo_pan : "＜{name}＞(.*?)＜\/{name}＞",
            demo_reg : "<div class='{class} grid-stack-item' data-gs-x='0' data-gs-y='0' data-gs-width='1' data-gs-height='1'><div class='grid-stack-item-content'>$1</div></div>",
            tag:"div",
            class:"used-price",
            other:''
        },
        _sale:{
            name:'月销量',
            pan:"＜{name}＞(.*?)＜\/{name}＞",
            reg:"<{tag} class='{class}' {other}>已售<span>$1</span></{tag}>",
            pan_back:"<{tag}.*?class=[\'\"]{class}[\'\"].*?>(.*?)<\/{tag}>",
            reg_back:"＜{name}＞$1＜/{name}＞",
            demo_pan : "＜{name}＞(.*?)＜\/{name}＞",
            demo_reg : "<div class='{class} grid-stack-item' data-gs-x='0' data-gs-y='0' data-gs-width='1' data-gs-height='1'><div class='grid-stack-item-content'>$1</div></div>",
            tag:"div",
            class:"sales",
            other:''
        },
        _coupon_price:{
            name:'优惠券面额',
            pan:"＜{name}＞(.*?)＜\/{name}＞",
            reg:"<{tag} class='{class}' {other}>&yen; $1 元</{tag}>",
            pan_back:"<{tag}.*?class=[\'\"]{class}[\'\"].*?>(.*?)<\/{tag}>",
            reg_back:"＜{name}＞$1＜/{name}＞",
            demo_pan : "＜{name}＞(.*?)＜\/{name}＞",
            demo_reg : "<div class='{class} grid-stack-item' data-gs-x='0' data-gs-y='0' data-gs-width='1' data-gs-height='1'><div class='grid-stack-item-content'>$1</div></div>",
            tag:"div",
            class:"coupon-price",
            other:''
        },
        _img:{
            name:'图片',
            pan:"＜{name}＞(.*?)＜\/{name}＞",
            reg:"<{tag} class='{class}' {other}>$1</{tag}>",
            pan_back:"<{tag}.*?class=[\'\"]{class}[\'\"].*?>(.*?)<\/{tag}>",
            reg_back:"＜{name}＞$1＜/{name}＞",
            demo_pan : "＜{name}＞(.*?)＜\/{name}＞",
            demo_reg : "<div class='{class} grid-stack-item' data-gs-x='0' data-gs-y='0' data-gs-width='1' data-gs-height='1'><div class='grid-stack-item-content'>$1</div></div>",
            tag:"div",
            class:"img",
            other:''
        },
        _qr_code:{
            name:'二维码',
            pan:"＜{name}＞(.*?)＜\/{name}＞",
            reg:"<{tag} class='{class}' {other}><div id='long-pic-qrcode'>$1</div></{tag}>",
            pan_back:"<{tag}.*?class=[\'\"]{class}[\'\"].*?>(.*?)<\/{tag}>",
            reg_back:"＜{name}＞$1＜/{name}＞",
            demo_pan : "＜{name}＞(.*?)＜\/{name}＞",
            demo_reg : "<div class='{class} grid-stack-item' data-gs-x='0' data-gs-y='0' data-gs-width='1' data-gs-height='1'><div class='grid-stack-item-content'>$1</div></div>",
            tag:"div",
            class:"qrcode",
            other:''
        },
    },
    toPan:function(str,item){
        var new_str = str ;
        new_str = new_str.replace(/\{name\}/g,item.name);
        return new RegExp(new_str,'g');
    },
    toReg:function(str,item){
        var new_str = str ;
        new_str = new_str.replace(/\{class\}/g,item.class);
        new_str = new_str.replace(/\{tag\}/g,item.tag);
        new_str = new_str.replace(/\{other\}/g,item.other);
        new_str = new_str.replace(/\{name\}/g,item.name);
        return new_str;
    },
    getItemList:function(target){
        var str = '';
        var tmp = $(target);
        var item;
        function min(arr){
            var minItem = false,ths;
            for(var i = 0;i<arr.length;i++){
                ths = arr.eq(i);
                if(minItem == false){
                    minItem = ths;
                }else {
                    if(ths.offset().top < minItem.offset().top){
                        minItem = ths;
                    }
                    if(ths.offset().top == minItem.offset().top && ths.offset().left < minItem.offset().left){
                        minItem = ths;
                    }
                }
            }
            return minItem;
        }

        while (tmp.length > 0){
            item = min(tmp);
            str += item.html();
            tmp = tmp.not(item[0]);
        }
        return str;
    },
    demo2html2:function(str){
        if($.trim(str) == ''){
            return '';
        }
        var item ;
        for(var i in this.item_list){
            item = this.item_list[i];
            str = str.replace(this.toPan(item.demo_pan,item),this.toReg(item.demo_reg,item));
        }
        return str;
    },
    demo2html:function(str){//纯文本转为html
        if($.trim(str) == ''){
            return '';
        }
        var item ;
        for(var i in this.item_list){
            item = this.item_list[i];
            str = str.replace(this.toPan(item.pan,item),this.toReg(item.reg,item));
        }
        return str;
    },
    html2code:function(target){//对象转为纯文本
        var str = $(target).html();
        if($.trim(str) == ''){
            return '';
        }
        var item ;
        for(var i in this.item_list) {
            item = this.item_list[i];
            str = str.replace(this.toPan(item.pan_back, item), this.toReg(item.reg_back, item));
        }
        return str;
    }
};

var transLongPicImg = null;
var qrcodeUrl = null;
var longPicChangeSta = true;
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





























$(function () {
    //转长图按钮
    var dialogHei;
    $("#transfer-long-pic").on("click", function () {

        var ths = $(this);
        ths.prop("disabled",true);
        var longPicCopyLoad = layer.load();
        //每次生成之前设置为大尺寸

        if(longPicChangeSta) {
            $("#create-pic-view-area, #create-pic-tpl2-area").removeClass("long-pic-small");
            console.log("2222222222222222222")
        }

        var t = setInterval(function(){
            var target = $("#create-pic-view-area");
            if(target.data("ready") == 'fall'){
                //触发自动转微信
                target.data("ready",'wait');
                $("#wx-before-btn").click(function(){
                    console.log("1111111222222222222222233333333333333333333331")
                });//触发转微信
            }
            if(target.data("ready") == 'error'){
                //转微信失败
                clearInterval(t);
                target.data("ready",'fall');
                ths.prop("disabled",false);
                layer.close(longPicCopyLoad); //关闭加载框
            }
            if(target.data("ready") == 'ok'){
                //转微信成功
                clearInterval(t);
                var setTplEle = "";
                if(parseInt(img_code) === 1) {
                    setTplEle = "#create-pic-tpl2-area";
                } else {
                    setTplEle = "#create-pic-view-area";
                }
                setLongPic(setTplEle);

                qrcodeUrl = sUrl('wx_code');//获取微信链接地址
                //生成大尺寸 二维码
                if(parseInt(img_code) === 1) {
                    $("#tpl2-qr-code").html("");
                    createQrcode("#tpl2-qr-code", qrcodeUrl, 140);
                } else {
                    $("#create-long-pic-qrcode").html("");
                    createQrcode("#create-long-pic-qrcode", qrcodeUrl, 325);
                }

                if(longPicChangeSta) {
                    var img=new Image();
                    img.src = getLongPicImg();
                    img.onload = function(){
                        //图片加载完你想做的事情
                        //生成图片代码
                        domtoimage.toJpeg(document.getElementById(setTplEle.replace("#","")), { quality: 0.6 }).then(function (dataUrl) {
                            transLongPicImg = dataUrl;

                            //上传图片资料到服务器
                            ImgBasc64Fun.jsSaveImg(transLongPicImg,function(res){
                                ths.prop("disabled",false);
                                if(res.status == 0){
                                    var url = ImgBasc64Fun.show(res.data.fileName);
                                    transLongPicImg = url; //全局生成后的长图链接

                                    $(setTplEle).addClass("long-pic-small"); //每次生成之后设置为小尺寸
                                    var smallHei = $(setTplEle).height() + 66; //获取小尺寸高度给弹框
                                    var screenHei = $(window).height() - 100;


                                    //弹框高度判断
                                    if(smallHei - screenHei < 0) {
                                        dialogHei = smallHei;
                                    } else {
                                        dialogHei = screenHei;
                                    }

                                    //1 为显示默认模板2页面元素， 2 为显示默认模板1页面元素, 3 为显示生成后的图片
                                    if(parseInt(img_code) === 1) {
                                        openLongPicTpl(1, "#create-pic-tpl2-box", dialogHei); //打开弹框
                                    } else {
                                        openLongPicTpl(1, "#create-pic-tpl-box", dialogHei); //打开弹框
                                    }

                                    var html = "<img src='" + transLongPicImg + "'>";
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

                                    if (ClipboardSupport == 1) {
                                        layer.msg('浏览器版本过低，请升级或更换浏览器后重新复制！', {
                                                time: 2000
                                            }
                                        );
                                    } else {
                                        var copy = document.getElementById('copyInput');
                                        if(!$(this).hasClass('copy_text_btn')){
                                            $(this).addClass('copy_text_btn');
                                        }
                                        copyFunction(copy);
                                    }

                                    layer.close(longPicCopyLoad); //关闭加载框

                                    //更改修改状态
                                    longPicChangeSta = false;
                                }
                            },function(){
                                ths.prop("disabled",false);
                                target.data("ready",'error');
                                layer.msg("图片生成失败。请稍后再试");
                            });
                        });
                    }
                } else {
                    //1 为显示页面元素， 2 为显示生成后的图片
                    if(parseInt(img_code) === 1) {
                        openLongPicTpl(1, "#create-pic-tpl2-box", dialogHei); //打开弹框
                    } else {
                        openLongPicTpl(1, "#create-pic-tpl-box", dialogHei); //打开弹框
                    }
                    layer.close(longPicCopyLoad); //关闭加载框
                }
            }
        },100);
    });

    //复制图片
    $("body").on("click", ".weixin-transfer-long-pic", function () {
        var ClipboardSupport = 0;
        if (typeof Clipboard != "undefined") {
            ClipboardSupport = 1;
        } else {
            ClipboardSupport = 0;
        }

        console.log('1111111111')
        var longPicCopyLoad = layer.load();

        //生成复制元素
        if (ClipboardSupport == 0) {
            layer.msg('浏览器版本过低，请升级或更换浏览器后重新复制！', {
                    time: 2000
                }
            );
        } else {

            var copy = document.getElementById('copyInput');
            if(!$(this).hasClass('copy_text_btn')){
                $(this).addClass('copy_text_btn');
            }
            copyFunction(copy);
        }
        layer.close(longPicCopyLoad);
    });
});

function setLongPic(ele){
    var target = $(ele);
    //判断标题无内容时去掉
    if(!goods.is_tmall) {
        target.find(".icon span").addClass("tb");
    }
    if(goods.is_no_quan){
        target.find(".used-coupon .text").eq(0).text("特惠价").css({color: '#969696','padding-right': '3px'});
        target.find(".price").hide();
        target.find(".coupon").hide();
    }else {
        target.find(".used-coupon .text").eq(0).text("").css({'padding-right': 0});
        target.find(".price").show();
        target.find(".coupon").show();
    }
    var title = $("#js_detail_form input[name='title']").val();
    var img = getLongPicImg();
    var used_price = $("[name='used_price']").val()+"";
    var arr_used = used_price.split('.');
    var wenan = $("[name='wenan']").val();
    var sellNum = $("[name='sell_num']").val();

    target.find("img").eq(0).prop("src",img);
    target.find(".title").eq(0).text(title);
    if(arr_used[1]){
        target.find(".used-coupon .int").eq(0).html(arr_used[0]+".");
        target.find(".used-coupon .float em").eq(0).html(arr_used[1]);
        target.find(".used-coupon .none").eq(0).html(" ");
    }else {
        target.find(".used-coupon .int").eq(0).html(arr_used[0]);
    }
    target.find(".price .font-arial em").eq(0).html("&yen; "+goods.price);
    target.find(".coupon b").eq(0).text(goods.quan_price);
    target.find(".sales b").eq(0).text(sellNum);
    if(wenan.length > 0) {
        target.find(".wenan span").eq(0).text(wenan);
    } else {
        target.find(".wenan").eq(0).hide();
    }
}

function getLongPicImg(){
    var img = $("#js_detail_form input[name='imageSrc']").val();
    img = getOldIme(img);
    return img;
}

function getOldIme(img){
    img = img.replace(/\.jpg(_[0-7]+x[0-7]+\.jpg)/g,'.jpg', '');
    return img;
}

//打开纯图模板
function openLongPicTpl(type, ele, hei) {
    var target = null;
    if(type === 1) {
        target = $(ele).html();
    } else if(type === 2) {
        target = "<img class='pic' src='"+ transLongPicImg +"'/>";
    }
    layer.open({
        type: 1,
        skin: 'transfer-long-pic',
        area: ['645px', hei+"px"],
        title: false,
        shadeClose: true, //点击遮罩关闭
        content: "<div><div class='fl'>"+target+"</div><div class='fl long-pic-btn-group'><div class='icon'><span class='common-icons'></span></div><div class='txt'>图片已生成</div><div id='long-pic-copy' class='copy-btn'><a class='common-bd-xCtJ-count copy-long-pic' data-params='ea=转链-复制长图,gid=' data-fun='transferLongPic' href='javascript:;'>复制图片</a><a class='common-bd-xCtJ-count set-pic-tpl' data-params='ea=转链-设置长图模板,gid=' data-fun='transferLongPic' href='/setCode?s=4' target='_blank'>设置长图模板</a></div><div class='save-local'><a id='download-btn' href='"+transLongPicImg + "' download='"+getUrlName(transLongPicImg)+"'>图片另存为</a></div></div></div>",
        success: function () {
            //生成小尺寸二维码
            if(parseInt(img_code) === 1) {
                $(".transfer-long-pic #tpl2-qr-code").html("");
                createQrcode(".transfer-long-pic #tpl2-qr-code", qrcodeUrl, 70);
            } else {
                $(".transfer-long-pic #create-long-pic-qrcode").html("");
                createQrcode(".transfer-long-pic #create-long-pic-qrcode", qrcodeUrl, 136);
            }
        },
        end: function () {

        }
    });
}

//获取URL名称
function getUrlName(url) {
    if(url.length > 20) {
        url = url.split("/");
        return "qtk" + url[parseInt(url.length) - 1];
    }
}

//生成二维码
function createQrcode(ele, url, size) {
    $(ele).qrcode({
        render: 'canvas',
        width: size,
        height: size,
        text: url,
        correctLevel: 1
    });
}

function unzip(b64Data){
    var strData     = atob(b64Data);
    // Convert binary string to character-number array
    var charData    = strData.split('').map(function(x){return x.charCodeAt(0);});
    // Turn number array into byte-array
    var binData     = new Uint8Array(charData);
    // // unzip
    var data        = pako.inflate(binData);
    // Convert gunzipped byteArray back to ascii string:
    strData     = String.fromCharCode.apply(null, new Uint16Array(data));
    return strData;
}


function zip(str){
    var binaryString = pako.gzip(str, { to: 'string', memLevel:1 });
    return btoa(binaryString);
}