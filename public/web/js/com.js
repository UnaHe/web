/**
 * Created by tk on 2018/1/23.
 */
$(function () {
    //设置csrf-token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /*修改pid提交*/
    $('.sub_btn').click(function () {
        // $(this).attr('disabled', true);
        var QQ_value = $(".QQ").val();
        var WX_value = $(".WX").val();
        if(QQ_value!=''&&WX_value!=''){
            $.ajax({
                type: "post",
                url: formPost,
                data:$('form').serialize(),
                dataType: "json",
                success: function (data) {
                    if (data.code == 200) {
                        var msg = data.data.message == '' ? '操作成功' : data.data.message;
                        layer.msg(msg);
                        var qq_pid=$(".QQ").val("");
                        var weixin_pid=$(".WX").val("");
                        var mtk = document.getElementById('myModals');
                        mtk.style.display = 'none'
                        window.location.reload();
                    } else {
                        var msg = data.msg.msg == '' ? '操作失败' : data.msg.msg;
                        layer.msg(msg);
                        // $(this).attr('disabled', false);
                    }
                }
            });
        }else{
            layer.msg("请输入渠道PID")
        }
    });
    /**
     * 需要跳转的ajax请求
     */
    $('.am-btn-sm').click(function (e) {
        $(e).attr('disabled', true);
        $.ajax({
            type: "post",
            url: formPost,
            data: $('form').serialize(),
            dataType: "json",
            success: function (data) {
                if (data.code == 200) {
                    var msg = data.data.message;
                    msg = msg ? msg : '操作成功';
                    layer.msg(msg);
                    window.location.href = url;
                } else {
                    layer.alert(data.msg.msg, {
                        skin: 'layui-layer-lan' //样式类名
                        , closeBtn: 0
                    });
                    $(e).attr('disabled', false);
                }
            }
        });
    });
    //登录授权
    $('.auth-login').click(function () {
        e = layer.open({
            type: 2,
            title: '授权并登陆',
            shadeClose: true,
            shade: 0.8,
            area: ['760px', '550px'],
            content: authUrl, //iframe的url
        });
    });
    //头部登录下拉菜单点击后样式修改
    $('.user_menu').click(function () {
        $(this).css('color', '#E1B05A')
    });
    //头部登录下拉菜单
    $(".dropdown-toggle").on("click", function () {
        $(".dropdown-menu").slideDown();
        if (!$(this).hasClass('click_down')) {
            $(this).addClass('click_down')
        }else{
            $(".dropdown-menu").slideUp();
            $(this).removeClass('click_down')
        }
    });
    $(".btn-C").on('click',function(){
        $("#searchForm").submit()
    })
    /**
     *获取手机验证码
     */
    var time = 60;
    $("#clock").on("click",function(){
        var username=$("#username").val();
        if(username!=''){
            // var show_user=document.getElementById('show_username');
            // show_user.style.display='none'
            if (time < 60) {
                return false;
            }
            var interval = setInterval(function () {
                if (time > 0) {
                    $("#clock").text(time + '秒后获取');
                    time--;
                } else {
                    clearInterval(interval)
                    $("#clock").html("获取手机验证码");
                    time = 60;
                }
            }, 1000);

            $.ajax({
                type: "POST",
                url: getCodeUrl,
                data: {username: $("#username").val()},
                dataType: "json",
                success: function (data) {
                    if (data.code == 200) {
                        $("#codeId").val(data.data[0]);
                    } else {
                        layer.alert(data.msg.msg, {
                            skin: 'layui-layer-lan' //样式类名
                            , closeBtn: 0
                        }, function () {
                            window.location.reload()
                        });

                    }
                }
            });
        }else{
            var show_user=document.getElementById('show_username')
            show_user.style.display='block'
        }
    })
});

//判断浏览器

function IEVersion() {
    var userAgent = navigator.userAgent; //取得浏览器的userAgent字符串
    var isIE = userAgent.indexOf("compatible") > -1 && userAgent.indexOf("MSIE") > -1; //判断是否IE<11浏览器
    var isEdge = userAgent.indexOf("Edge") > -1 && !isIE; //判断是否IE的Edge浏览器
    var isIE11 = userAgent.indexOf('Trident') > -1 && userAgent.indexOf("rv:11.0") > -1;
    if (isIE) {
        var reIE = new RegExp("MSIE (\\d+\\.\\d+);");
        reIE.test(userAgent);
        var fIEVersion = parseFloat(RegExp["$1"]);
        if (fIEVersion > 9) {
          layer.msg('请升级浏览器哦！！！')
        }
    }
}
