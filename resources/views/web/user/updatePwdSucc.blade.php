@extends('web.layouts.password')



@section('更改密码')
@stop

@section('content')
    <div class="content">
        <div class="step">
            <img src="/images/web/step3.png">
        </div>
        <div class="form-action">
            <div id="relogin-clock">已完成! (5)秒后自动登录</div>
        </div>
    </div>
@stop

@section('js')
   <script type="text/javascript">
        var time = 5;
        var url="{{url('/')}}";
        var intval = setInterval(function () {
            if (time >=1) {
                time--
                $('#relogin-clock').html('已完成! (' + time + ')秒后自动登录');
            } else {
                clearInterval(intval);
                window.location.href=url;
            }
        }, 1000);
    </script>
@stop


