@extends('web.layouts.password')

@section('title')
    忘记密码
@stop

@section('content')
    <div class="content">
        <div class="step">
            <img src="/images/web/step1.png" class="bigwidth">
        </div>
        <div class="form-action">
            <form>
                <input type="hidden" id="codeId" name="codeId" value="">
                <input type="text" name="username" id="username" placeholder="请输入手机号码">
                {{--<input type="text" placeholder="验证码">--}}
                 <p class='username_ts' id='show_username'>请输入手机号</p>
                <div class="div-input-inline">
                    <input type="text" class="am-form-field input-captcha div-input-inline"
                           name="captcha" placeholder="验证码" id='new_id'>&nbsp;&nbsp;&nbsp;

                    <button type="button" class="am-input-group-label div-input-inline" id="clock" >
                        获取手机验证码
                    </button>
                </div>
                     <p class='username_tss' id='username_tss'>请输入验证码</p>
            </form>
            {{--<input type="submit" class="am-btn  am-btn-sm" onclick="Common.submit(this)" value="下一步">--}}
            <input type="button" class="am-btns " value="下一步" id='next_tip'>
        </div>
    </div>
@stop

@section('js')
    <script src="/web/js/com.js"></script>
    <script src="/web/js/forget_password.js"></script>
    <script type="text/javascript">
        var getCodeUrl = "{{url('getCode')}}";
        var formPost = "{{url('forgetPwd')}}";
        var url = "{{url('updatePwd')}}";




    </script>
@stop
