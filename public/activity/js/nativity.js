$("#share_btn").on("click",function(){
    var layer=document.getElementById('mengcheng');
    var pid=window.location.href.split('=');
    pid=pid[5];
    // pid='mm_0_0_0';
    $.ajax({
        type: "POST",
        url:'/api/share/activity',
        data: {pid:pid},
        dataType: "json",
        success:function (data) {
            console.log(data)
            var code= data.code;
            if(code===200){
                var info = data.data;
                $("#shorturl").html(info.shortUrl);
                $('#taocode').html(info.taoCode);
            }else{
                alert('请求分享数据信息失败');
            }

        }
    })
    layer.style.display='block'
})

//跳转到支付宝
$("#zfb").on("click",function(){
   //  var pid='y_index/index.html?pid=qwqwq';
   // console.log(pid.split('=')[1])
   var pid=window.location.href.split('=');
    pid=pid[5];
    // window.location.href='https://mos.m.taobao.com/activity_newer?from=tool&sight=pytk&pid='+pid
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
        alert(copyMsg)
    }
//点击微信复制文本
$("#share_btns").on("click",function (e) {
    var copy = document.getElementById('copy_text').innerText;
    copyFunction('#share_btns',copy, "复制成功");
    var layer=document.getElementById('mengcheng');
    layer.style.display='none'
})
//点击生成海报
$('#new_pic').on('click',function(){
    var hb=document.getElementById('haibao');
    hb.style.display='block';
});
$('#save_pic').on('click',function(){
//     html2canvas($("#ee"), {
//         onrendered: function(canvas) {
//     https://mos.m.taobao.com/activity_newer?from=tool&sight=pytk&pid=mm_0_0_0
//             //把截取到的图片替换到a标签的路径下载
//             $("#download").attr('href',canvas.toDataURL());
//             console.log('1111111111111111111111111111111111111111111111-----------------------',canvas.toDataURL())
//             //下载下来的图片名字
//             $("#download").attr('download','share.png') ;
//             document.body.appendChild(canvas);
//         }
// //可以带上宽高截取你所需要的部分内容
//     });
    var hb=document.getElementById('haibao');
    hb.style.display='none';
});
//发请求传pid

