/**
 * Created by tk on 2018/1/26.
 */
$(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });




//        $(function () {
//            $('form').bootstrapValidator({
//                message: 'This value is not valid',
//                feedbackIcons: {
//                    valid: 'glyphicon glyphicon-ok',
//                    invalid: 'glyphicon glyphicon-remove',
//                    validating: 'glyphicon glyphicon-refresh'
//                },
//                fields: {
//                    username: {
//                        message: '请输入正确的手机号',
//                        validators: {
//                            notEmpty: {
//                                message: '手机号不能为空'
//                            },
//                            stringLength: {
//                                min: 11,
//                                max: 11,
//                                message: '手机号的长度11位'
//                            },
//                            regexp: {
//                                regexp: /^[0-9_\.]+$/,
//                                message: '手机号只能是数字'
//                            },
//                        },
//                    },
//                    captcha: {
//                        validators: {
//                            notEmpty: {
//                                message: '请输入验证码'
//                            }
//                        }
//                    },
//                    //密码验证
//                    password: {
//                        validators: {
//                            notEmpty: {
//                                message: '密码不能为空'
//                            },
//                            stringLength: {
//                                min: 6,
//                                max: 12,
//                                message: '密码长度为6-12位'
//                            },
//                            regexp: {
//                                regexp: /^[a-zA-Z0-9_\.]+$/,
//                                message: '密码只能是字母和数字'
//                            },
//                        }
//                    },
//                }
//            });
//        });



});

//手机号有效性验证
//手机号输入框失去焦点
//获取输入的手机号
var username_yz=document.getElementById('username');
username_yz.onblur = function(){
    var tv = this.value;
    var reg = /^((13[0-9])|(14[5|7])|(15([0-3]|[5-9]))|(18[0,5-9]))\d{8}$/;
    if (reg.test(tv)){
        var show_user=document.getElementById('show_username')
        show_user.style.display='none'
    }else{
        var show_user=document.getElementById('show_username')
        show_user.style.display='block'
    }
}
var password_yz=document.getElementById('doc-vld-pwd-1-0');
password_yz.onblur = function(){
    var tv = this.value;
    console.log(tv)
    var reg = /^[\w]{6,12}$/;
    if (reg.test(tv)){
        var show_pas=document.getElementById('password_ts');
        show_pas.style.display='none'
    }else{
        var show_pas=document.getElementById('password_ts');
        show_pas.style.display='block'
    }
}
$('#form_submit').on("click",function(){
    var username=$("#username").val();
    var password=$("#doc-vld-pwd-1-0").val();
    var new_password=$("#doc-vld-pwd-2").val();
    var clock=$("#clock_id").val();

    console.log(username,password,new_password,clock)
 if(password==new_password){
     var new_password_tsa=document.getElementById('new_password_tsa');
     new_password_tsa.style.display='none'
        if(username!=''&&password!=''&&new_password!=''&&clock!=''){
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
                    }
                }
            });
        }
 }else{
        var new_password_tsa=document.getElementById('new_password_tsa');
     new_password_tsa.style.display='block'
 }
        if(username==''){
            var show_user=document.getElementById('show_username')
            show_user.style.display='block'
        }else{
            var show_user=document.getElementById('show_username');
            show_user.style.display='none'
        }
        if(password==''){
            var show_pas=document.getElementById('password_ts');
            show_pas.style.display='block'
        }else{
            var show_pas=document.getElementById('password_ts');
            show_pas.style.display='none'
        }
        if(new_password==''){
            var new_passwords=document.getElementById('new_password_ts');
            new_passwords.style.display='block'
        }else{
            var new_passwords=document.getElementById('new_password_ts');
            new_passwords.style.display='none'
        }
        if( clock==''){
            var clocks=document.getElementById('clock_idd');
            clocks.style.display='block'
        }else{
            var clocks=document.getElementById('clock_idd');
            clocks.style.display='none'
        }

})



