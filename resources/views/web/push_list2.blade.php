@extends('web.layouts.com')

@section('title')
{{$title}}
@stop

@section('css')
<link rel="stylesheet" href="/web/css/choiceness.css"/>
@stop


@section('main')
<div class="container-fluid">
    @include('web.layouts.header')
    <!--搜索导航栏-->
    @include('web.layouts.search')
    <!--导航-->
    @include('web.layouts.navigation')
    <!--主题部分-->
    <seation class="pyt-seation container-fluid">
        <div class="row  container">
            <!-- 中心内容-->
            <!--图片-->
            <div class="img_door">
                <img src="/web/images/push_banner.jpg" alt="...">
            </div>
            @if($active['active_column_code']!='meishijingxuan' && $active['active_column_code']!='jiajujingxuan')
            <div class="prod_type_box ">
                <p class="prod_type">商品分类：</p>
                <ul class="prod_type_list margin_left4">
                    <a href="{{url('/columns/'.$active['active_column_code'].'/goods')}}" class="click_open">
                        <li class="@if($active['active_category']=='') active @endif">全部</li>
                    </a>
                    @foreach($categorys as $v)
                    <a href="{{url('/columns/'.$active['active_column_code'].'/goods').'?category='.$v->id}}"
                       class="click_open">
                        <li class="@if($active['active_category']==$v->id) active @endif">{{$v->name}}</li>
                    </a>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="prod_type_box line_30">
                <form method="get" action="{{url('/columns/'.$active['active_column_code'].'/goods')}}">
                    {{csrf_field()}}
                    <p class="prod_type">高级筛选：</p>
                    <div class="scree_box">
                        <ul class=" margin_right">
                            <li><input type="checkbox" name="today" value="1" id='today' class='inputs'/><label
                                    class='hiddens' for="today"></label><span class='show_title'>今日新品</span>
                                     <p class='today_new_pro'></p>
                            </li>

                            <li><input type="radio" name="isTmall" value="1" id='isTmall'
                                       class='inputs team2'/><label
                                    class='hiddens ' for="isTmall"></label><span
                                    class='show_title'>只看天猫</span>
                            </li>
                            <li><input type="radio" name="isJpseller" value="1" id='isJpseller'
                                       class='inputs team2'/><label class='hiddens' for="isJpseller"></label><span
                                    class='show_title'>金牌卖家</span></li>
                            <li><input type="radio" name="isQjd" value="1" id='isQjd'
                                       class='inputs team2'/><label
                                    class='hiddens ' for="isQjd"></label><span
                                    class='show_title'>旗舰店</span>
                                     <p class='today_new_pro2'></p>
                            </li>
                            <li><input type="radio" name="isTaoqianggou" value="1" id='isTaoqianggou'
                                       class='inputs team3'/><label class='hiddens' for="isTaoqianggou"></label><span
                                    class='show_title'>淘抢购</span></li>
                            <li><input type="radio" name="isJuhuashuan" value="1" id='chechboxs5'
                                       class='inputs team3'/><label class='hiddens' for="chechboxs5"></label><span
                                    class='show_title'>聚划算</span>
                                     <p class='today_new_pro5'></p></li>
                            <li><input type="radio" name="isNine" value="1" id='chechboxs6'
                                       class='inputs team4'/><label
                                    class='hiddens' for="chechboxs6"></label><span
                                    class='show_title'>9.9包邮</span>
                            </li>
                            <li><input type="radio" name="isTwenty" value="1" id='chechboxs7'
                                       class='inputs team4'/><label
                                    class='hiddens' for="chechboxs7"></label><span
                                    class='show_title'>20元封顶</span>
                                <p class='today_new_pro3'></p>
                            </li>
                            <li><input type="radio" name="isJyj" value="1" id='chechboxs8'
                                       class='inputs team5'/><label
                                    class='hiddens' for="chechboxs8"></label><span class='show_title'>极有家</span>
                            </li>
                            <li><input type="radio" name="isHaitao" value="1" id='chechboxs9'
                                       class='inputs team5'/><label

                                    class='hiddens' for="chechboxs9"></label><span class='show_title'>海淘</span>
                                     <p class='today_new_pro4'></p>
                            </li>
                            <li class="margin0"><input type="checkbox" name="isYfx" value="1" id='chechboxs10'
                                                       class='inputs'/><label class='hiddens'
                                                                              for="chechboxs10"></label><span
                                    class='show_title'>运费险</span></li>
                        </ul>
                        <div class="section in_clock_box">
                            <p class="section_title">
                                <span class='title_in'>券区间</span>

                                <input type="text" name="minCouponPrice" placeholder="¥"  value="{{$screenStrArr['minCouponPrice']==0?'':$screenStrArr['minCouponPrice']}}" class='in_clock'>
                                <input type="text" name="maxCouponPrice" placeholder="¥"
                                        value="{{$screenStrArr['maxCouponPrice']==0?'':$screenStrArr['maxCouponPrice']}}" class='in_clock0'>
                                        <span class='width1'>一</span>

                            </p>

                            <p class="section_title1 section_title">
                                <span class='title1_in'>价格</span>
                                <input type="text" name="minPrice" placeholder="¥"
                                       value="{{$screenStrArr['minPrice']==0?'':$screenStrArr['minPrice']}}" class='in_clock1'>
                                <input type="text" name="maxPrice" placeholder="¥"
                                        value="{{$screenStrArr['maxPrice']==0?'':$screenStrArr['maxPrice']}}"  class='in_clock2'>
                                           <span class='width2'>一</span>
                            </p>

                            <p class="section_title2 section_title">
                                <span class='title2_in'>佣金比例></span>
                                <input type="text" name="minCommission" placeholder="¥"
                                       value="{{$screenStrArr['minCommission']==0?'':$screenStrArr['minCommission']}}" class='in_clock3'>
                            </p>

                            <p class="section_title3 section_title">
                                <span class='title3_in'>销量></span>
                                <input type="text" name="minSellNum" placeholder="¥"
                                       value="{{$screenStrArr['minSellNum']==0?'':$screenStrArr['minSellNum']}}" class='in_clock4'>
                            </p>

                            <p class="section_title4 section_title">
                                <button type="button " class='screen-btn' >筛选</button>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="clear"></div>
            @if(!empty($list))
            <!--商品列表-->

            <div class="pro_list  goods-list">
                <div class="tab_nav">
                    <a href="{{url('/columns/'.$active['active_column_code'].'/goods')}}" class="click_open">
                        <span class=" @if($active['active_sort']=='') tab_nav_active @endif">综合</span>
                    </a>
                    <a href="{{url('/columns/'.$active['active_column_code'].'/goods').'?sort=2'}}"
                       class="click_open">
                        <span class=" @if($active['active_sort']==2) tab_nav_active @endif">最新</span>
                    </a>
                    <a href="{{url('/columns/'.$active['active_column_code'].'/goods').'?sort=3'}}"
                       class="click_open">
                        <span class=" @if($active['active_sort']==3) tab_nav_active @endif">销量</span>
                    </a>
                    <a href="{{url('/columns/'.$active['active_column_code'].'/goods').'?sort=1'}}"
                       class="click_open">
                        <span class=" @if($active['active_sort']==1) tab_nav_active @endif">人气</span>
                    </a>
                    <a href="{{url('/columns/'.$active['active_column_code'].'/goods').'?sort=-4'}}"
                       class="click_open">
                        <span class=" @if($active['active_sort']==-4) tab_nav_active @endif">价格</span>
                    </a>
                </div>
                @foreach($list as $k => $v)
                <div class="single">
                    <a href="{{url('/goods/'. $v['id']).'?columnCode='.$active['active_column_code']}}"
                       target="_blank" class="click_open">

                        <img src='/web/images/mrtp.jpg' data-img="{{ $v['pic'] }}.jpg" class="img_size lazy">



                    <div class="price_introduce">
                        <p class="title">

                                {{$v['short_title']}}

                        </p>

                        <p class="discount"><span class="coupun">券</span><span class='prc_pyt'>{{ $v['coupon_price']}}元</span></p>

                        <p class="mouth_num">月销：<span>{{ $v['sell_num'] }}</span></p>

                        <p class="coupon_back">
                            <span class="small_word small_color">券后</span><span
                                class="small_word">￥</span><span>{{ $v['price'] }}</span>
                        </p>
                        <p class="commission">
                            <span class="small_word small_color">佣金</span><span
                                class="small_word">￥</span><span>{{ $v['commission_finally'] }}</span>
                        </p>
                        <!--商品所属图标-->
                        <p class="log_pro">
                            @if ($v['is_tmall'] !== 0)
                            <img src="/web/images/tmail.png" alt="天猫"/>
                            @else
                            <img src="/web/images/taobao.png" alt="淘宝"/>
                            @endif
                        </p>
                    </div>
                       </a>
                </div>
                @endforeach
            </div>
            @else
            <div class="kong"><img src="/web/images/kong.png"></div>
            @endif


        </div>
    </seation>
    <div class="clear"></div>
    <!--页脚-->
    @include('web.layouts.footer')
</div>
@stop
@section('js')
<script src="/js/imgLazy.js"></script>
<script src="/web/js/pushList.js"></script>
    @foreach($inputCheckbox as $key=>$val)


        $("#{{$key}}").attr('checked', checked);


    @endforeach
<script>
    var getListUrl = "{{ \Illuminate\Support\Facades\Request::getRequestUri()}}";
    var goods_url_head = "{{url('/goods/')}}";
    var goods_url_ext = "{{'?columnCode='.$active['active_column_code']}}";

</script>
@stop
