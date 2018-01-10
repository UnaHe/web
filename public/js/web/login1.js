/**
 * Created by tk on 2018/1/4.
 */

login = {
    submit: function (e) {
        $(e).attr('disabled',true);
        $.ajax({
            type: "POST",
            url: formPost,
            data: $('form').serialize(),
            dataType: "json",
            success: function (data) {
                if (data.code==200) {
                    layer.alert('登录成功', {
                        skin: 'layui-layer-lan' //样式类名
                        ,closeBtn: 0
                    },function(){
                      window.location.href=homeUrl;
                    });
                } else {
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

