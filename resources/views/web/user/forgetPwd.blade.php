<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>忘记密码</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="renderer" content="webkit">
    <meta name="csrf-token" content="{{csrf_token()}}"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="stylesheet" href="{{ asset('css/amazeui.css') }}"/>
    <style>
        body {
            width: 1920px;
            height: auto;
            font-family: MicrosoftYaHei;
        }

        .header {
            width: 1920px;
            height: 200px;
            display: inline;
        }

        .content {
            width: 1920px;
            height: auto;
        }

        .step {
            width: 1920px;
            height: 201px;
        }

        .form-action {
            width: 1920px;
            height: auto;
            position: absolute;
            left: 755px;
            top: 401px;
        }

        /*logo图片与header的div里面的样式*/
        .header div {
            display: inline;
        }

        .header img {
            margin-left: 410px;
            margin-top: 75px;
        }

        .header-nav-first-span {
            position: absolute;
            left: 764px;
            top: 72px;
            display: inline;
            width: 140px;
            height: 31px;
            font-size: 32px;
            color: rgba(51, 51, 51, 1);
            line-height: 31px;
        }

        .header-nav-sec-span {
            position: absolute;
            left: 1300px;
            top: 81px;
            display: inline;
            width: 180px;
            height: 19px;
            line-height: 31px;
        }

        .header-nav-sec-span a {
            font-size: 18px;
            color: rgba(51, 51, 51, 1);
        }

        /*表单样式*/
        form {
            width: 420px;
            text-align: left;
        }

        form input {
            width: 419px;
            height: 50px;
            background: rgba(255, 255, 255, 1);
            margin-bottom: 35px;
            font-size: 24px;
            font-family: MicrosoftYaHei;
            color: rgba(204, 204, 204, 1);
            padding-left: 17px;
        }

        .input-captcha {
            width: 256px;
            font-size: 24px;
            font-family: MicrosoftYaHei;
            color: rgba(204, 204, 204, 1);
            padding-left: 17px;
        }

        form .am-input-group-label:last-child {
            width: 145px;
            height: 50px;
            border: 1px solid #ccc;
            margin-top: -35px;
        }

        .am-btn-sm {
            width: 419px;
            height: 50px;
            background: rgba(224, 171, 74, 1);
            font-size: 24px;
            font-family: MicrosoftYaHei;
            color: rgba(255, 255, 255, 1);
            margin-top: 87px;
        }

    </style>
</head>

<body>
<div class="header">
    <div><a href="#"><img alt="logo" src="{{ asset('images/web/logobig.png') }}"/></a>

        <div>
            <div class="header-nav">
                <div class="header-nav-first-span">找回密码</div>

                <div class="header-nav-sec-span"><a href="{{url('/')}}">首页</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                    <a href="{{url('register')}}">注册</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="{{url('login')}}">登录</a></div>
            </div>
        </div>

        <div class="content">
            <div class="step">
                <img src="{{asset('/images/web/step1.png')}}">
            </div>
            <div class="form-action">
                <form>
                    <input type="hidden" id="codeId" name="codeId" value="">
                    <input type="text" name="username" id="username" placeholder="请输入手机号码">
                    {{--<input type="text" placeholder="验证码">--}}

                    <div style="display: inline">
                        <input type="text" style="display: inline;margin-left: 0px" class="am-form-field input-captcha"
                               name="captcha" placeholder="验证码">&nbsp;&nbsp;&nbsp;

                        <button style="display: inline" type="button" class="am-input-group-label" id="clock"
                                onclick="Register.getCode()">
                            获取手机验证码
                        </button>
                    </div>
                </form>
                <input type="submit" class="am-btn  am-btn-sm" onclick="Register.submit(this)" value="下一步">
            </div>
        </div>
    </div>
</div>


<script src="{{ asset('/js/jquery.2.1.4.js') }}"></script>
<script src="{{ asset('/js/web/register.js') }}"></script>
<script src="{{ asset('/js/layer/layer.js') }}"></script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var getCodeUrl = "{{url('getCode')}}";
    var formPost = "{{url('forgetPwd')}}";
    var url = "{{url('updatePwd')}}";
</script>
</body>
</html>