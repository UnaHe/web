/**
 * Created by tk on 2018/1/26.
 */

$(function () {
    //删除模态框
    $("#amyModal_remove").on("click",function(){
        var choice= $(".xz");
        console.log(choice)
            for(var i=0;i<choice.length;i++){
                if($(choice[i]).prop('checked')){
                    var mtk = document.getElementById('myModal_remove');
                    mtk.style.display = 'block'
                }else{
                    var tishi=document.getElementById('xgzhs');
                    tishi.style.display='block';
                    setTimeout(function(){
                        tishi.style.display='none';
                    },1000)
                }
            }
    })
    $("#cc").on("click", function () {
        var mtk = document.getElementById('myModals');
        mtk.style.display = 'none'
    })
    $("#ccc").on("click", function () {
        var mtk = document.getElementById('myModal_remove');
        mtk.style.display = 'none'
    })
    //取消删除
    $(".cancel").on("click",function(){
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
                    layer.msg(msg, {
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
        var mtk = document.getElementById('myModal_remove');
        mtk.style.display = 'none'
    })
// 修改模态框
    $("#amyModal").on("click",function(){
        var choice= $(".xz");
        for(var i=0;i<choice.length;i++){
            if($(choice[i]).prop('checked')){
                var mtk = document.getElementById('myModals');
                mtk.style.display = 'block'
            }else{
               var tishi=document.getElementById('xgzh');
               tishi.style.display='block';
                setTimeout(function(){
                    tishi.style.display='none';
                },1000)
            }
        }
    })
});

// // //保存pid   com.js中已经做过
// $("#save").on('click',function() {
//     var QQ_value = $(".QQ").val();
//     var WX_value = $(".WX").val();
//     console.log(QQ_value,WX_value)
//     //    发送请求
//     $.ajax({
//         type: "POST",
//         url: formPost,
//         data: {weixin_pid:WX_value,qq_pid:QQ_value},
//         dataType: "json",
//         success: function (data) {
//             console.log(data)
//         }
//     })
// })

