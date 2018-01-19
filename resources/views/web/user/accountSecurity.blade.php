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
    <link rel="stylesheet" href="web/css/com.css"/>
    <link rel="stylesheet" href="web/css/account.css"/>
</head>
<body>
<!--头部-->
<div class="container-fluid">
    <header class="pyt_header pyt_hearder_color">
        <nav class="navbar navbar-default  container pyt_hearder_color">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class=""><a href="#">给你的不仅仅是优惠</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true" aria-expanded="false">1888*********** <span
                                        class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="personal_center.html">个人中心</a></li>
                                <li><a href="pyt_land.html">授权管理</a></li>
                                <li><a href="account.html">账号安全</a></li>
                                <li><a href="#">退出</a></li>
                            </ul>
                        </li>
                        <li><a href="#">注册</a></li>
                        <li><a href="#">企业官网</a></li>
                        <li><a href="#">商务合作</a></li>
                        <li><a href="#">微信交流群</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!--搜索导航栏-->
    <nav class="navbar navbar-default container">
        <div class="container-fluid pyt_search_nav">
            <div class="navbar-header pyt_navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand pyt_font_size48" href="#">朋友推</a>
                <a class="navbar-brand pyt_font_size48 pyt_color" href="#">Tuike</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                <form class="navbar-form navbar-left">
                    <div class="form-group">
                        <ul class="nav navbar-nav navbar-left">
                            <li class="pyt_searchAll">综合搜索</li>
                        </ul>
                        <input type="text" class="form-control" placeholder="搜索标题、商品ID、商品链接">
                    </div>
                    <button type="submit" class="btn btn-default">搜索图</button>
                </form>
            </div>
        </div>
    </nav>
    <!--导航-->
    <nav class="navbar navbar-inverse container-fluid">
        <div class="container">
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-3">
                <ul class="nav navbar-nav pyt_navbar-nav">
                    <li class=""><a href="#">主页</a></li>
                    <li><a href="#">今日必推</a></li>
                    <li><a href="#">限时快抢</a></li>
                    <li><a href="#">今日精选</a></li>
                    <li><a href="#">爆款专区</a></li>
                    <li><a href="#">美食精选</a></li>
                    <li><a href="#">家具精选</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!--主题部分-->
    <seation class="pyt-seation container-fluid">
        <div class="row  container">
            <ul class="nav nav-tabs pyt_nav-tabs" role="tablist">
                <li role="presentation"
                    class=" @if(\Illuminate\Support\Facades\Request::getRequestUri()== '/userCenter')) active @endif"><a
                            href="{{url('userCenter')}}" aria-controls="home" role="tab">个人中心</a></li>
                <li role="presentation"
                    class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/accountAuth')) active @endif"><a
                            href="{{url('accountAuth')}}" aria-controls="profile" role="tab">授权管理</a></li>
                <li role="presentation"
                    class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/accountSecurity')) active @endif">
                    <a href="{{url('accountSecurity')}}" aria-controls="profile" role="tab">账号安全</a></li>
            </ul>
            <!-- 中心内容-->
            <div class="pyt_center">
                <span>登录密码：通过手机号进行密码重置</span>
                <button class=" pyt_change" value="修改" data-toggle="modal" data-target="#myModal">修改</button>
            </div>

        </div>
    </seation>
    <div class="clear"></div>
    <!--页脚-->
    <footer class="container-fluid pyt_footer_box">
        <div class="container pyt_center_footer">
            <ul class="pyt_footer">
                <li>公司官网</li>
                <li>公司官网2</li>
                <li>合作伙伴</li>
                <li>合作伙伴2</li>
            </ul>
            <div class="clear"></div>
            <p class="pyt_remark">2017-2017 www.tkhd.com朋友推--蜀CP备170234号-1 成都推客互动</p>
        </div>

    </footer>

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
                            <button class="send_num"  type="button" id="clock" onclick="Common.getCode()">发送验证码</button>
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
<script src="web/js/common.js"></script>
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

    <!-- 头部登录下拉菜单-->
    // 模态框
    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').focus()
    })


</script>
</html>