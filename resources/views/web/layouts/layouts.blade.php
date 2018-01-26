<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>{{$title}}-朋友惠</title>
    <!--设置视口-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-sclable=0">
    <!-- 设置主题样式-->
    <link rel="stylesheet" href="/web/lib/bootstrap/dist/css/bootstrap.min.css"/>
    <!-- 引入字体样式-->
    <link rel="stylesheet" href="/web/lib/bootstrap/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/web/css/com.css"/>



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
    <div class="clear"></div>
    <!--页脚-->
    @include('web.layouts.footer')
</div>
</body>
<script src="/web/lib/jquery/dist/jquery.js"></script>
<scrpit src="/web/lib/bootstrap/dist/js/bootstrap.min.js"></scrpit>
<script>
    <!-- 头部登录下拉菜单-->
    $(".dropdown-toggle").on("click", function () {
        $(".dropdown-menu").slideToggle()
    });
    //提交表单事件


</script>
</html>