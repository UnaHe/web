<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>@yield('title')-朋友惠</title>
    <!--设置视口-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-sclable=0">
    <meta name="csrf-token" content="{{csrf_token()}}"/>
    <!-- 设置主题样式-->
    <link rel="stylesheet" href="/web/lib/bootstrap/dist/css/bootstrap.min.css"/>
    <!-- 引入字体样式-->
    <link rel="stylesheet" href="/web/css/com.css"/>

    @section('css')
    @show

</head>
<body>
@section('main')
@show

</body>
<script src="/web/lib/jquery/dist/jquery.js"></script>
<script src="/js/layer/layer.js"></script>
<script src="/web/lib/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/web/js/com.js"></script>

@section('js')
@show

</html>