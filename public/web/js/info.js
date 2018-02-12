/**
 * Created by tk on 2018/1/26.
 */
var transLongPicImg = null;
var qrcodeUrl = null;
var longPicChangeSta = true;
$(function(){
    lazyload.init();
    //生成长图,测试中
//     $("#transfer-long-pic").click(function () {
//         var ths = $(this);
//         ths.prop("disabled",true);
//         var longPicCopyLoad = layer.load();
//         if(longPicChangeSta) {
//             console.log("--------------------------------------->")
//             $("#create-pic-tpl-box, #create-pic-view-area").removeClass("long-pic-small");
//         }
//         var t = setInterval(function(){
//             var target = $("#create-pic-view-area");
//             if(target.data("ready") == 'fall'){
//                 //触发自动转微信
//                 console.log('121231__________________')
//                 target.data("ready",'wait');
//                 $("#wx-before-btn").click();//触发转微信
//                 console.log('121231___________2132342_______')
//                 layer.close(longPicCopyLoad); //关闭加载框
//             }
//             if(target.data("ready") == 'error'){
//                 //转微信失败
//                 clearInterval(t);
//                 target.data("ready",'fall');
//                 ths.prop("disabled",false);
//                 layer.close(longPicCopyLoad); //关闭加载框
//             }
//         //     // if(target.data("ready") == 'ok'){
//         //         //转微信成功
//         //         clearInterval(t);
//         //         var setTplEle = "";
//         //         // if(parseInt(img_code) === 1) {
//                     setTplEle = "#create-pic-view-area";
//         //         // }
//                 setLongPic(setTplEle);
//         //
//         //         // qrcodeUrl = sUrl('wx_code');//获取微信链接地址
//         //         //生成大尺寸 二维码
//         //         // if(parseInt(img_code) === 1) {
//         //         //     $("#code").html("");
//         //         //     createQrcode("#code", qrcodeUrl, 140);
//         //         // } else {
//         //         //     $("#create-long-pic-qrcode").html("");
//         //         //     createQrcode("#create-long-pic-qrcode", qrcodeUrl, 325);
//         //         // }
//         //
//                 if(longPicChangeSta) {
//                     console.log("------------------1213232244424--------------------->")
//                     var img=new Image();
//                     console.log(img)
//                     img.src = getLongPicImg();
//                     console.log(img.src+"111111111111111111111111111111111-------------------------------=")
//                     img.onload = function(){
//         //                 //图片加载完你想做的事情
//         //                 //生成图片代码
//                         domtoimage.toJpeg(document.getElementById(setTplEle.replace("#","")), { quality: 0.6 }).then(function (dataUrl) {
//                             transLongPicImg = dataUrl;
//                             console.log("生成后的路径"+transLongPicImg)
//                             console.log(transLongPicImg)
//
//                             //上传图片资料到服务器
//                             ImgBasc64Fun.jsSaveImg(transLongPicImg,function(res){
//                                 console.log(res)
//                                 ths.prop("disabled",false);
//                                 if(res.status == 0){
//                                     var url = ImgBasc64Fun.show(res.data.fileName);
//                                     transLongPicImg = url; //全局生成后的长图链接
//
//                                     $(setTplEle).addClass("long-pic-small"); //每次生成之后设置为小尺寸
//                                     var smallHei = $(setTplEle).height() + 66; //获取小尺寸高度给弹框
//                                     var screenHei = $(window).height() - 100;
//
//
//                                     //弹框高度判断
//                                     if(smallHei - screenHei < 0) {
//                                         dialogHei = smallHei;
//                                     } else {
//                                         dialogHei = screenHei;
//                                     }
//
//                                     //1 为显示默认模板2页面元素， 2 为显示默认模板1页面元素, 3 为显示生成后的图片
//                                     if(parseInt(img_code) === 1) {
//                                         openLongPicTpl(1, "#create-pic-tpl2-box", dialogHei); //打开弹框
//                                     } else {
//                                         openLongPicTpl(1, "#create-pic-tpl-box", dialogHei); //打开弹框
//                                     }
//
//                                     var html = "<img src='" + transLongPicImg + "'>";
//                                     if(document.getElementById('copyInput')){
//                                         //存在复制内容框重置值
//                                         $('#copyInput').html(html);
//                                     }else{
//                                         //不存在复制内容框设置
//                                         var copy = document.createElement('div');
//                                         copy.id = "copyInput";
//                                         copy.innerHTML = html;
//                                         document.body.appendChild(copy);
//                                     }
//
//                                     if (ClipboardSupport == 0) {
//                                         layer.msg('浏览器版本过低，请升级或更换浏览器后重新复制！', {
//                                                 time: 2000
//                                             }
//                                         );
//                                     } else {
//                                         var copy = document.getElementById('copyInput');
//                                         if(!$(this).hasClass('copy_text_btn')){
//                                             $(this).addClass('copy_text_btn');
//                                         }
//                                         copyFunction(copy);
//                                     }
//
//                                     layer.close(longPicCopyLoad); //关闭加载框
//
//                                     //更改修改状态
//                                     longPicChangeSta = false;
//                                 }
//                             },function(){
//                                 ths.prop("disabled",false);
//                                 target.data("ready",'error');
//                                 layer.msg("图片生成失败。请稍后再试");
//                             });
//                         });
//                     }
//                 }else {
//                     //1 为显示页面元素， 2 为显示生成后的图片
//                     if(parseInt(img_code) === 1) {
//                         openLongPicTpl(1, "#create-pic-tpl2-box", dialogHei); //打开弹框
//                     } else {
//                         openLongPicTpl(1, "#create-pic-tpl-box", dialogHei); //打开弹框
//                     }
//                     layer.close(longPicCopyLoad); //关闭加载框
//                 }
//             // }
//         },100);
//         var mtk = document.getElementById('create-pic-tpl-box');
//         mtk.style.display = 'block';
//             html2canvas($("#area-left"), {
//                 onrendered: function (canvas) {
//                     //把截取到的图片替换到a标签的路径下载
//                     $("#download").attr('href', canvas.toDataURL());
//
//                     //下载下来的图片名字
//                     $("#download").attr('download', 'share.jpg');
// //                $('#can_img').attr('src', canvas.toDataURL())
//                     document.body.appendChild(canvas);
//                     var canvas_s=document.getElementsByTagName("canvas");
//                     console.log(canvas_s)
//                     canvas_s[0].style.display='none'
//                 },
//                 backgroundColor: '#FFF',
//             });
//     });



    // function setLongPic(ele){
    //     var target = $(ele);
    //     console.log(target)
    //     var title = $("#title_merchant").html();
    //     console.log(title)
    //     var img = getLongPicImg();
    //     var used_price = $("#used_price").html()+"";
    //     var arr_used = used_price.split('.');
    //     var wenan = $("#wenan").html();
    //     var now_price = $("#now_price").html();
    //     console.log(title,used_price ,arr_used,wenan,now_price,"------------------>>>>>"+img)
    //
    //     // target.find("img").eq(0).prop("src",img);
    //     // target.find(".title").eq(0).text(title);
    // //     if(arr_used[1]){
    // //         target.find(".used-coupon .int").eq(0).html(arr_used[0]+".");
    // //         target.find(".used-coupon .float em").eq(0).html(arr_used[1]);
    // //     target.find(".used-coupon .none").eq(0).html(" ");
    // // }else {
    // //     target.find(".used-coupon .int").eq(0).html(arr_used[0]);
    // // }
    // // target.find(".price .font-arial em").eq(0).html("&yen; "+goods.price);
    // // target.find(".coupon b").eq(0).text(goods.quan_price);
    // // target.find(".sales b").eq(0).text(sellNum);
    // // if(wenan.length > 0) {
    // //     target.find(".wenan span").eq(0).text(wenan);
    // // } else {
    // //     target.find(".wenan").eq(0).hide();
    // // }
    // }
    // function getLongPicImg(){
    //     var img =$("#img_src")[0].currentSrc;
    //     console.log($("#img_src")[0].currentSrc)
    //     return img;
    // }
//点击图片另存为时截取图片
//     $("#pic_save").on('click',function(){
//     <img src='/images/web/gdjcICON.png' />
//     })

///**
// * 设置主图
// */
//$('.images li img').click(function () {
//    var src = $(this).attr('src');
//    $('.sell-tpl-content-img').attr('src', src);
//    $('#img-show').attr('src', src);
//})








    /**
     * 只能复制到文字,外网的图片和本地的图片可以复制,$good['pic']的图片不能复制
     * @type {number}
     */
    var ClipboardSupport = 0;
    if (typeof Clipboard != "undefined") {
        ClipboardSupport = 1;
    } else {
        ClipboardSupport = 0;
    }


//生成长图会用到下面这些变量
    var share_qq_url, share_wx_url, goods_id, share_desc, tao_code, long_url;

    var share_error = '正在加载中!';
//在页面加载时就去请求商品链接信息,复制到变量中,当需要复制的时候立马就能调用
    $(function () {
        $.ajax({
            type: "POST",
            url: transfer_link_url,
            data: $('.qq_form').serialize(),
            dataType: "json",
            success: function (data) {
                if (data.code == 200) {
                    var s_url = data.data.s_url;
                    share_qq_url = "<a href='" + s_url + "' target='_blank'> " + s_url + "</a>";
                    var wechat_url = data.data.wechat_url;
                    share_wx_url = "<a href='" + wechat_url + "' target='_blank'> " + wechat_url + "</a>";
                    goods_id = data.data.goods_id;
                    share_desc = data.data.share_desc;
                    tao_code = data.data.tao_code;
                    long_url = data.data.url;
                    share_error = '';
                } else {
                    share_error = '链接转换失败或请授权';
                }
            }
        });

    })
    //生成图片测试
    //做了授权验证

    // $("#transfer-long-pic").click(function () {
    //     $.ajax({
    //         type: "POST",
    //         url: transfer_link_url,
    //         data: $('.qq_form').serialize(),
    //         dataType: "json",
    //         success: function (data) {
    //             if (data.code == 200) {
    //                 var mtk = document.getElementById('create-pic-tpl-box');
    //                 mtk.style.display = 'block';
    //                 var node = document.getElementById('pic_long');
    //                 console.log(node)
    //                 domtoimage.toPng(node)
    //                     .then(function (dataUrl) {
    //                         var img = new Image();
    //                         img.src = dataUrl;
    //                         console.log(img.src)
    //                         document.body.appendChild(img);
    //                         console.log(img)
    //                         $("#download").attr('href', dataUrl);
    //                         $("#download").attr('download', 'share.jpg');
    //                     });
    //             } else {
    //                 share_error = '链接转换失败或请授权';
    //                 layer.msg(share_error);
    //                 return false;
    //             }
    //         }
    //     });
    //
    // });
    //点击标题跳转淘宝页面
    // $(".short_title").on('click',function(){
    //     window.location.href='https://detail.tmall.com/item.htm?id=42966407474'
    // })
    //修改生成图片背景代码测试
    $("#transfer-long-pic").click(function () {
        var mtk = document.getElementById('create-pic-tpl-box');
        mtk.style.display = 'block';
        var node = document.getElementById('pic_long');
        console.log(node)
        domtoimage.toSvg(node,{ quality: 1 })
            .then(function (dataUrl) {
                var img = new Image();
                img.src = dataUrl;
                console.log(img.src)
                document.body.appendChild(img);
                console.log(img)
                $("#download").attr('href', dataUrl);
                $("#download").attr('download', 'share.jpg');
            });
    })

//    点击模态框任意地方关闭模态框
    $("#create-pic-tpl-box").on('click',function(){
        var mtk = document.getElementById('create-pic-tpl-box');
        mtk.style.display = 'none';
    })
//一键复制QQ文案
    $('.transfer_link').click(function (e) {
        if (share_error != '') {
            layer.msg(share_error);
            return false;
        }
        $('.share_qq_url').html(share_qq_url);
        var copy = document.getElementById('qq-copy-main');
        copyFunction(copy, '.transfer_link', "QQ文案复制成功", e);
    });

//一键复制微信文案
    $('.transfer_wx_link').click(function (e) {
        if (share_error != '') {
            layer.msg(share_error);
            return false;
        }
        $('.share_wx_url').html(share_wx_url);
        var copy = document.getElementById('wx-copy-main');
        copyFunction(copy, '.transfer_wx_link', "微信文案复制成功", e);

    });


//设置一键复制
    var copyFunction = function (copyMain, copyBtn, copyMsg, e) {
        if (ClipboardSupport == 0) {
            alert('浏览器版本过低，请升级或更换浏览器后重新复制！');
        } else {
            var clipboard = new Clipboard(copyBtn, {
                target: function () {
                    return copyMain;
                }
            });

            clipboard.on('success', function (e) {
                layer.msg(copyMsg);
                e.clearSelection();
            });

            clipboard.on('error', function (e) {
                layer.msg(copyMsg);
                e.clearSelection();
            });
        }
    }


//    复制图片
    $("#copy_btn").on("click", function () {
        var mtk = document.getElementById('create-pic-tpl-box');
        mtk.style.display = 'none'
    })



})


