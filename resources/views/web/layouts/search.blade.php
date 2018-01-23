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
            <a class="navbar-brand pyt_font_size48" href="{{url('/')}}">朋友推</a>
            <a class="navbar-brand pyt_font_size48 pyt_color" href="{{url('/')}}">Tuike</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
            <form class="navbar-form navbar-left"
                  action="{{url('/columns/'.$active['active_column_code'].'/goods')}}" method="get">
                <div class="form-group">
                    <ul class="nav navbar-nav navbar-left">
                        <li class="pyt_searchAll">综合搜索</li>
                    </ul>
                    <input type="text" class="form-control" placeholder="搜索标题、商品ID、商品链接" name="keyword"
                           value="@if(isset($keyword)){{$keyword }} @endif">

                </div>
                <button type="submit" class="btn btn-default">搜索图</button>
            </form>
        </div>
    </div>
</nav>