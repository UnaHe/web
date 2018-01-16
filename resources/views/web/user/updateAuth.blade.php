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
    你当前的授权联盟账号:咿呀咿呀
</div>
<div>
    <form>
        <table>
            <tr>
                <th>QQ推广渠道PID</th>
                <th>微信推广渠道PID</th>
            </tr>
            <tr>
                <td><input type="text" name="qq_pid" value="{{$authInfo['pids']['qq']}}"></td>
                <td><input type="text" name="weixin_pid" value="{{$authInfo['pids']['weixin']}}"></td>
            </tr>
        </table>
        <div>
            <button type="button" class="stb-btn">保存</button>
        </div>
    </form>
    <div>注意:请登录当前授权的联盟账号查询PID</div>
    <div>
        <a href="http://pub.alimama.com/myunion.htm#!/manage/zone/zone?tab=3" target="_blank">查询阿里妈妈PID</a>
    </div>

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

    var formPost = "{{url('updateAuth')}}";
    $('.stb-btn').click(function () {
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