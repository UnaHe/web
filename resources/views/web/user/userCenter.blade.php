<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>{{$title}}-朋友推</title>
    <!--设置视口-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-sclable=0">
    <meta name="csrf-token" content="{{csrf_token()}}"/>
    <!-- 设置主题样式-->
    <link rel="stylesheet" href="web/lib/bootstrap/dist/css/bootstrap.min.css"/>
    <!-- 引入字体样式-->
    <link rel="stylesheet" href="web/css/com.css"/>
    <link rel="stylesheet" href="web/css/personal_center.css"/>
</head>
<body>
<!--头部-->
<div class="container-fluid">
    <header class="pyt_header pyt_hearder_color">
        <nav class="navbar navbar-default  container pyt_hearder_color">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class=""><a href="#">给你的不仅仅是优惠</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown-toggle"><a href="#">1888********</a>
                        </li>
                        <ul class="dropdown-menu">
                            <li><a href="personal_center.html">个人中心</a></li>
                            <li><a href="#">授权管理</a></li>
                            <li><a href="#">账号安全</a></li>
                            <li><a href="#">退出</a></li>
                        </ul>
                        <li><a href="#">注册</a></li>
                        <li><a href="#">企业官网</a></li>
                        <li><a href="#">商务合作</a></li>
                        <li><a href="#">微信交流群</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!--搜索导航栏-->
    <nav class="navbar navbar-default container">
        <div class="container-fluid pyt_search_nav">
            <div class="navbar-header pyt_navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand pyt_font_size48" href="#">朋友推</a>
                <a class="navbar-brand pyt_font_size48 pyt_color" href="#">Tuike</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                <form class="navbar-form navbar-left">
                    <div class="form-group">
                        <ul class="nav navbar-nav navbar-left">
                            <li class="pyt_searchAll">综合搜索</li>
                        </ul>
                        <input type="text" class="form-control" placeholder="搜索标题、商品ID、商品链接">
                    </div>
                    <button type="submit" class="btn btn-default">搜索图</button>
                </form>
            </div>
        </div>
    </nav>
    <!--导航-->
    <nav class="navbar navbar-inverse container-fluid">
        <div class="container">
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-3">
                <ul class="nav navbar-nav pyt_navbar-nav">
                    <li class=""><a href="#">主页</a></li>
                    <li><a href="#">今日必推</a></li>
                    <li><a href="#">限时快抢</a></li>
                    <li><a href="#">今日精选</a></li>
                    <li><a href="#">爆款专区</a></li>
                    <li><a href="#">美食精选</a></li>
                    <li><a href="#">家具精选</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!--主题部分-->
    <seation class="pyt-seation container-fluid">
        <div class="row  container">
            <ul class="nav nav-tabs pyt_nav-tabs" role="tablist">
                <li role="presentation"
                    class=" @if(\Illuminate\Support\Facades\Request::getRequestUri()== '/userCenter')) active @endif"><a
                            href="{{url('userCenter')}}" aria-controls="home" role="tab">个人中心</a></li>
                <li role="presentation"
                    class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/accountAuth')) active @endif"><a
                            href="{{url('accountAuth')}}" aria-controls="profile" role="tab">授权管理</a></li>
                <li role="presentation"
                    class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/accountSecurity')) active @endif">
                    <a href="{{url('accountSecurity')}}" aria-controls="profile" role="tab">账号安全</a></li>

            </ul>
            <!-- 中心内容-->
            <form>
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
                        <select class="form-control address province" name="province" placeholder="请选择所在地">

                        </select>
                        <select class="form-control address city" name="city"></select>
                    </div>


                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">联系QQ：</label>

                    <div class="col-sm-8">
                        <input type="text" class="form-control QQnum" name="qq_id"
                               value="@if($user_info){{$user_info->qq_id}} @endif" placeholder="请输入QQ号">
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
                               value="@if($user_info){{ $user_info->company}} @endif">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">部门或职位：</label>

                    <div class="col-sm-8">
                        <input type="text" class="form-control department" name="department"
                               value="@if($user_info){{ $user_info->department}} @endif">
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
                        <select type="email" class="form-control earnings profit" placeholder="请选择收益" name="profit">

                            <option value="">请选择</option>
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
                    <button type="button" class="pyt_sub" onclick="Common.submit(this)">确认并保存</button>
                </div>
            </div>
        </div>

    </seation>
    <div class="clear"></div>
    <!--页脚-->
    <footer class="container-fluid pyt_footer_box">
        <div class="container pyt_center_footer">
            <ul class="pyt_footer">
                <li>公司官网</li>
                <li>公司官网2</li>
                <li>合作伙伴</li>
                <li>合作伙伴2</li>
            </ul>
            <div class="clear"></div>
            <p class="pyt_remark">2017-2017 www.tkhd.com朋友推--蜀CP备170234号-1 成都推客互动</p>
        </div>

    </footer>
</div>
</body>
<script src="web/lib/jquery/dist/jquery.js"></script>
<script src="js/layer/layer.js"></script>
<script src="web/lib/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="web/lib/bootstrapvalidator/dist/js/bootstrapValidator.js"></script>
<script type="text/javascript" src="web/js/pcas.js"></script>
<script type="text/javascript" src="web/js/common.js"></script>

<script>
    new PCAS("province", "city");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
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
        }
        @if(!empty($user_info->promotion))
        @foreach($user_info->promotion as $v)
        $("input:checkbox[value="+{{$v}}+
        "]"
        ).
        attr('checked', 'true');
        @endforeach
        @endif


    }
    @else
//所在地二级联动
    new PCAS("province", "city");
    @endif


    <!-- 头部登录下拉菜单-->
    $(".dropdown-toggle").on("click", function () {
        $(".dropdown-menu").slideToggle()
    });
    //    //提交表单事件
    //    $(".pyt_sub").on('click',function(){
    //        var sex= $(".pyt_sex");
    //        var birthday=$(".birthday").val();
    //        var address=$(".address").val();
    //        var pyt_workType=$(".pyt_workType");
    //        var pyt_nature=$(".pyt_nature").val();
    //        var department=$(".department").val();
    //        var earnings=$(".earnings").val();
    //        var organization=$(".organization").val();
    //        var QQnum=$(".QQnum").val()
    //        var checkbox=$(".checkbox");
    //        var checked_val,pyt_workType_one;
    //        var checkbox_choice=[];
    //        for(var i=0;i<sex.length;i++){
    //            if($(sex[i]).prop('checked')){
    //                checked_val=$(sex[i]).val()
    //            }
    //        }
    //        for(var i=0;i<pyt_workType.length;i++){
    //            if($(pyt_workType[i]).prop('checked')){
    //                pyt_workType_one=$(pyt_workType[i]).val()
    //            }
    //        }
    //        for(var i=0;i<checkbox.length;i++){
    //            if($(checkbox[i]).prop('checked')){
    //                checkbox_choice.push($(checkbox[i]).val())
    //            }
    //        }
    //        console.log(checked_val,birthday,address,pyt_workType_one,pyt_nature,department,checkbox_choice,earnings,organization,QQnum)
    //
    //        //    发请求
    //
    //
    //
    //
    //
    //        //    表单变为原来的默认值
    //        var birthday=$(".birthday").val("");
    //        var address=$(".address").val("");
    //        var pyt_workType=$(".pyt_workType");
    //        var pyt_nature=$(".pyt_nature").val("");
    //        var department=$(".department").val("");
    //        var earnings=$(".earnings").val("");
    //        var organization=$(".organization").val("");
    //        var QQnum=$(".QQnum").val("")
    //        console.log(checked_val,birthday,address,pyt_workType_one,pyt_nature,department,checkbox_choice,earnings,organization,QQnum)
    //    })

</script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
</html>