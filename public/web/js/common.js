/**
 * Created by tk on 2018/1/4.
 */
var time=60;
Common = {
    getCode: function () {
        if (time < 60) {
            return false;
        }

        var interval = setInterval(function () {
            if (time > 0) {
                $("#clock").text( time + '秒');
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
    },

    submit: function (e) {
        $(e).attr('disabled',true);
        $.ajax({
            type: "POST",
            url: formPost,
            data: $('form').serialize(),
            dataType: "json",
            success: function (data) {
                if (data.code==200) {
                    if (data.data.message) {
                        layer.alert(data.data.message, {
                            skin: 'layui-layer-lan' //样式类名
                            , closeBtn: 0
                        },function(){
                            if (typeof url !='undefined') {
                                window.location.href = url;
                            } else {
                                window.location.reload()
                            }
                        });
                    }else{
                        window.location.reload()
                    }
                }else {
                    layer.alert(data.msg.msg, {
                        skin: 'layui-layer-lan' //样式类名
                        ,closeBtn: 0
                    });
                    $(e).attr('disabled',false);
                }
            }
        });
    }

}

