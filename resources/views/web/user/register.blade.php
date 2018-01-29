@extends('web.layouts.entrance')
@section('title')
    注册
@stop

@section('content')
    <form action="{{url('register')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" id="codeId" name="codeId" value="">
        <div class="user-name form-group">
            <input type="text" name="username" id="username" placeholder="手机号码">
              <p class='color_tishi' id='show_username'>请输入手机号<p>
        </div>
        <div class="am-input-group user-captcha  form-group">
            <input type="text" class="am-form-field input-captcha" name="captcha" placeholder="验证码" id='clock_id'>
            <p class="am-input-group-label" id="clock" >获取手机验证码</p>
        </div>
        <p class='color_tishi' id='clock_idd'>请输入验证码<p>
        <div class="user-pass   form-group">
            <input type="password" name="password" id="password" placeholder="输入密码">
                <p class='color_tishi' id='password_ts'>请输入密码<p>
        </div>

        <div class="user-pass-confirmation  form-group">
            <input type="password" name="password_confirmation" placeholder="确认密码" id='new_password'>
                <p class='color_tishi' id='new_password_ts'>请再次输入密码<p>
        </div>

    </form>
    <div class="am-cf">
        {{--<input type="button" name="" onclick="Common.submit(this)" value="注 册" class="am-btn am-btn-primary am-btn-sm">--}}
        <input type="button"   value="注 册" class="am-btn am-btn-primary" id='form_submit'>
    </div>
@stop

@section('js')
    <script src="/web/lib/bootstrapvalidator/dist/js/bootstrapValidator.js"></script>
    <script type="text/javascript" src="/web/js/com.js"></script>
    <script type="text/javascript" src="/web/js/register.js"></script>
    <script type="text/javascript">
        var getCodeUrl = "{{url('getCode')}}";
        var formPost = "{{url('register')}}";
        var url = "{{url('/')}}";
        var isExistUrl="{{url('isExist')}}";
    </script>

@stop

