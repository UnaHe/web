/**
 * Created by tk on 2018/1/26.
 */
//查看本地存储
// var local_username = localStorage["username"];//获取用户名
// var local_password = localStorage["password"];//获取密码
// console.log(local_username,local_password)
// var local_data=[];
// var local_pas=[];
// if(local_username ){
//     local_data.push(local_username)
// }
// if(local_password){
//     local_pas.push(local_password)
// }
// console.log(local_data,local_pas)
//手机号有效性验证
//手机号输入框失去焦点
    //获取输入的手机号
var user_yz=document.getElementById('user');
user_yz.onblur = function(){
    var tv = this.value;
    if(tv==''){
        var show_user=document.getElementById('show_user_s')
        show_user.style.display='block'
    }else{
        var show_user=document.getElementById('show_user_s')
        show_user.style.display='none'
        var reg = /^((13[0-9])|(14[5|7])|(15([0-3]|[5-9]))|(18[0,5-9]))\d{8}$/;
        if (reg.test(tv)){
            var show_user=document.getElementById('show_user')
            show_user.style.display='none'
        }else{
            var show_user=document.getElementById('show_user')
            show_user.style.display='block'
        }
    }
}
var password_yz=document.getElementById('password');
password_yz.onblur = function(){
    var tv = this.value;
    console.log(tv)
    if(tv==''){
        var show_pas=document.getElementById('show_pas_s');
        show_pas.style.display='block'
    } else{
        var show_pas=document.getElementById('show_pas_s');
        show_pas.style.display='none'
            var reg = /^[\w]{6,12}$/;
            if (reg.test(tv)){
                var show_pas=document.getElementById('show_pas');
                show_pas.style.display='none'
            }else{
                var show_pas=document.getElementById('show_pas');
                show_pas.style.display='block'
            }
        }



}
//密码验证


$('#form_submit').on("click",function (e){
    var index = layer.load(1, {
        shade: [0.1,'rgba(224,171,74,1)'],
    });
    //获取输入的手机号
    var user=$("#user").val();
    //获取输入的密码
    var password=$("#password").val();
    if(user!=''&&password!=''){
        $(e).attr('disabled', true);
        $.ajax({
            type: "POST",
            url: formPost,
            data: $('form').serialize(),
            dataType: "json",
            success: function (data) {
                if (data.code == 200) {
                    var msg = data.data.message;
                    msg = msg ? msg : '登录成功';
                    layer.msg(msg);
                    window.location.href = url;
                    //    本地存储用户名和密码
                    // localStorage.setItem("username",user)
                    // localStorage.setItem("password",password)
                    // console.log(window.localStorage)
                }else{
                    var show_pas= document.getElementById('show_pas');
                    show_pas.style.display='block'
                }
            }
        });
    }
})
document.onkeydown=function(e){
    var keycode=document.all?event.keyCode:e.which;
    if(keycode==13){
        var index = layer.load(1, {
            shade: [0.1,'rgba(224,171,74,1)'],
        });
            var user=$("#user").val();
            var password=$("#password").val();
            if(user!=''&&password!=''){
                var index = layer.load(1, {
                    shade: [0.1,'rgba(224,171,74,1)'],
                });
                $(e).attr('disabled', true);
                $.ajax({
                    type: "POST",
                    url: formPost,
                    data: $('form').serialize(),
                    dataType: "json",
                    success: function (data) {
                        if (data.code == 200) {
                            window.location.href = url;
                            layer.close(index);
                        //    本地存储用户名和密码
                        //     localStorage.setItem("username",user)
                        //     localStorage.setItem("password",password)
                        //     console.log(window.localStorage)
                        }else if(data.code!='200'){
                            layer.close(index);
                            console.log(111111111)
                            var show_pas= document.getElementById('show_pas');
                            show_pas.style.display='block'

                        }
                    }
                });
            }
        }

}





//       $(function () {
//           $('form').bootstrapValidator({
//               message: 'This value is not valid',
//               feedbackIcons: {
//                   valid: 'glyphicon glyphicon-ok',
//                   invalid: 'glyphicon glyphicon-remove',
//                   validating: 'glyphicon glyphicon-refresh'
//               },
//               fields: {
//                   username: {
//                       message: '请输入正确的手机号',
//                       validators: {
//                           notEmpty: {
//                               message: '手机号不能为空'
//                           },
//                           stringLength: {
//                               min: 11,
//                               max: 11,
//                               message: '手机号的长度11位'
//                           },
//                           regexp: {
//                               regexp: /^[0-9_\.]+$/,
//                               message: '手机号只能是数字'
//                           },
//                       },
//                   },
//                   //密码验证
//                   password: {
//                       validators: {
//                           notEmpty: {
//                               message: '密码不能为空'
//                           },
//                           stringLength: {
//                               min: 6,
//                               max: 12,
//                               message: '密码长度为6-12位'
//                           },
//                           regexp: {
//                               regexp: /^[a-zA-Z0-9_\.]+$/,
//                               message: '密码只能是字母和数字'
//                           },
//                       }
//                   },
//               }
//           });
//       });
// $('.am-btn-sm').click(function (e) {
//
// });


