<?php
/**
 * Created by PhpStorm.
 * User: yangtao
 * Date: 2017/10/18
 * Time: 15:51
 */
namespace App\Services;

use App\Helpers\CacheHelper;
use App\Helpers\EsHelper;
use App\Helpers\ProxyClient;
use App\Helpers\QueryHelper;
use App\Helpers\UrlHelper;
use App\Helpers\UtilsHelper;
use App\Models\ColumnGoodsRel;
use App\Models\Goods;
use App\Models\TaobaoToken;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GoodsService
{
    /**
     * 人气排序
     */
    CONST SORT_RENQI = 1;

    /**
     * 最新排序
     */
    CONST SORT_NEW = 2;

    /**
     * 销量排序：高到低
     */
    CONST SORT_SELL_NUM = 3;

    /**
     * 销量排序：低到高
     */
    CONST SORT_SELL_NUM_ASC = -3;

    /**
     * 价格排序：高到低
     */
    CONST SORT_PRICE = 4;

    /**
     * 价格排序：低到高
     */
    CONST SORT_PRICE_ASC = -4;

    /**
     * 优惠券金额排序: 高到低
     */
    CONST SORT_COUPON_PRICE = 5;

    /**
     * 优惠券金额排序：低到高
     */
    CONST SORT_COUPON_PRICE_ASC = -5;

    /**
     * 获取商品列表
     * @param $category 分类
     * @param $sort 排序
     * @param $keyword 关键字
     * @param int $isTaoqianggou 是否淘抢购
     * @param int $isJuhuashuan 是否聚划算
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function goodList($category, $sort, $keyword, $isTaoqianggou, $isJuhuashuan, $minPrice, $maxPrice, $isTmall, $minCommission, $minSellNum, $minCouponPrice, $maxCouponPrice, $isJpseller, $isQjd, $isHaitao, $isJyj, $isYfx, $userId){
        $sortVal = $this->sort($sort);
        $request = app('request');
        //分页参数
        $page = $request->input("page");
        $page = $page ?: 1;
        $limit = $request->input("limit");
        $limit = $limit ?: 20;

        if($page == 1){
            $filters = [];
            $filters[] = ['term'=>['is_del' => 0]];
            $filters[] = [
                'bool' => [
                    'should' => [
                        ['range'=>['starttime' => ['gte'=>(new Carbon())->toDateTimeString()]]],
                        [
                            'bool' => [
                                'must_not' => [
                                    ['exists'=>['field' => "starttime"]],
                                ]
                            ]
                        ]
                    ]
                ]
            ];

            if($category){
                $filters[] = ['term'=>['catagory_id' => $category]];
            }
            if($isTaoqianggou){
                $filters[] = ['term'=>['is_taoqianggou' => 1]];
            }
            if($isJuhuashuan){
                $filters[] = ['term'=>['is_juhuashuan' => 1]];
            }
            if($minPrice || $maxPrice){
                $priceData = [];
                if($minPrice){
                    $priceData['gte'] = $minPrice;
                }
                if($maxPrice){
                    $priceData['lte'] = $maxPrice;
                }
                $filters[] = ['range'=>['price' => $priceData]];
            }

            if($isTmall){
                $filters[] = ['term'=>['is_tmall' => 1]];
            }
            if($minCommission){
                $filters[] = ['range'=>['commission' => ['gte'=>$minCommission]]];
            }else{
                $filters[] = ['range'=>['commission' => ['gt'=>0]]];
            }

            if($minSellNum){
                $filters[] = ['range'=>['sell_num' => ['gte'=>$minSellNum]]];
            }


            if($minCouponPrice || $maxCouponPrice){
                $couponPriceData = [];
                if($minCouponPrice){
                    $couponPriceData['gte'] = $minCouponPrice;
                }
                if($maxCouponPrice){
                    $couponPriceData['lte'] = $maxCouponPrice;
                }
                $filters[] = ['range'=>['coupon_price' => $couponPriceData]];
            }

            //金牌卖家
            if($isJpseller){
                $filters[] = ['term'=>['is_jpseller' => 2]];
            }
            //旗舰店
            if($isQjd){
                $filters[] = ['term'=>['is_qjd' => 2]];
            }
            //海淘
            if($isHaitao){
                $filters[] = [
                    'bool' => [
                        'should' => [
                            ['term'=>['is_haitao' => 2]],
                            ['term'=>['is_tmallgj' => 2]],
                        ]
                    ]
                ];
            }
            //极有家
            if($isJyj){
                $filters[] = ['term'=>['is_jyjseller' => 2]];
            }
            if($isYfx){
                $filters[] = ['term'=>['is_freight_insurance' => 2]];
            }

            $esParams = [
                'scroll' => '15m',
                'index' => 'pyt',
                'type' => 'good',
                'body' => [
                    'size' => $limit,
                    'query' =>[
                        'bool' => [
                            'filter'=>$filters,
                        ],
                    ]
                ]
            ];

            //搜索关键词
            if($keyword){
                $esParams['body']['query']['bool']['must'] = [
                    'match' => [
                        'title' => [
                            'query' => $keyword,
                            'operator' => 'and'
                        ]
                    ],
                ];
            }

            //排序
            if($sortVal){
                $esParams['body']['sort'][] = [$sortVal[0] => ['order'=> $sortVal[1]]];
            }

            $esHelper = new EsHelper();
            $results = $esHelper->search($esParams);
            CacheHelper::setCache($esHelper->getScrollId(), 15);
            return $results;
        }else{
            $results = [];
            try{
                $scrollId = CacheHelper::getCache();
                if($scrollId){
                    $results = (new EsHelper())->scroll([
                        'scroll_id' => $scrollId,
                        'scroll' => "15m"
                    ]);
                    CacheHelper::setCache($scrollId, 15);
                }
                return $results;
            }catch (\Exception $e){
            }

            return $results;
        }

    }

    /**
     * 商品推荐列表
     * @param $keyword 搜索关键词
     * @param null $excludeTaobaoId 排除的淘宝商品id
     * @return array
     */
    public function recommendGoods($keyword, $excludeTaobaoId=null){
        if($cache = CacheHelper::getCache()){
            return $cache;
        }

        $filters = [];
        $filters[] = ['term'=>['is_del' => 0]];
        $size = $excludeTaobaoId ? 11 : 10;

        $esParams = [
            'index' => 'pyt',
            'type' => 'good',
            'body' => [
                'size' => $size,
                'query' =>[
                    'bool' => [
                        'filter'=>$filters,
                        'must' => [
                            'match' => [
                                'title' => [
                                    'query' => $keyword,
                                    'operator' => 'or'
                                ]
                            ],
                        ],
                    ],
                ]
            ]
        ];

        $esHelper = new EsHelper();
        $results = $esHelper->search($esParams);
        if(!$results){
            return null;
        }
        if($excludeTaobaoId){
            foreach ($results as $key => $result){
                if($result['goodsid'] == $excludeTaobaoId){
                    unset($results[$key]);
                }
            }
            $results = array_values($results);
        }
        $results = UtilsHelper::arraySort($results, 'commission', SORT_DESC);

        CacheHelper::setCache($results, 5);
        return $results;
    }

    /**
     * 获取栏目商品列表
     */
    public function columnGoodList($columnCode, $category, $sort, $isTaoqianggou, $isJuhuashuan, $minPrice, $maxPrice, $isTmall, $minCommission, $minSellNum, $minCouponPrice, $maxCouponPrice){
        $query = Goods::query()->from((new Goods())->getTable().' as goods');
        $query->leftJoin((new ColumnGoodsRel())->getTable().' as ref', 'goods.id', '=', 'ref.goods_id');
        $query->where('ref.column_code', $columnCode);

        $query->select('goods.*', 'ref.goods_col_title', 'ref.goods_col_pic', 'ref.goods_col_des');
        $query->where("goods.is_del", 0);

        $query->where(function($query){
            $query->where("goods.starttime", '>=', (new Carbon())->toDateTimeString());
            $query->orWhere("goods.starttime", null);
        });

        if($category){
            $query->where("goods.catagory_id", $category);
        }
        if($isTaoqianggou){
            $query->where("goods.is_taoqianggou", 1);
        }
        if($isJuhuashuan){
            $query->where("goods.is_juhuashuan", 1);
        }
        if($minPrice){
            $query->where("goods.price", '>=', $minPrice);
        }
        if($maxPrice){
            $query->where("goods.price", '<=', $maxPrice);
        }
        if($isTmall){
            $query->where("goods.is_tmall", 1);
        }
        if($minCommission){
            $query->where("goods.commission", '>=', $minCommission);
        }else{
            $query->where("goods.commission", '>', 0);
        }
        if($minSellNum){
            $query->where("goods.sell_num", '>=', $minSellNum);
        }
        if($minCouponPrice){
            $query->where("goods.coupon_price", '>=', $minCouponPrice);
        }
        if($maxCouponPrice){
            $query->where("goods.coupon_price", '<=', $maxCouponPrice);
        }

        $sortVal = $this->sort($sort);
        if($sortVal){
            $query->orderBy("goods.".$sortVal[0], $sortVal[1]);
        }else{
            $query->orderBy('ref.is_top', 'desc');
            $query->orderBy('ref.id', 'desc');
        }

        $list = (new QueryHelper())->pagination($query)->get();
        return $list;
    }


    /**
     * 商品详情
     * @param $goodId
     * @return mixed
     */
    public function detail($goodId){
        if($cache = CacheHelper::getCache()){
            return $cache;
        }

        $data = Goods::whereId($goodId)->first();
        if(!$data){
            return null;
        }
        $data = $data->toArray();
        if($data['seller_name'] == '天猫超市'){
            $data['coupon_num'] = null;
            $data['coupon_over'] = null;
            $data['coupon_link'] = null;
            $data['coupon_price'] = 0;
            $data['coupon_prerequisite'] = 0;
            $data['coupon_id'] = null;
            $data['coupon_m_link'] = null;
            $data['coupon_time'] = null;
        }

        $shareData = [
            'title' => $data['title'],
            'price' => $data['price_full'],
            'used_price' => $data['price'],
            'coupon_price' => $data['coupon_price'],
            'description' => $data['des'],
            'sell_num' => $data['sell_num']
        ];
        //分享描述
        $data['share_desc'] = $this->getShareDesc($shareData);

        //秒杀信息查询
        $data['is_miaosha'] = 0;
        $data['active_time'] = null;
        //查询秒杀时间
        $miaoshaTime = ColumnGoodsRel::where([
            ["column_code", "zhengdianmiaosha"],
            ["goods_id", "=", $data['id']],
            ["active_time", ">=", (new Carbon())->startOfDay()->toDateTimeString()],
        ])->select("active_time")->orderby("active_time", "desc")->pluck("active_time")->first();
        if($miaoshaTime){
            $data['active_time'] = $miaoshaTime;
            $data['is_miaosha'] = 1;
        }

        CacheHelper::setCache($data, 2);
        return $data;
    }


    /**
     * 商品详情
     * @param $goodId
     * @return \Illuminate\Cache\CacheManager|mixed|null
     */
    public function getByGoodsId($goodId){
        if($cache = CacheHelper::getCache()){
            return $cache;
        }

        $data = Goods::where("goodsid", $goodId)->first();
        if(!$data){
            return null;
        }
        $data = $data->toArray();
        CacheHelper::setCache($data, 2);
        return $data;
    }


    /**
     * 商品分享描述
     * @param $shareData
     * @return mixed|null
     * @throws \Exception
     */
    public function getShareDesc($shareData){
        $shareDesc = (new SysConfigService())->get("share_desc");
        if(!$shareDesc){
            return null;
        }

        /**
         * 模板内需要替换的变量
         */
        $templateData = [];
        //标题
        $templateData['title'] = isset($shareData['title']) ? $shareData['title'] : '';
        //原价
        $templateData['price'] = isset($shareData['price']) ? floatval($shareData['price']) : 0;
        //券后价
        $templateData['used_price'] = isset($shareData['used_price']) ? floatval($shareData['used_price']) : 0;
        //优惠券金额
        $templateData['coupon_price'] = isset($shareData['coupon_price']) ? floatval($shareData['coupon_price']) : 0;

        $taoCode = null;
        if(isset($shareData['tao_code'])){
            preg_match('/([0-9A-Za-z]+)/', $shareData['tao_code'], $matchs);
            $taoCode = $matchs[1];
        }
        //淘口令
        $templateData['tao_code'] = $taoCode ? $taoCode : '(复制后生成)';
        //微信单页地址
        $templateData['wechat_url'] = isset($shareData['wechat_url']) ? $shareData['wechat_url'] : '(复制后生成)';
        //详情
        $templateData['description'] = isset($shareData['description']) ? $shareData['description'] : '优惠券数量有限，赶快来抢购吧！';
        //销量
        $templateData['sell_num'] = isset($shareData['sell_num']) ? $shareData['sell_num'] : 0;

        //朋友淘分享地址
        if(strpos($shareDesc, "{pytao_url}") !== false){
            $templateData['pytao_url'] = "";

            $user = app("request")->user();
            if($user){
                // 获取当前用户邀请码.
                $code = $user->invite_code;
                $cacheKey = "pytao_url_".$code;
                if(!$shortUrl = CacheHelper::getCache($cacheKey)){
                    // 拼接邀请链接.
                    $longUrl = 'http://'.config('domains.pytao_domains').'/pytao/share/'.$code;
                    // 短链接.
                    $shortUrl = (new UrlHelper())->shortUrl($longUrl);
                    CacheHelper::setCache($shortUrl, 5, $cacheKey);
                }
                $templateData['pytao_url'] = $shortUrl;
            }
        }

        foreach ($templateData as $name=>$value){
            $shareDesc = str_replace('{'.$name.'}', $value, $shareDesc);
        }
        return $shareDesc;
    }

    /**
     * 排序
     * @param $query
     * @param $sort
     */
    private function sort($sort){
        switch ($sort){
            case self::SORT_RENQI:{
                break;
            }
            case self::SORT_NEW:{
                return ['create_time', 'desc'];
                break;
            }
            case self::SORT_SELL_NUM:{
                return ['sell_num', 'desc'];
                break;
            }
            case self::SORT_SELL_NUM_ASC:{
                return ['sell_num', 'asc'];
                break;
            }
            case self::SORT_PRICE:{
                return ['price', 'desc'];
                break;
            }
            case self::SORT_PRICE_ASC:{
                return ['price', 'asc'];
                break;
            }
            case self::SORT_COUPON_PRICE:{
                return ['coupon_price', 'desc'];
                break;
            }
            case self::SORT_COUPON_PRICE_ASC:{
                return ['coupon_price', 'asc'];
                break;
            }
        }
        return null;
    }

    /**
     * 全网搜索
     * @param $keyword
     */
    public function queryAllGoods($keyword, $hasShopCoupon, $isHighPayRate, $isTmall, $minSellNum, $minCommission, $maxCommission, $minPrice, $maxPrice, $page, $limit, $sort){
        $keyword = urlencode($keyword);
        $url = "http://pub.alimama.com/items/search.json?q={$keyword}&toPage={$page}&perPageSize={$limit}&auctionTag=&t=".time();
        switch ($sort){
            case self::SORT_RENQI:{
                $url .= "&queryType=2";
                break;
            }
            case self::SORT_SELL_NUM:{
                $url .= "&sortType=9";
                break;
            }
            case self::SORT_PRICE:{
                $url .= "&sortType=3";
                break;
            }
            case self::SORT_PRICE_ASC:{
                $url .= "&sortType=4";
                break;
            }
        }
        $shopTag = [];
        //店铺优惠券筛选
        if($hasShopCoupon){
            $shopTag[] = 'dpyhq';
            $url .= "&dpyhq=1";
        }
        //月成交转化率高于行业均值
        if($isHighPayRate){
            $url .= "&hPayRate30=1";
        }
        //天猫
        if($isTmall){
            $shopTag[] = 'b2c';
            $url .= "&b2c=1";
        }
        //最低销量筛选
        if($minSellNum){
            $url .= "&startBiz30day=".$minSellNum;
        }
        //最低佣金筛选
        if($minCommission){
            $url .= "&startTkRate=".$minCommission;
        }
        //最高佣金筛选
        if($maxCommission){
            $url .= "&endTkRate=".$maxCommission;
        }
        //最低价格筛选
        if($minPrice){
            $url .= "&startPrice=".$minPrice;
        }
        //最高价格筛选
        if($maxPrice){
            $url .= "&endPrice=".$maxPrice;
        }

        $url.= "&shopTag=".implode(',', $shopTag);

        $response = (new ProxyClient())->get($url)->getBody()->getContents();
        $response = json_decode($response, true);
        if(!isset($response['data']) || !isset($response['data']['pageList']) || !isset($response['data']['pageList'][0])) {
            return null;
        }

        $allGoods = $response['data']['pageList'];
        $result = [];
        foreach ($allGoods as $goods){
            $title = strip_tags($goods['title']);
            $commission = 0;
            if($goods['tkSpecialCampaignIdRateMap']){
                $commission = max(array_values($goods['tkSpecialCampaignIdRateMap']));
            }
            $commission = max($commission, $goods['eventRate'], $goods['tkRate']);

            $data = [
                'goodsid' => $goods['auctionId'],
                'goods_url' => $goods['auctionUrl'],
                'short_title' => $title,
                'title' => $title,
                'sell_num' => $goods['biz30day'],
                'pic' => "http:".$goods['pictUrl'],
                'price' => bcsub($goods['zkPrice'], $goods['couponAmount'], 2),
                'price_full' => $goods['zkPrice'],
                'coupon_time' => $goods['couponEffectiveEndTime']." 23:59:59",
                'coupon_price' => $goods['couponAmount'],
                'coupon_prerequisite' => $goods['couponStartFee'],
                'coupon_num' => $goods['couponTotalCount'],
                'coupon_over' => $goods['couponLeftCount'],
                'seller_name' => $goods['shopTitle'],
                'seller_icon_url' => '',
                'is_tmall' => $goods['userType'] == 1 ? 1 : 0,
                'coupon_id' => $goods['couponAmount'] ? 1 : '',
                'coupon_m_link'=> '',
                'coupon_link'=> '',
                'catagory_id' => 0,
                'dsr' => 0,
                'seller_id' => $goods['sellerId'],
                'is_juhuashuan' => 0,
                'is_taoqianggou' => 0,
                'is_delivery_fee' => 0,
                'des' => '',
                'plan_link' => null,
                'plan_apply' => null,
                'commission_type' => 0,
                'commission' => $commission,
                'commission_marketing' => 0,
                'commission_plan' => 0,
                'commission_bridge' => 0,
            ];
            $shareData = [
                'title' => $data['title'],
                'price' => $data['price_full'],
                'used_price' => $data['price'],
                'coupon_price' => $data['coupon_price'],
                'description' => $data['des'],
                'sell_num' => $data['sell_num']
            ];
            //分享描述
            $data['share_desc'] = (new GoodsService())->getShareDesc($shareData);

            $result[] = $data;
        }

        return $result;
    }

    /**
     * 查询商品佣金
     * @param $goodsId
     */
    public function commission($goodsId){
        if($cache = CacheHelper::getCache($goodsId)){
            return $cache;
        }

        $user = Auth::guard('api')->user();
        if($user){
            $userId = $user->id;
        }else{
            //随机获取一个未过期的用户
            $userId = TaobaoToken::where([
                ['expires_at', '>', Carbon::now()->addMinute(mt_rand(5, 100))]
            ])->limit(1)->pluck("user_id")->first();
        }

        $commission = Goods::where([
            ['goodsid', '=', $goodsId],
            ['commission_update_time', '>=', Carbon::now()->subMinute(30)],
        ])->pluck("commission")->first();

        try{
            if(!$commission){
                $data = (new TransferService())->transferLinkByUser($goodsId, $userId);
                $commission = $data['max_commission_rate'];
            }
        }catch (\Exception $e){
            return false;
        }

        $realCommission = $commission;

        $detail = (new AlimamaGoodsService())->detail($goodsId);
        //如果当前佣金等于高佣，则实际佣金为95%
        if($detail && $detail['eventRate'] == $commission){
            $realCommission = bcmul($commission, 0.95, 2);
        }

        $result = [
            //实际佣金
            'commission' => $realCommission,
            //原始佣金
            'originCommission' => $commission
        ];

        CacheHelper::setCache($result, 5, $goodsId);
        return $result;
    }

}