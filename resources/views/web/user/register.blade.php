@extends('web.layouts.entrance')
@section('title')
    注册
@stop

@section('content')
    <form action="{{url('register')}}" method="post"  id="form-with-tooltip">
        {{csrf_field()}}
        <input type="hidden" id="codeId" name="codeId" value="">
        <div class="user-name an-form-group">
            <input type="text" name="username" id="username" placeholder="请输入手机号码" data-validation-message='请输入11位的手机号码' pattern="^\d{11}$"' required/>
              <p class='color_tishi' id='show_username'>请输入正确的手机号<p>
        </div>
        <div class="am-input-group user-captcha  form-group">
            <input type="text" class="am-form-fields input-captchas" name="captcha" placeholder="验证码" id='clock_id' required data-foolish-msg="把 验证码交出来！" required id="doc-vld-age-2-1" pattern="^\d{6}$"'/>
            <p class="am-input-group-label clears" id="clock" >获取手机验证码</p>

        </div>
   <p class='color_tishi other_ts' id='clock_idd'>请输入验证码<p>
        <div class="user-pass   am-form-group">
            <input type="password" name="password"  placeholder="输入密码" data-foolish-msg="把 IQ 卡密码交出来！" required id="doc-vld-pwd-1-0" class='clears'>
                <p class='color_tishi' id='password_ts'>密码必须是6-12位的字母或数字<p>
        </div>

        <div class="user-pass-confirmation  am-form-group">
            <input type="password" name="password_confirmation" id="doc-vld-pwd-2" placeholder="输入的密码一致" data-equal-to="#doc-vld-pwd-1" required />
                <p class='color_tishi' id='new_password_ts'>请再次输入密码<p>
                 <p class='color_tishi' id='new_password_tsa'>输入密码不一致<p>
        </div>
    </form>
    <div class="am-cf">
        {{--<input type="button" name="" onclick="Common.submit(this)" value="注 册" class="am-btn am-btn-primary am-btn-sm">--}}
        <button   value="注 册" class="am-btn am-btn-primary" id='form_submit'>注册</button>
    </div>
@stop

@section('js')

    <script type="text/javascript" src="/web/js/com.js"></script>
    <script type="text/javascript" src="/web/js/register.js"></script>
    <script type="text/javascript">
        var getCodeUrl = "{{url('getCode')}}";
        var formPost = "{{url('register')}}";
        var url = "{{url('/')}}";
        var isExistUrl="{{url('isExist')}}";









    </script>

@stop

