<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>{{$title}}-朋友推</title>
    <!--设置视口-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-sclable=0">
    <meta name="csrf-token" content="{{csrf_token()}}"/>
    <!-- 设置主题样式-->
    <link rel="stylesheet" href="web/lib/bootstrap/dist/css/bootstrap.min.css"/>
    <!-- 引入字体样式-->
    <link rel="stylesheet" href="web/css/reset.css"/>
    <link rel="stylesheet" href="web/css/com.css"/>
    <link rel="stylesheet" href="web/css/account.css"/>
</head>
<body>
<!--头部-->
<div class="container-fluid">
    @include('web.layouts.header')

    <!--搜索导航栏-->
    @include('web.layouts.search')

    <!--导航-->
    @include('web.layouts.navigation')

    <!--主题部分-->
    <seation class="pyt-seation container-fluid">
        <div class="row  container">

            <div id="tab_personal">
                <span><a href="{{url('userCenter')}}" class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/userCenter')nav_color @endif" >个人中心</a></span>
                <span><a href="{{url('accountAuth')}}"  class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/accountAuth') nav_color @endif">授权管理</a></span>
                <span><a href="{{url('accountSecurity')}}"  class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/accountSecurity') nav_color @endif">账号安全</a></span>
            </div>
            <!-- 中心内容-->
            <div class="pyt_center">
                <span>登录密码：通过手机号进行密码重置</span>
                <button class=" pyt_change" value="修改" data-toggle="modal" data-target="#myModal">修改</button>
            </div>

        </div>
    </seation>
    <div class="clear"></div>
    <!--页脚-->
    @include('web.layouts.footer')


    <!--模态框-->
    <!-- Modal -->

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">提示</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <p class="change_password">
                            <span class="text">预留手机号：</span>
                            <span class="tel">{{$user->phone}}</span>
                            <input type="hidden" name="codeId" id="codeId" value="">
                            <input type="hidden" id="username" value="{{$user->phone}}">
                        </p>

                        <p class="change_password">
                            <span class="text">验证码：</span>
                            <input type="text" name="captcha"/>
                            <button class="send_num"  type="button" id="clock" >发送验证码</button>
                        </p>
                        <p class="change_password">
                            <span class="text">新密码：</span>
                            <input  type="password" name="password"/>
                        </p>

                        <p class="change_password">
                            <span class="text">确认密码：</span>
                            <input type="password" name="password_confirmation"/>
                        </p>

                        <p class="change_password">
                            <span class="sub_btn" >提交</span>
                        </p>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>


<script src="web/lib/jquery/dist/jquery.js"></script>
<script src="js/layer/layer.js"></script>
<script src="/web/js/com.js"></script>
<script src="web/lib/bootstrap/dist/js/bootstrap.min.js"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var getCodeUrl = "{{url('getCode')}}";
    var formPost = "{{url('accountUpdatePwd')}}";

    $('.sub_btn').click(function () {
        $(this).attr('disabled', true);
        $.ajax({
            type: "POST",
            url: formPost,
            data: $('form').serialize(),
            dataType: "json",
            success: function (data) {
                if (data.code == 200) {
                    var msg=data.data.message==''?'操作成功':data.data.message;
                        layer.alert(msg, {
                            skin: 'layui-layer-lan' //样式类名
                            , closeBtn: 0
                        }, function () {
                            window.location.reload();
                        });
                } else {
                    var msg=data.msg.msg==''?'操作失败':data.msg.msg;
                    layer.alert(msg, {
                        skin: 'layui-layer-lan' //样式类名
                        , closeBtn: 0
                    });
                    $(this).attr('disabled', false);
                }
            }
        });
    });

    <!-- 头部登录下拉菜单-->
    // 模态框
    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').focus()
    })



</script>
</html>