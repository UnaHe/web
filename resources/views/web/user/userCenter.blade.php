<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>{{$title}}-朋友推</title>
    <!--设置视口-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-sclable=0">
    <meta name="csrf-token" content="{{csrf_token()}}"/>
    <!-- 设置主题样式-->
    <link rel="stylesheet" href="/web/lib/bootstrapvalidator/dist/css/bootstrapValidator.min.css">
    <link rel="stylesheet" href="/web/lib/bootstrap/dist/css/bootstrap.min.css"/>
    <!-- 引入字体样式-->
    <link rel="stylesheet" href="/web/css/reset.css"/>
    <link rel="stylesheet" href="/web/css/com.css"/>
    <link rel="stylesheet" href="/web/css/personal_center.css"/>
</head>
<body>
<!--头部-->
<div class="container-fluid">
    @include('web.layouts.header')

            <!--搜索导航栏-->
    @include('web.layouts.search')

            <!--导航-->
    @include('web.layouts.navigation')

            <!--主题部分-->
    <seation class="pyt-seation container-fluid">
        <div class="row  container">
            <div id="tab_personal">
                <span><a href="{{url('userCenter')}}"
                         class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/userCenter')nav_color @endif">个人中心</a></span>
                <span><a href="{{url('accountAuth')}}"
                         class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/accountAuth') nav_color @endif">授权管理</a></span>
                <span><a href="{{url('accountSecurity')}}"
                         class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/accountSecurity') nav_color @endif">账号安全</a></span>
            </div>
            <!-- 中心内容-->
            <form class="user_info">
                <div class="form-group">
                    <label class="col-sm-4 control-label">性别：</label>

                    <div class="col-sm-8 pyt_form-control">
                        <p class="pyt_checkbox">
                            <input type="radio" name="sex" class="pyt_sex" value="1"/>
                            <span>男</span>
                        </p>

                        <p class="pyt_checkbox">
                            <input type="radio" name="sex" class="pyt_sex" value="2"/>
                            <span>女</span>
                        </p>

                        <p class="pyt_checkbox">
                            <input type="radio" name="sex" class="pyt_sex" value="0"/>
                            <span>保密</span>
                        </p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">生日：</label>

                    <div class="col-sm-8">
                        <input type="date" class="form-control birthday" placeholder="请选择生日" name="birthday"
                               value="@if($user_info){{ $user_info->birthday}}@endif"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">所在地：</label>

                    <div class="col-sm-8">
                        <select class="form-control address province" name="province" ></select>
                        <select class="form-control address city" name="city"></select>
                    </div>


                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">联系QQ：</label>

                    <div class="col-sm-8">
                        <input type="text" class="form-control QQnum" name="qq_id"
                               value="@if($user_info){{$user_info->qq_id}}@endif" placeholder="请输入QQ号">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">工作类型：</label>

                    <div class="col-sm-8 pyt_form-control">
                        <p class="pyt_checkbox">
                            <input type="radio" name="work_type" class="pyt_workType" value="1"/>
                            <span>公司</span>
                        </p>

                        <p class="pyt_checkbox pyt_checkbox_other">
                            <input type="radio" name="work_type" class="pyt_workType" value="2"/>
                            <span>工作室/团队/其他组织</span>
                        </p>

                        <p class="pyt_checkbox">
                            <input type="radio" name="work_type" class="pyt_workType" value="3"/>
                            <span>自由职业</span>
                        </p>

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">单位名称：</label>

                    <div class="col-sm-8">
                        <input type="text" class="form-control organization" name="company"
                               value="@if($user_info){{$user_info->company}}@endif" placeholder="请输入单位名称">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">部门或职位：</label>

                    <div class="col-sm-8">
                        <input type="text" class="form-control department" name="department"
                               value="@if($user_info){{$user_info->department}}@endif" placeholder="请输入部门和职位">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">工作性质：</label>

                    <div class="col-sm-8 pyt_form-control">
                        <p class="pyt_checkbox">
                            <input type="radio" name="work_nature" class="pyt_nature" value="1"/>
                            <span>兼职</span>
                        </p>

                        <p class="pyt_checkbox">
                            <input type="radio" name="work_nature" class="pyt_nature" value="2"/>
                            <span>全职</span>
                        </p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">推广方式：</label>

                    <div class="col-sm-8 pyt_form-control">
                        <p class="pyt_checkbox">
                            <input type="checkbox" class="checkbox" name="promotion[]" value="1"/>
                            <span>QQ群</span>
                        </p>

                        <p class="pyt_checkbox">
                            <input type="checkbox" class="checkbox" name="promotion[]" value="2"/>
                            <span>微信</span>
                        </p>

                        <p class="pyt_checkbox">
                            <input type="checkbox" class="checkbox" name="promotion[]" value="3"/>
                            <span>微博</span>
                        </p>

                        <p class="pyt_checkbox">
                            <input type="checkbox" class="checkbox" name="promotion[]" value="4"/>
                            <span>网站</span>
                        </p>

                        <p class="pyt_checkbox">
                            <input type="checkbox" class="checkbox" name="promotion[]" value="5"/>
                            <span>APP</span>
                        </p>

                        <p class="pyt_checkbox">
                            <input type="checkbox" class="checkbox" name="promotion[]" value="6"/>
                            <span>线下推广</span>
                        </p>

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">推广收益：</label>

                    <div class="col-sm-8">
                        <select class="form-control earnings profit" placeholder="请选择收益" name="profit">

                            {{--<option value="">请选择</option>--}}
                            @foreach($profits  as $key=>$val)
                                <option value="{{$key}}">{{$val}} </option>
                            @endforeach

                        </select>

                        <p class="pyt_earnings">您从事淘宝客网络推广的收益</p>
                    </div>
                </div>
            </form>
            <div class="form-group">
                <label class="col-sm-4 control-label"></label>

                <div class="col-sm-8">
                    <button type="button" class="pyt_sub">确认并保存</button>
                </div>
            </div>
        </div>

    </seation>
    <div class="clear"></div>
    <!--页脚-->
    @include('web.layouts.footer')

</div>
</body>
<script src="/web/lib/jquery/dist/jquery.js"></script>
<script src="/js/layer/layer.js"></script>
<script src="/web/lib/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/web/js/com.js"></script>
<script src="/web/lib/bootstrapvalidator/dist/js/bootstrapValidator.js"></script>
<script type="text/javascript" src="/web/js/pcas.js"></script>
<script type="text/javascript" src="/web/js/userCenter.js"></script>

<script>

    var formPost = "{{url('userCenter')}}";

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
        } else {
            new PCAS("province", "city");
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




</script>
</html>