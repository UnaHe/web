@extends('web.layouts.password')

@section('更改密码')
@stop

@section('content')
    <div class="content">
        <div class="step">
            <img src="{{asset('images/web/step2.png')}}">
        </div>
        <div class="form-action">
            <form>

                <input type="password" name="password" id="username" placeholder="请输入新密码">
                <input type="password" name="password_confirmation" id="" placeholder="请再次输入新密码">

            </form>
            <input type="submit" class="am-btn  am-btn-sm"  onclick="Common.submit(this)" value="下一步">
        </div>
    </div>
@stop

@section('js')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formPost = "{{url('updatePwd')}}";
        var url = "{{url('updatePwdSucc')}}";
    </script>
@stop


