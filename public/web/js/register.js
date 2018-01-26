/**
 * Created by tk on 2018/1/26.
 */
$(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#username').blur(function(){
        var  phone=$('#username').val();
        $.ajax({
            type: "POST",
            url: isExistUrl,
            data: {phone:phone},
            dataType: "json",
            success: function (data) {
                if (data.code!=200)  {
                    layer.alert(data.msg.msg, {
                        skin: 'layui-layer-lan' //样式类名
                        ,closeBtn: 0
                    });
                }
            }
        });
    })


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
