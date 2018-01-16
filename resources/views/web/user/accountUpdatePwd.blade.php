<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}"/>
    <title>{{$title}} - 朋友推</title>
    <link rel="stylesheet" href="/assets/css/amazeui.css"/>
    <link rel="stylesheet" href="css/web/common.css"/>
    <style>
        input {
            border: 1px solid black;
        }
    </style>
</head>
<body>
<div>预留手机号:{{$user->phone}}</div>
<form>
    <input type="hidden" name="codeId" id="codeId" value="">
    <input type="hidden" id="username" value="{{$user->phone}}">

    <div><input type="text" name="captcha">
        <button type="button" id="clock" onclick="Common.getCode()">发送验证码</button>
    </div>
    <div><input type="password" name="password"></div>
    <div><input type="password" name="password_confirmation"></div>
    <div>
        <button type="button" id="sub-btn">提交</button>
    </div>
</form>

<script type="text/javascript" src="/js/jquery.3.2.1.js"></script>
<script type="text/javascript" src="/js/layer/layer.js"></script>
<script type="text/javascript" src="/js/web/common.js"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var getCodeUrl = "{{url('getCode')}}";
    var formPost = "{{url('accountUpdatePwd')}}";
    var url = "{{url('accountSecurity')}}";

    $('#sub-btn').click(function () {
        $(this).attr('disabled', true);
        $.ajax({
            type: "POST",
            url: formPost,
            data: $('form').serialize(),
            dataType: "json",
            success: function (data) {
                if (data.code == 200) {
                    if (data.data.message) {
                        layer.alert(data.data.message, {
                            skin: 'layui-layer-lan' //样式类名
                            , closeBtn: 0
                        }, function () {
                            parent.window.location.reload();
                        });
                    } else {
                        window.location.reload()
                    }
                } else {
                    layer.alert(data.msg.msg, {
                        skin: 'layui-layer-lan' //样式类名
                        , closeBtn: 0
                    });
                    $(this).attr('disabled', false);
                }
            }
        });
    });


</script>
</body>
</html>