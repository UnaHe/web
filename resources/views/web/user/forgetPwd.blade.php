@extends('web.layouts.password')

@section('title')
    忘记密码
@stop

@section('content')
    <div class="content">
        <div class="step">
            <img src="/images/web/step1.png">
        </div>
        <div class="form-action">
            <form>
                <input type="hidden" id="codeId" name="codeId" value="">
                <input type="text" name="username" id="username" placeholder="请输入手机号码">
                {{--<input type="text" placeholder="验证码">--}}

                <div class="div-input-inline">
                    <input type="text" class="am-form-field input-captcha div-input-inline"
                           name="captcha" placeholder="验证码">&nbsp;&nbsp;&nbsp;

                    <button type="button" class="am-input-group-label div-input-inline" id="clock"
                           >
                        获取手机验证码
                    </button>
                </div>
            </form>
            {{--<input type="submit" class="am-btn  am-btn-sm" onclick="Common.submit(this)" value="下一步">--}}
            <input type="submit" class="am-btn  am-btn-sm" value="下一步">
        </div>
    </div>
@stop

@section('js')
    <script src="/web/js/com.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var getCodeUrl = "{{url('getCode')}}";
        var formPost = "{{url('forgetPwd')}}";
        var url = "{{url('updatePwd')}}";


        $('.am-btn-sm').click(function (e) {
            $(e).attr('disabled', true);
            $.ajax({
                type: "POST",
                url: formPost,
                data: $('form').serialize(),
                dataType: "json",
                success: function (data) {
                    if (data.code == 200) {
                        window.location.href = url;
                    } else {
                        layer.alert(data.msg.msg, {
                            skin: 'layui-layer-lan' //样式类名
                            , closeBtn: 0
                        });
                        $(e).attr('disabled', false);
                    }
                }
            });
        });

    </script>
@stop
