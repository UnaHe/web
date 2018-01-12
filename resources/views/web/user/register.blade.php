@extends('web.layouts.entrance')
@section('title')
    注册
@stop

@section('content')
    <form action="{{url('register')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" id="codeId" name="codeId" value="">


        <div class="user-name">
            <input type="text" name="username" id="username" placeholder="手机号码">
        </div>


        <div class="am-input-group user-captcha">
            <input type="text" class="am-form-field input-captcha" name="captcha" placeholder="验证码">

            <p class="am-input-group-label" id="clock" onclick="Common.getCode()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;获取手机验证码&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
        </div>


        <div class="user-pass">
            <input type="password" name="password" id="password" placeholder="输入密码">
        </div>


        <div class="user-pass-confirmation">
            <input type="password" name="password_confirmation" placeholder="确认密码">
        </div>

    </form>
    <div class="am-cf">
        <input type="submit" name="" onclick="Common.submit(this)" value="注 册"
               class="am-btn am-btn-primary am-btn-sm">
    </div>
@stop

@section('js')
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
    </script>
    <script src="js/web/common.js"></script>
@stop

