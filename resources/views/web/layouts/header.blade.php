<header class="pyt_header pyt_hearder_color">
    <nav class="navbar navbar-default  container pyt_hearder_color">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="first_li"><a href="{{url('/')}}">给你的不仅仅是优惠</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right nav_line">
                    @if(\Illuminate\Support\Facades\Auth::check())
                        <li class="dropdown-toggle last_li">
                            <a href="#" class='login_color'>{{\Illuminate\Support\Facades\Auth::user()->phone}}</a>
                            <span class="arr_down"></span>
                        </li>
                        <ul class="dropdown-menu">
                            <li><a href="{{url('/userCenter')}}" class="user_menu">个人中心</a></li>
                            <li><a href="{{url('/accountAuth')}}" class="user_menu">授权管理</a></li>
                            <li><a href="{{url('/accountSecurity')}}"  class="user_menu">账号安全</a></li>
                            <li><a href="{{url('/logout')}}"  class="user_menu">退出</a></li>
                        </ul>
                    @else
                        <li class='last_li'><a href="{{url('login')}}">登录</a></li>
                        {{--<li><a href="{{url('register')}}">注册</a></li>--}}
                    @endif

                    {{--<li><a href="#">企业官网</a></li>--}}
                    <li><a href="{{url('/business')}}" class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/business') header_active @endif " target="_blank">商务合作</a></li>
                    <li><a href="{{url('/aboutUs')}}">关于我们</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>




