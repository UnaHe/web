/**
 * Created by tk on 2018/1/26.
 */
var transLongPicImg = null;
var qrcodeUrl = null;
var longPicChangeSta = true;
$(function(){
    lazyload.init();
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
//     function shareSingle() {
//         //获取转链所需值
// //         var taobaoId=$(".taobaoId").val();
// //         var couponId=$(".couponId").val();
// //         var title=$(".title").val();
// //         var description=$(".description").val();
// //         var pic=$(".pic").val();
// //         var priceFull=$(".priceFull").val();
// //         var couponPrice=$(".couponPrice").val();
// //         var sell_num=$(".sell_num").val();
// // console.log(taobaoId,couponId,title,description,pic,priceFull,couponPrice,sell_num)
//         $.ajax({
//             type: "post",
//             url: transfer_link_url,
//             data: $('.qq_form').serialize(),
//             // data:{"taobaoId":'42966407474',"couponId":'b257bb8b4304498d80c57b2c501750ac',"title":'珍视明蒸汽热敷眼罩睡眠 发热加热护眼缓解眼疲劳眼贴近视黑眼圈',"description":'缓解疲劳，保护视力，滋润眼球，促进眼部血液循环，为双眼来场spa。',"pic":'http://img.alicdn.com/imgextra/i1/822280525/TB290W8crBmpuFjSZFAXXaQ0pXa_!!822280525.jpg_480x480',"priceFull":'49',"sell_num":'120206',"couponPrice":'10.00'},
//             // data:{"taobaoId":taobaoId,"couponId":couponId,"title":title,"description":description,"pic":pic,"priceFull":priceFull,"sell_num":sell_num,"couponPrice":couponPrice },
//             dataType: "json",
//             success: function (data) {
//                 console.log(data)
//                 if (data.code == 200) {
//                     var s_url = data.data.s_url;
//                     share_qq_url = "<a href='" + s_url + "' target='_blank'> " + s_url + "</a>";
//                     var wechat_url = data.data.wechat_url;
//                     share_wx_url = "<a href='" + wechat_url + "' target='_blank'> " + wechat_url + "</a>";
//                     goods_id = data.data.goods_id;
//                 share_desc = data.data.share_desc;
//                     tao_code = data.data.tao_code;
//                     long_url = data.data.url;
//                     $("#share_desc").html(share_desc);
//                     $("#hidden_text").html('');
//                     $("#wx_share").html(share_desc);
//                     $("#wx_hidden").html('');
//                     share_error = '';
//                 } else {
//                     share_error = '链接转换失败或请授权';
//                     console.log(123232131)
//                     $("#share_desc").html("111111");
//                     $("#hidden_text").html('');
//                     $("#wx_share").html("111111");
//                     $("#wx_hidden").html('');
//                 }
//             }
//         });
//
//     }
    //生成图片测试
    //做了授权验证
    $("#transfer-long-pic").click(function () {
        $.ajax({
            type: "POST",
            url: transfer_link_url,
            data: $('.qq_form').serialize(),
            dataType: "json",
            success: function (data) {
                if (data.code == 200) {
                    var mtk = document.getElementById('create-pic-tpl-box');
                    mtk.style.display = 'block';
                    var node = document.getElementById('pic_long');
                    console.log(node)
                    domtoimage.toPng(node)
                        .then(function (dataUrl) {
                            var img = new Image();
                            img.src = dataUrl;
                            console.log(img.src)
                            document.body.appendChild(img);
                            console.log(img)
                            $("#download").attr('href', dataUrl);
                            $("#download").attr('download', 'share.jpg');
                        });
                } else {
                    share_error = '链接转换失败或请授权';
                    layer.msg(share_error);
                    return false;
                }
            }
        });

    });
    //修改生成图片背景代码测试
    // $("#transfer-long-pic").click(function () {
    //     var mtk = document.getElementById('create-pic-tpl-box');
    //     mtk.style.display = 'block';
    //     var node = document.getElementById('pic_long');
    //     console.log(node)
    //     domtoimage.toSvg(node,{ quality: 1 })
    //         .then(function (dataUrl) {
    //             var img = new Image();
    //             img.src = dataUrl;
    //             console.log(img.src)
    //             document.body.appendChild(img);
    //             console.log(img)
    //             $("#download").attr('href', dataUrl);
    //             $("#download").attr('download', 'share.jpg');
    //         });
    // })

//    点击模态框任意地方关闭模态框
    $("#create-pic-tpl-box").on('click',function(){
        var mtk = document.getElementById('create-pic-tpl-box');
        mtk.style.display = 'none';
    });
//    点击一键生成显示一键复制
    $("#wx-before-btn").on('click',function(){
      //  请求文案数据
        $.ajax({
            type: "post",
            url: transfer_link_url,
            data: $('.qq_form').serialize(),
            dataType: "json",
            success: function (data) {
                console.log(data)
                if (data.code == 200) {
                    var s_url = data.data.s_url;
                    share_qq_url = "<a href='" + s_url + "' target='_blank'> " + s_url + "</a>";
                    var wechat_url = data.data.wechat_url;
                    share_wx_url = "<a href='" + wechat_url + "' target='_blank'> " + wechat_url + "</a>";
                    goods_id = data.data.goods_id;
                    share_desc = data.data.share_desc;
                    tao_code = data.data.tao_code;
                    long_url = data.data.url;
                    $("#wx_share").html(share_desc);
                    $("#wx_taoCode").html(tao_code);
                    $("#wx_wechatUrl").html(wechat_url);
                    $("#wx_hidden").html('');
                    share_error = '';
                } else {
                    share_error = '链接转换失败或请授权';
                }
            }
        });
      //  显示一键复制
      var wx_before_btns=document.getElementById('wx-before-btns');
        wx_before_btns .style.display='block'
    })
    //   qq击一键生成显示一键复制
    $("#transfer_links").on('click',function(){
        $.ajax({
            type: "post",
            url: transfer_link_url,
            data: $('.qq_form').serialize(),
            dataType: "json",
            success: function (data) {
                console.log(data)
                if (data.code == 200) {
                    var s_url = data.data.s_url;
                    share_qq_url = "<a href='" + s_url + "' target='_blank'> " + s_url + "</a>";
                    var wechat_url = data.data.wechat_url;
                    share_wx_url = "<a href='" + wechat_url + "' target='_blank'> " + wechat_url + "</a>";
                    goods_id = data.data.goods_id;
                    share_desc = data.data.share_desc;
                    tao_code = data.data.tao_code;
                    long_url = data.data.url;
                    $("#share_desc").html(share_desc);
                    $("#qq_taoCode").html(tao_code);
                    $("#qq_wechatUrl").html(wechat_url);
                    $("#hidden_text").html('');
                    share_error = '';
                } else {
                    share_error = '链接转换失败或请授权';
                }
            }
        });
        var wx_before_btns=document.getElementById('transfer_link');
        wx_before_btns .style.display='block'
    })
//一键复制QQ文案
    $('#transfer_link').click(function (e) {
        if (share_error != '') {
            layer.msg(share_error);
            return false;
        }
        console.log(111111111111111)
        $('.share_qq_url').html(share_qq_url);
        var copy = document.getElementById('qq-copy-main');
        copyFunction(copy, '#transfer_link', "QQ文案复制成功", e);
    });

//一键复制微信文案
    $('#wx-before-btns').click(function (e) {
        if (share_error != '') {
            layer.msg(share_error);
            return false;
        }
        $('.share_wx_url').html(share_wx_url);
        var copy = document.getElementById('wx-copy-main');
        copyFunction(copy, '#wx-before-btns', "微信文案复制成功", e);

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


