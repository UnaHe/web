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
@if(!empty($authInfo))
    <div>
        你当前的授权联盟账号:{{$authInfo['taobao_user_nick']}}
    </div>
    <div>
        <table>
            <tr>
                <th>选用</th>
                <th>授权账号</th>
                <th>QQ渠道PID</th>
                <th>微信渠道PID</th>
                <th>剩余授权时间</th>
                <th>操作</th>
            </tr>

            <tr>
                <td><input type="radio" name="taobao_token_id" value=""></td>
                <td>{{$authInfo['taobao_user_nick']}}</td>
                <td>{{$authInfo['pids']['qq']}}</td>
                <td>{{$authInfo['pids']['weixin']}}</td>
                <td>{{$authInfo['auth_expire_time']}}</td>
                <td><a href="javascript:;" class="update-auth">修改PID</a><a href="javascript:;" class="del-auth">删除授权</a>
                </td>
            </tr>

        </table>
        @else
            <div>您当前还未授权,请登录联盟账号授权</div>
            <div>
                <a href="javascript:;" class="auth-login" target="_blank">登录授权</a>
            </div>
        @endif
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

        var delUrl="{{url('delAuth')}}";
        $('.del-auth').click(function () {
            var e = layer.confirm('确定删除该授权信心？', {
                btn: ['取消', '确定'] //按钮
            }, function () {
                layer.close(e);
            }, function () {
                $.ajax({
                    type: "GET",
                    url: delUrl,
                    dataType: "json",
                    success: function (data) {
                        if (data.code == 200) {
                            if (data.data.message) {
                                layer.alert(data.data.message, {
                                    skin: 'layui-layer-lan' //样式类名
                                    , closeBtn: 0
                                }, function () {
                                    if (typeof url != 'undefined') {
                                        window.location.href = url;
                                    } else {
                                        window.location.reload()
                                    }
                                });
                            } else {
                                window.location.reload()
                            }
                        } else {
                            layer.alert(data.msg.msg, {
                                skin: 'layui-layer-lan' //样式类名
                                , closeBtn: 0
                            });
                            $(e).attr('disabled', false);
                        }
                    }
                });


            });


        });

        $('.auth-login').click(function () {
            e = layer.open({
                type: 2,
                title: '授权并登陆',
                shadeClose: true,
                shade: 0.8,
                area: ['760px', '550px'],
                content: "{{url('auth')}}", //iframe的url
            });
        });

        $('.update-auth').click(function () {
            e = layer.open({
                type: 2,
                title: '提示',
                shadeClose: true,
                shade: 0.8,
                area: ['600px', '90%'],
                content: "{{url('updateAuth')}}", //iframe的url
            });
        });
    </script>
</body>
</html>