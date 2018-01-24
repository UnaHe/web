@extends('web.layouts.entrance')
@section('title')
    登录
@stop
@section('content')
    <form action="{{url('login')}}" method="post">
        {{csrf_field()}}
        <div class="error">{{ Session::get('error') }}</div>
        <div class="user-name">

            <input type="text" name="username" id="user" placeholder="手机号码">
        </div>
        <div class="user-pass">

            <input type="password" name="password" id="password" placeholder="请输入密码">
        </div>

    </form>
    <div class="login-links">
        {{--<label for="remember-me"><input id="remember-me" type="checkbox">记住密码</label>--}}
        <a href="{{url('forgetPwd')}}" class="am-fr">忘记密码</a>
        {{--<a href="register.html" class="zcnext am-fr am-btn-default">注册</a>--}}
        <br/>
    </div>
    <div class="am-cf">
        <input type="submit" name="" id="form_submit" onclick="Common.submit(this)" value="登 录" class="am-btn am-btn-primary am-btn-sm">
    </div>
@stop
@section('js')
    {{--<script type="text/javascript" src="js/web/common.js"></script>--}}
    <script src="/web/lib/bootstrapvalidator/dist/js/bootstrapValidator.js"></script>
    <script type="text/javascript">
       var formPost="{{url('login')}}";
       var url="{{url('/')}}";


//       $(function () {
//           $('form').bootstrapValidator({
//               message: 'This value is not valid',
//               feedbackIcons: {
//                   valid: 'glyphicon glyphicon-ok',
//                   invalid: 'glyphicon glyphicon-remove',
//                   validating: 'glyphicon glyphicon-refresh'
//               },
//               fields: {
//                   username: {
//                       message: '请输入正确的手机号',
//                       validators: {
//                           notEmpty: {
//                               message: '手机号不能为空'
//                           },
//                           stringLength: {
//                               min: 11,
//                               max: 11,
//                               message: '手机号的长度11位'
//                           },
//                           regexp: {
//                               regexp: /^[0-9_\.]+$/,
//                               message: '手机号只能是数字'
//                           },
//                       },
//                   },
//                   //密码验证
//                   password: {
//                       validators: {
//                           notEmpty: {
//                               message: '密码不能为空'
//                           },
//                           stringLength: {
//                               min: 6,
//                               max: 12,
//                               message: '密码长度为6-12位'
//                           },
//                           regexp: {
//                               regexp: /^[a-zA-Z0-9_\.]+$/,
//                               message: '密码只能是字母和数字'
//                           },
//                       }
//                   },
//               }
//           });
//       });

    </script>
@stop
