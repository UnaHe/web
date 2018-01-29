@extends('web.layouts.entrance')
@section('title')
    登录
@stop
@section('content')
    <form action="{{url('login')}}" method="post">
        {{csrf_field()}}
        <div class="error">{{ Session::get('error') }}</div>
        <div class="user-name">
            <input type="text" name="username" id="user" placeholder="输入手机号码">
        </div>
        <p class='color_tishi' id='show_user'>请输入手机号<p>
        <div class="user-pass">
            <input type="password" name="password" id="password" placeholder="请输入密码" />
        </div>
       <p class='color_tishi' id='show_pas'>请输入密码<p>
    </form>
    <div class="login-links">
        <a href="{{url('forgetPwd')}}" class="am-fr">忘记密码</a>
        <br/>
    </div>
    <div class="am-cf">
        <input type="button" name="" id="form_submit"  value="登 录" class="am-btn am-btn-primary">
    </div>
@stop
@section('js')
    <script src="/web/lib/bootstrapvalidator/dist/js/bootstrapValidator.js"></script>
    <script type="text/javascript" src="/web/js/com.js"></script>
    <script type="text/javascript" src="/web/js/login.js"></script>
    <script type="text/javascript">
       var formPost="{{url('login')}}";
       var url="{{url('/')}}";
    </script>
@stop
