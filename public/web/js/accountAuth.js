/**
 * Created by tk on 2018/1/26.
 */

$(function () {

    // 模态框
    $('#scsq').on('shown.bs.modal', function () {
        $('#myInput').focus()
    })
    $("#cc").on("click", function () {
        var mtk = document.getElementById('myModal_remove');
        mtk.style.display = 'none'
    })
    /**
     * 删除授权
     */
    $(".cancel_sure").on("click", function () {
        //    发送请求
        $.ajax({
            type: "GET",
            url: delUrl,
            dataType: "json",
            success: function (data) {
                if (data.code == 200) {
                    var msg = data.data.message == '' ? '操作成功' : data.data.message;
                    layer.alert(msg, {
                        skin: 'layui-layer-lan' //样式类名
                        , closeBtn: 0
                    }, function () {
                        if (typeof url != 'undefined') {
                            window.location.href = url;
                        } else {
                            window.location.reload()
                        }
                    });

                } else {
                    var msg = data.msg.msg == '' ? '操作失败' : data.msg.msg;
                    layer.alert(msg, {
                        skin: 'layui-layer-lan' //样式类名
                        , closeBtn: 0
                    });
                }
            }
        });
    })




});

