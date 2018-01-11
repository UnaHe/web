@extends('web.layouts.goods')

@section('pyt-banner')
    <div class="pyt-banner">
        <!--广告位-->
    </div>
@stop

@if($active['active_column_code']!='meishijingxuan' && $active['active_column_code']!='jiajujingxuan')
@section('category')
    <div class="main category">
        <span>商品分类:</span>
        <a href="{{url('/columns/zhengdianmiaosha/goods')}}">
            <span class="select_cat_id  @if($active['active_category']=='') active @endif" cat_id="">全部</span>
        </a>
        @foreach($categorys as $v)
            <a href="{{url('/columns/'.$active['active_column_code'].'/goods').'?category='.$v->id}}">
    <span class="select_cat_id @if($active['active_category']==$v->id) active @endif"
          cat_id="{{$v->id}}">{{$v->name}}</span>
            </a>
        @endforeach
    </div>
@stop
@endif


@section('screen')
    <div class="main screen">
        <form method="get" action="{{url('/columns/'.$active['active_column_code'].'/goods')}}">
            {{csrf_field()}}
            <span>高级筛选:</span>
            <input class="screen-checkbox" name="today" value="1" type="checkbox"><span>今日新品</span>
            <input class="screen-checkbox" name="isTmall" value="1" type="checkbox" value="11"><span>只看天猫</span>
            <input class="screen-checkbox" name="isJpseller" value="1" type="checkbox"><span>金牌卖家</span>
            <input class="screen-checkbox" name="isQjd" value="1" type="checkbox"><span>旗舰店</span>
            <input class="screen-checkbox" name="isTaoqianggou" value="1" type="checkbox"><span>海抢购</span>
            <input class="screen-checkbox" name="isJuhuashuan" value="1" type="checkbox"><span>聚划算</span>
            <input class="screen-checkbox" name="isNine" value="1" type="checkbox"><span>9.9包邮</span>
            <input class="screen-checkbox" name="isTwenty" value="1" type="checkbox"><span>20元封顶</span>
            <input class="screen-checkbox" name="isJyj" value="1" type="checkbox"><span>极有家</span>
            <input class="screen-checkbox" name="isHaitao" value="1" type="checkbox"><span>海淘</span>
            <input class="screen-checkbox" name="isYfx" value="1" type="checkbox"><span>运费险</span>

            <div class="screen-input-text">
                卷区间:<input type="text" name="minCouponPrice" class="money-input">&nbsp;-&nbsp;<input type="text"
                                                                                                     name="maxCouponPrice"
                                                                                                     class="money-input">
    <span>价格:<input type="text" name="minPrice" class="money-input">&nbsp;-&nbsp;<input type="text"
                                                                                        name="maxPrice"
                                                                                        class="money-input"></span>
                <span>佣金比例><input name="minCommission" type="text"></span>
                <span>销量><input name="minSellNum" type="text"></span>
                <span><button class="screen-btn">筛选</button></span>
            </div>

        </form>
    </div>
@stop

@section('sort')
    <div class="main sort">
        <a href="{{url('/columns/'.$active['active_column_code'].'/goods')}}">
            <div class=" @if($active['active_sort']=='') active @endif ">综合</div>
        </a>
        <a href="{{url('/columns/'.$active['active_column_code'].'/goods').'?sort=2'}}">
            <div class=" @if($active['active_sort']==2) active @endif ">最新</div>
        </a>
        <a href="{{url('/columns/'.$active['active_column_code'].'/goods').'?sort=3'}}">
            <div class=" @if($active['active_sort']==3) active @endif ">销量</div>
        </a>
        <a href="{{url('/columns/'.$active['active_column_code'].'/goods').'?sort=1'}}">
            <div class=" @if($active['active_sort']==1) active @endif ">人气</div>
        </a>
        <a href="{{url('/columns/'.$active['active_column_code'].'/goods').'?sort=-4'}}">
            <div class=" @if($active['active_sort']==-4) active @endif ">价格</div>
        </a>
    </div>
@stop

@section('main')
    <div class="main">
        <!--主体商品遍历部分 start-->
        <div class="wrapper">
            <div class="goods-list clearfix">
                @foreach($list as $k => $v)
                    <div id="goods-items_5069853" data_goodsid="529065425856" data-sellerid="2378275931"
                         class="goods-item ">
                        <div class="goods-item-content">
                            <div class="goods-img">
                                <a href="/goods/{{ $v['id'] }}" target="_blank">
                                    <img class="lazy" src="{{ $v['pic'] }}">
                                </a>
                            </div>
                            <div class="goods-info">
    <span class="goods-tit">
    <a href="/goods/{{ $v['id'] }}" target="_blank">
        {{ $v['short_title']}}
    </a>
    </span>

                                <div class="goods-quan">
                                    <div class="goods-coupon-price">
                                        <span class="goods-coupon">券</span>

                                        <div class="goods-coupon-1">
                                            <span class="goods-coupon-yuan">&nbsp;{{ $v['coupon_price']}}</span>
                                            <span class="goods-coupon-unit">元&nbsp;</span>
                                        </div>
                                    </div>
                                    <div class="goods-sales">
                                        <span class="goods-sales-unit">月销: </span>
                                        <span class="goods-sales-num">{{ $v['sell_num'] }}</span>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="goods-qjy">
                                    <div class="goods-price"><span>券后</span><span
                                                class="rmb-style">￥</span><b>{{ $v['price'] }}</b></div>
                                    <div class="goods-yj"><span>佣金</span><span
                                                class="rmb-style">￥</span><b>{{ $v['commission_finally'] }}</b></div>
                                </div>
                                <div class="@if ($v['is_tmall'] !== 0) icon-tmail @else icon-taobao @endif">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!--主体商品遍历部分 start-->
    </div>
@stop

