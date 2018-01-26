/**
 * Created by tk on 2018/1/23.
 */
$(function(){
    //头部登录下拉菜单点击后样式修改
    $('.user_menu').click(function(){
        $(this).css('color','#E1B05A')
    });


    //头部登录下拉菜单
    $(".dropdown-toggle").on("click", function () {
        $(".dropdown-menu").slideDown();
       if(!$(this).hasClass('click_down')){
           $(this).addClass('click_down')
        }else{
           $(".dropdown-menu").slideUp();
           $(this).removeClass('click_down')
       }
    });

    var time=60;
    $("#clock").click(function(){
            if (time < 60) {
                return false;
            }
            var interval = setInterval(function () {
                if (time > 0) {
                    $("#clock").text( time + '秒后获取');
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
                    if (data.code==200) {
                        $("#codeId").val(data.data[0]);
                    } else {
                        layer.alert(data.msg.msg, {
                            skin: 'layui-layer-lan' //样式类名
                            ,closeBtn: 0
                        },function(){
                            window.location.reload()
                        });

                    }
                }
            });

    });
});
