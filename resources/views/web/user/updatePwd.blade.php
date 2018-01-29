@extends('web.layouts.password')

@section('更改密码')
@stop

@section('content')
    <div class="content">
        <div class="step">
            <img src="/images/web/step2.png">
        </div>
        <div class="form-action">
            <form>

                <input type="password" name="password" id="username" placeholder="请输入新密码">
                 <p class='username_ts' id='username_ts'>请输入密码</p>
                <input type="password" name="password_confirmation" id="new_id" placeholder="请再次输入新密码">
                <p class='username_tss' id='username_tss'>请再次输入密码</p>
                  <p class='username_tss' id='username_tsss'>密码不一致</p>
            </form>

            <input type="button" class="am-btns" value="下一步" id='next_tips'>
        </div>
    </div>
@stop

@section('js')
    <script src="/web/js/com.js"></script>
       <script src="/web/js/forget_password.js"></script>
    <script type="text/javascript">
        var formPost = "{{url('updatePwd')}}";
        var url = "{{url('updatePwdSucc')}}";
    </script>
@stop


