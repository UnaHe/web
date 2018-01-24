@extends('web.layouts.entrance')
@section('title')
    注册
@stop

@section('content')
    <form action="{{url('register')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" id="codeId" name="codeId" value="">


        <div class="user-name form-group">
            <input type="text" name="username" id="username" placeholder="手机号码">
        </div>


        <div class="am-input-group user-captcha  form-group">
            <input type="text" class="am-form-field input-captcha" name="captcha" placeholder="验证码">

            <p class="am-input-group-label" id="clock" onclick="Common.getCode()">获取手机验证码</p>
        </div>


        <div class="user-pass   form-group">
            <input type="password" name="password" id="password" placeholder="输入密码">
        </div>


        <div class="user-pass-confirmation  form-group">
            <input type="password" name="password_confirmation" placeholder="确认密码">
        </div>

    </form>
    <div class="am-cf">
        <input type="submit" name="" onclick="Common.submit(this)" value="注 册"
               class="am-btn am-btn-primary am-btn-sm">
    </div>
@stop

@section('js')
    <script src="js/web/common.js"></script>
    <script src="/web/lib/bootstrapvalidator/dist/js/bootstrapValidator.js"></script>
    <script type="text/javascript">
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var getCodeUrl = "{{url('getCode')}}";
        var formPost = "{{url('register')}}";
        var url = "{{url('login')}}";
        var isExistUrl="{{url('isExist')}}";

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
    </script>

@stop

