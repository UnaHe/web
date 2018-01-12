<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}"/>
    <title>{{$title}} - 朋友推</title>
    <link rel="stylesheet" href="/assets/css/amazeui.css"/>
    <link rel="stylesheet" href="/css/web/datepicker.css"/>
    <style>
    </style>
</head>
<body>
<form action="{{url('/userCenter')}}">
    <div>
        性别:
        <input type="radio" name="sex" value="1">男
        <input type="radio" name="sex" value="2">女
        <input type="radio" name="sex" value="0" checked="checked">保密
    </div>
    <div>
        生日:
        <input type="text" name="birthday" value="@if($user_info){{ $user_info->birthday}} @endif" id="birthday">
    </div>
    <div>
        所在地：<select class="province" name="province"></select><select class="city" name="city"></select><br>
    </div>
    <div>
        联系QQ:
        <input type="text" name="qq_id" value="@if($user_info){{ $user_info->qq_id}} @endif">
    </div>
    <div>
        工作类型:
        <input type="radio" name="work_type" value="1">公司
        <input type="radio" name="work_type" value="2">工作室/团队/其他组织
        <input type="radio" name="work_type" value="3">自由职业
    </div>
    <div>
        单位名称:
        <input type="text" name="company" value="@if($user_info){{ $user_info->company}} @endif">
    </div>
    <div>
        部门或职位:
        <input type="text" name="department" value="@if($user_info){{ $user_info->department}} @endif">
    </div>
    <div>
        工作性质:
        <input type="radio" name="work_nature" value="1">兼职
        <input type="radio" name="work_nature" value="2">全职
    </div>
    <div>
        推广方式:
        <input type="checkbox" name="promotion[]" value="1">QQ群
        <input type="checkbox" name="promotion[]" value="2">微信
        <input type="checkbox" name="promotion[]" value="3">微博
        <input type="checkbox" name="promotion[]" value="4">网站
        <input type="checkbox" name="promotion[]" value="5">APP
        <input type="checkbox" name="promotion[]" value="6">线下推广
    </div>

    <div>
        推广收益:
        <select class="profit" name="profit">
            <option value="">请选择</option>
            @foreach($profits  as $key=>$val)
                <option value="{{$key}}">{{$val}} </option>
            @endforeach
        </select>
    </div>

    <div>
        <button onclick="Common.submit(this)">确认并保存</button>
    </div>

</form>
<script type="text/javascript" src="/js/jquery.3.2.1.js"></script>
<script type="text/javascript" src="/js/layer/layer.js"></script>
<script type="text/javascript" src="/js/web/common.js"></script>
<script type="text/javascript" src="/js/web/datepicker.js"></script>
<script type="text/javascript" src="/js/web/pcas.js"></script>
<script type="text/javascript">
//    生日效果
    $('#birthday').fdatepicker({
        format: 'yyyy-mm-dd',
        endDate: "{{ date('Y-m-d',time()) }}"
    });

//编辑回显
            @if($user_info)
            var sex = "{{ $user_info->sex}}";
    var province = "{{$user_info->province}}";
    var city = "{{$user_info->city}}";
    var work_type = "{{$user_info->work_type}}";
    var work_nature = "{{$user_info->work_nature}}";
    var profit = "{{$user_info->profit}}";

    window.onload = function () {
        $("input[name='sex'][value=" + sex + "]").attr("checked", true);
        $("input[name='work_type'][value=" + work_type + "]").attr("checked", true);
        $("input[name='work_nature'][value=" + work_nature + "]").attr("checked", true);
        $('.profit').val(profit);
        if (province && city) {
            new PCAS("province", "city", province, city);
        }
        @if(!empty($user_info->promotion))
        @foreach($user_info->promotion as $v)
        $("input:checkbox[value="+{{$v}}+"]").attr('checked', 'true');
        @endforeach
        @endif
    }
    @else
//所在地二级联动
        new PCAS("province", "city");
    @endif

//表单ajax提交
    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    var formPost = "{{url('userCenter')}}";
</script>
</body>
</html>