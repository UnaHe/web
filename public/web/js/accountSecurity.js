/**
 * Created by tk on 2018/1/26.
 */

    <!-- 头部登录下拉菜单-->
    // 模态框
    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').focus()
    })


    $("#cc").on("click", function () {
        var mtk = document.getElementById('myModal');
        mtk.style.display = 'none'
    })

//保存新密码
$('.sub_btns').click(function () {
    var yzm= $("#yzm").val();
    var pas=$("#pas").val();
    var pas_agin=$("#pas_agin").val();
    console.log(yzm,pas,pas_agin)
if(pas_agin!=''&&pas!=''&&yzm!=''){
    $(this).attr('disabled', true);
    $.ajax({
        type: "POST",
        url: formPost,
        data: $('form').serialize(),
        dataType: "json",
        success: function (data) {
            if (data.code == 200) {
                var msg = data.data.message == '' ? '操作成功' : data.data.message;
                layer.msg(msg)
                window.location.reload();
                var mtk = document.getElementById('myModal');
                 mtk.style.display = 'none';
                var yzm= $("#yzm").val('');
                var pas=$("#pas").val('');
                var pas_agin=$("#pas_agin").val('');
            } else {
                var yzm= $("#yzm").val('');
                var pas=$("#pas").val('');
                var pas_agin=$("#pas_agin").val('');
                var msg = data.msg.msg == '' ? '操作失败' : data.msg.msg;
                layer.msg(msg)
                $(this).attr('disabled', false);
            }
        }
    });
}
if(yzm==''){
   var tsxx=document.getElementById('tsxx')
     tsxx.style.display='block'
}else if(yzm!=''){
    var tsxx=document.getElementById('tsxx')
    tsxx.style.display='none'
}
if(pas==''){
    var pas=document.getElementById('new_pas')
    pas.style.display='block'
}else if(pas!=''){
    var pas=document.getElementById('new_pas')
    pas.style.display='none'
}
if(pas_agin==''){
    var  pas_agin=document.getElementById('again_pas')
    pas_agin.style.display='block'
}else if(pas_agin!='') {
    var pas_agin = document.getElementById('again_pas')
    pas_agin.style.display = 'none'
}
});