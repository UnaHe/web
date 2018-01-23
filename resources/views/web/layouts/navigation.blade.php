<nav class="navbar navbar-inverse container-fluid">
    <div class="container">
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-3">
            <ul class="nav navbar-nav pyt_navbar-nav">
                <li class=""><a href="{{url('/')}}">主页</a></li>
                <li class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/columns/today_tui/goods') active @endif">
                    <a href="{{url('/columns/today_tui/goods')}}">今日必推</a></li>
                <li class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/miaosha/goods') active @endif">
                    <a href="{{url('/miaosha/goods')}}">限时快抢</a></li>
                <li class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/columns/today_jing/goods') active @endif">
                    <a href="{{url('/columns/today_jing/goods')}}">今日精选</a></li>
                <li class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/columns/xiaoliangbaokuan/goods') active @endif">
                    <a href="{{url('/columns/xiaoliangbaokuan/goods')}}">爆款专区</a></li>
                <li class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/columns/meishijingxuan/goods') active @endif">
                    <a href="{{url('/columns/meishijingxuan/goods')}}">美食精选</a></li>
                <li class="@if(\Illuminate\Support\Facades\Request::getRequestUri()== '/columns/jiajujingxuan/goods') active @endif">
                    <a href="{{url('/columns/jiajujingxuan/goods')}}">家具精选</a></li>
            </ul>
        </div>
    </div>
</nav>