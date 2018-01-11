@extends('web.layouts.goods')

@section('css')
    <link rel="stylesheet" href="/css/web/zhengdianmiaosha.css"/>
@stop

@section('main')
    <div class="main">
        <div class="step">
            <p class="step_div">
                <img src="/images/web/step_back.png" class="step_back">
            </p>

            <div class="big_step">
                @foreach($time_step as $v)
                    <div class="step-time-div">
                        <span class="step-time">{{$v['time']}}</span>
                        <span class="step-status">{{$v['status']}}</span>
                    </div>
                @endforeach
            </div>
            <p class="step_go_div">
                <img src="/images/web/step_go.png" class="step_go">
            </p>

        </div>
        <!--主体商品遍历部分 start-->
        <div class="wrapper">
            <div class="goods-list clearfix">

                @foreach($list as $key=>$val)
                    <div class="goods-item ">
                        <a href="/goods/{{ $val['id'] }}" target="_blank">
                            <div class="good-img">
                                <img src="{{$val['pic']}}">
                            </div>
                        </a>

                        <div class="good-info">
                            <div class="good-info-msg">
                                <span class="good_short_title">{{$val['short_title']}}</span>
                                <br/>
                                <span class="good_des">{{$val['des']}}</span>
                            </div>
                            <div class="good-info-coupon ">
                                <span class="goods-coupon">券</span>

                                <div class="goods-coupon-1">
                                    <span class="goods-coupon-yuan">&nbsp;{{ $val['coupon_price']}}</span>
                                    <span class="goods-coupon-unit">元&nbsp;</span>
                                </div>
                            </div>

                            <div class="good-info-money">

                                <span class="good-info-money-price">卷后价</span>
                                <span class="good-info-money-profit">预计收益</span>

                            </div>
                            <div class="good-info-money-num">
                                <p class="good-info-money-price-num">¥{{ $val['price']}}</p>

                                <p class="good-info-money-profit-num">¥{{ $val['commission_finally']}}</p>
                            </div>
                            <div class="good-info-action">
                                <div class="good-info-sell-num"><span>{{ $val['sell_num']}}</span>已售</div>
                                <div class="good-info-action-btn">马上推</div>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
        <!--主体商品遍历部分 start-->
    </div>
@stop

@section('js')
    <script type="text/javascript" src="/js/web/zhengdianmiaosha.js">
    </script>
@stop