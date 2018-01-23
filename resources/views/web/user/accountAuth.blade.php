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
    <link rel="stylesheet" href="web/css/pyt_land.css"/>
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
                                <li><a href="#">授权管理</a></li>
                                <li><a href="#">账号安全</a></li>
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
                @if(!empty($authInfo))
                    <div>
                        <p class="pyt_ID">您当前授权的联盟账号：<span>{{$authInfo['taobao_user_nick']}}</span></p>
                        <table class="table table-bordered">
                            <tr>
                                <th>选用</th>
                                <th>授权账号</th>
                                <th>QQ渠道PID</th>
                                <th>微信渠道PID</th>
                                <th>剩余授权时间</th>
                                <th>操作</th>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="auth_id"/></td>
                                <td>{{$authInfo['taobao_user_nick']}}</td>
                                <td>{{$authInfo['pids']['qq']==''?'未设置':$authInfo['pids']['qq']}}</td>
                                <td>{{$authInfo['pids']['weixin']==''?'未设置':$authInfo['pids']['weixin']}}</td>
                                <td>{{$authInfo['auth_expire_time']}}</td>
                                <td class="show_model">
                                    <span class="btns change_password" data-toggle="modal" data-target="#myModal"
                                          data-cmd="change_pasword">修改密码</span>
                                    <span class="btns remove_auth" data-toggle="modal" data-target="#myModal_remove"
                                          data-cmd="change_pasword">删除授权</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                @else
                    <div class="pyt_noAuth">
                        <p class="pyt_ID">您当前还未授权，请登录联盟账号授权</p>

                        <button class="login_auth auth-login">登录授权</button>
                    </div>
                @endif
                <p class="state">说明：</p>

                <p class="state">1.使用高效廉洁，需要登录你的淘宝账号进行授权！</p>

                <p class="state">2.一般授权时间为30天，如果中途失败，会提示重新授权！</p>

                <p class="spal_state">3.注意：转换时，务必使用授权的联盟账号中的PID，若PID在授权账号不存在，会廉洁失败。</p>

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
                        <div class="col-sm-6">
                            <p class="popularize"><span class="QQ_color">QQ</span>推广渠道PID</p>
                            <input type="text" class="QQ" name="qq_pid" value="{{!empty($authInfo)?$authInfo['pids']['qq']:''}}"/>
                        </div>
                        <div class="col-sm-6">
                            <p class="popularize"><span class="wx_color">微信</span>推广渠道PID</p>
                            <input type="text" class="WX" name="weixin_pid"  value="{{!empty($authInfo)?$authInfo['pids']['weixin']:''}}"/>
                        </div>
                    </form>

                    <p class="notice notice_color">注意：请登录当前授权的联盟账号查询PID</p>
                    <a href="http://pub.alimama.com/myunion.htm#!/manage/zone/zone?tab=3" target="_blank"><p
                                class="notice al_PID">查询阿里妈妈的PID</p></a>
                    <button class="save stb-btn" data-dismiss="modal">保存</button>
                </div>
            </div>
        </div>
    </div>
    <!-- 删除Modal -->
    <div class="modal fade" id="myModal_remove" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel_remove">信息</h4>
                </div>
                <div class="modal-body">
                    <p class="again_sure">确定删除该授权信息</p>

                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="cancel">取消</button>
                    <button data-dismiss="modal" class="cancel_sure">确定</button>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="web/lib/jquery/dist/jquery.js"></script>
<script src="js/layer/layer.js"></script>
<script src="web/lib/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="web/lib/bootstrapvalidator/dist/js/bootstrapValidator.js"></script>
<script>
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
    var delUrl="{{url('delAuth')}}";
    $(".cancel_sure").on("click", function () {
        //    发送请求
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
                }
            }
        });

    })


//    //获取模态框的值发送请求
//    $(".save").on('click', function () {
//        var qq_val = $(".QQ").val();
//        var WX_val = $(".WX").val();
//        console.log(qq_val, WX_val)
//        //    发送请求
//
//        //    页面恢复初始值
//        var qq_val = $(".QQ").val("");
//        var WX_val = $(".WX").val("");
//    })
//    //删除授权
//
//    $(function () {
//        var auth_id = $('.auth_id');
//        for (var i = 0; i < auth_id.length; i++) {
//            if ($(auth_id[i]).prop('checked')) {
//                $(".cancel_sure").on("click", function () {
//                    //    发送请求
//
//                    alert('11111111111')
//
//
//                })
//            }
//        }
//    })


</script>
</html>