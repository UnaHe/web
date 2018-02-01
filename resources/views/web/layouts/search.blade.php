<nav class="navbar navbar-default container search_nav ">
    <div class="container-fluid pyt_search_nav">
        <div class="navbar-header pyt_navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand pyt_font_size48" href="{{url('/')}}">朋友惠</a><span class="line_pyt"></span>
            <a class="navbar-brand pyt_font_size48 pyt_color" href="{{url('/')}}">Tuike</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
            @if(isset($active)&&!empty($active['active_column_code']))
                <?php $active_column_code = $active['active_column_code'] ?>
            @else
                <?php $active_column_code = 'today_tui' ?>
            @endif
            <form class="navbar-form navbar-left"
                  action="{{url('/columns/'.$active_column_code.'/goods')}}" method="get" id='searchForm'>
                <div class="form-group">
                    <ul class="nav navbar-nav navbar-left">
                        <li class="pyt_searchAll">综合搜索</li>
                    </ul>
                    <input type="text" class="form-control" placeholder="搜索标题、商品ID、商品链接" name="keyword"
                           value="@if(isset($keyword)){{$keyword }} @endif" id='search_value' >
                </div>
                <div  class="btn btn-C"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></div>
            </form>
        </div>
    </div>
</nav>