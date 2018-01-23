<header class="pyt_header pyt_hearder_color">
    <nav class="navbar navbar-default  container pyt_hearder_color">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class=""><a href="#">给你的不仅仅是优惠</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @if(\Illuminate\Support\Facades\Auth::check())
                        <li class="dropdown-toggle"><a
                                    href="#">{{\Illuminate\Support\Facades\Auth::user()->phone}}</a>
                        </li>
                        <ul class="dropdown-menu">
                            <li><a href="{{url('/userCenter')}}">个人中心</a></li>
                            <li><a href="{{url('/accountAuth')}}">授权管理</a></li>
                            <li><a href="{{url('/accountSecurity')}}">账号安全</a></li>
                            <li><a href="{{url('/logout')}}">退出</a></li>
                        </ul>
                    @else
                        <li><a href="{{url('login')}}">登录</a></li>
                        <li><a href="{{url('register')}}">注册</a></li>
                    @endif

                    <li><a href="#">企业官网</a></li>
                    <li><a href="{{url('/business')}}">商务合作</a></li>
                    <li><a href="#">微信交流群</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>