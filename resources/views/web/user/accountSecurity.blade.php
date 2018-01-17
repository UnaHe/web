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
</head>
<body>
<div>
    <a href="{{url('userCenter')}}">个人中心</a>
    <a href="{{url('accountAuth')}}">授权管理</a>
    <a href="{{url('accountSecurity')}}">账号安全</a>
</div>
<div>
    登录密码:通过手机进行密码重置
    <button type="button" class="update-pwd">重置</button>
</div>
<script type="text/javascript" src="/js/jquery.3.2.1.js"></script>
<script type="text/javascript" src="/js/layer/layer.js"></script>
<script type="text/javascript" src="/js/web/common.js"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.update-pwd').click(function () {
        e = layer.open({
            type: 2,
            title: '修改密码',
            shadeClose: true,
            shade: 0.8,
            area: ['350px', '320px'],
            content: "{{url('accountUpdatePwd')}}", //iframe的url
        });
    });


</script>
</body>
</html>