/**
 * Created by tk on 2018/1/26.
 */

$(function(){
    //生成长图,测试中
    $("#transfer-long-pic").click(function () {
        var mtk = document.getElementById('create-pic-tpl-box');
        mtk.style.display = 'block'
        html2canvas($("#area-left"), {
            onrendered: function (canvas) {
                //把截取到的图片替换到a标签的路径下载
                $("#download").attr('href', canvas.toDataURL());

                //下载下来的图片名字
                $("#download").attr('download', 'share.jpg');
//                $('#can_img').attr('src', canvas.toDataURL())
                document.getElementById('area-left').appendChild(canvas);
            },
            backgroundColor: '#FFF',
//可以带上宽高截取你所需要的部分内容
//     ,
//     width: 300,
//     height: 300
        });
    });


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


