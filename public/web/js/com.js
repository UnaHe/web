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

    /**
     * 主要的POST提交请求
     */
    $('.sub_btn').click(function () {
        $(this).attr('disabled', true);
        $.ajax({
            type: "POST",
            url: formPost,
            data: $('form').serialize(),
            dataType: "json",
            success: function (data) {
                if (data.code == 200) {
                    var msg = data.data.message == '' ? '操作成功' : data.data.message;
                    layer.msg(msg);
                    window.location.reload();
                } else {
                    var msg = data.msg.msg == '' ? '操作失败' : data.msg.msg;
                    layer.msg(msg);
                    $(this).attr('disabled', false);
                }
            }
        });
    });
    /**
     * 需要跳转的ajax请求
     */
    $('.am-btn-sm').click(function (e) {
        $(e).attr('disabled', true);
        $.ajax({
            type: "POST",
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
        } else {
            $(".dropdown-menu").slideUp();
            $(this).removeClass('click_down')
        }
    });
//兼容placeholder----------------------IE版
//     $(function () {
//         jQuery('[placeholder]').focus(function () {
//             var input = jQuery(this);
//             if (input.val() == input.attr('placeholder')) {
//                 input.val('');
//                 input.removeClass('placeholder');
//             }
//         }).blur(function () {
//             var input = jQuery(this);
//             if (input.val() == '' || input.val() == input.attr('placeholder')) {
//                 input.addClass('placeholder');
//                 input.val(input.attr('placeholder'));
//             }
//         }).blur().parents('form').submit(function () {
//             jQuery(this).find('[placeholder]').each(function () {
//                 var input = jQuery(this);
//                 if (input.val() == input.attr('placeholder')) {
//                     input.val('');
//                 }
//             })
//         });
//     })

    $(".btn-C").on('click',function(){
        $("#searchForm").submit()
      // var input_value=document.getElementById('search_value').value;
      // var search_url=document.getElementsByTagName('form');
      // search_url=search_url[0].action;
      // console.log(search_url)
      // if(input_value!=''){
      //     console.log("1111111111222222222222")
      //     $.ajax({
      //         type:"GET",
      //         url:'goods/'+"?keyword="+input_value,
      //
      //         dataType:"JSON",
      //         success:function(data){
      //             console.log("1111111111")
      //             console.log(data)
      //         }
      //     })
      //     console.log("00000000000000")
      // }else{
      //     layer.msg("请输入搜索词")
      // }
    })
    /**
     *获取手机验证码
     */
    var time = 60;
    $("#clock").on("click",function(){
        var username=$("#username").val();
        if(username!=''){
            var show_user=document.getElementById('show_username');
            show_user.style.display='none'
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
