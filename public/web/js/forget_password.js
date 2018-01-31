$('#next_tip').click(function (e) {
    var username=$("#username").val();
    var new_id=$("#new_id").val();
    $(e).attr('disabled', true);
    if(username!=''&&new_id!=''){
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
                    layer.msg(data.msg.msg);
                    $(e).attr('disabled', false);
                }
            }
        });
    }
    if(username==''){
        var username_ts=document.getElementById('show_username')
        username_ts.style.display='block'
    }else{
        var username_ts=document.getElementById('show_username');
        username_ts.style.display='none'
    }
    if(new_id==''){
        var username_tss=document.getElementById('username_tss')
        username_tss.style.display='block'
    }else{
        var username_tss=document.getElementById('username_tss');
        username_tss.style.display='none'
    }
});
$('#next_tips').click(function (e) {
    var username=$("#username").val();
    var new_id=$("#new_id").val();
    $(e).attr('disabled', true);
    if(username==new_id){
        var username_tsss=document.getElementById('username_tsss')
        username_tsss.style.display='none'
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
                    layer.msg(data.msg.msg);
                    $(e).attr('disabled', false);
                }
            }
        });
    }else{
        var username_tsss=document.getElementById('username_tsss')
        username_tsss.style.display='block'
    }
    if(username==''){
        var username_ts=document.getElementById('username_ts')
        username_ts.style.display='block'
    }else{
        var username_ts=document.getElementById('username_ts');
        username_ts.style.display='none'
    }
    if(new_id==''){
        var username_tss=document.getElementById('username_tss')
        username_tss.style.display='block'
    }else{
        var username_tss=document.getElementById('username_tss');
        username_tss.style.display='none'
    }
});