var userShareInfo = null;
//跳转到支付宝
$("#zfb").on("click",function(){
   var pid=window.location.href.split('pid=');
    pid=pid[1].split('&');
    pid=pid[0];
    window.location.href='https://mos.m.taobao.com/activity_newer?from=tool&sight=pytk&pid='+pid
})
//设置一键复制
var copyFunction = function (copyBtn,text, copyMsg) {
    console.log(text)
        var clipboard = new Clipboard(copyBtn, {
            text: function(){
               return text;
            }
        });
        clipboard.on('success', function (e) {
            e.clearSelection();
        });
        clipboard.on('error', function (e) {
            e.clearSelection();
        });
        layer.open({
            content: copyMsg,
            yes: function () {
                location.reload();
            }
        });
    }
//点击微信复制文本
$("#share_btns").on("click",function (e) {
    var copy = document.getElementById('copy_text').innerText;
    copyFunction('#share_btns',copy, "复制成功");
    var layer=document.getElementById('mengcheng');
    layer.style.display='none'
});
function loadUserLinkInfo(pid,cb){
    if(userShareInfo){
        cb(userShareInfo);
    }else {
        layer.open({type: 2});
        $.ajax({
            type: "POST",
            url: '/api/share/activity',
            data: {pid: pid},
            dataType: "json",
            success: function (data) {
                console.log(data);
                var code = data.code;
                if (code === 200) {
                    layer.closeAll();
                    var info = data.data;
                    userShareInfo = info;
                    cb(info);
                    $("#code").qrcode({
                        render:"table",
                        width:140,
                        height:140,
                        text:info.shortUrl
                    });
                } else {
                    layer.closeAll();
                    layer.open({
                        content: '请求分享数据信息异常',
                        btn: '重载',
                        yes: function () {
                            location.reload();
                        }
                    });
                }
            },
            error:function(){
                layer.closeAll();
                layer.open({
                    content: '请求分享数据信息异常',
                    btn: '重载',
                    yes: function () {
                        location.reload();
                    }
                });
            }
        });
    }
};
$("#share_btn").on("click",function(){
    var pid=window.location.href.split('pid=');
    pid=pid[1].split('&');
    pid=pid[0];
    loadUserLinkInfo(pid,function(info){
        var hb=document.getElementById('haibao');
        hb.style.display='block';
        $("#shorturl").html(info.shortUrl);
    $("#taocode").html(info.taoCode);
    layer.closeAll();
    });
});
//点击生成海报
$('#new_pic').on('click',function(){
    console.log(111111111111111)
    var pid=window.location.href.split('pid=');
    pid=pid[1].split('&');
    pid=pid[0];
    loadUserLinkInfo(pid,function(info){
        var hb=document.getElementById('haibao');
        hb.style.display='block';
        layer.closeAll();
    });
});
$('#save_pic').on('click',function(){
    var hb=document.getElementById('haibao');
    hb.style.display='none';
});
$("#mengcheng").on("click",function(){
    var layer=document.getElementById('mengcheng');
    layer.style.display='none'
})

