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
use App\Models\ColumnGoodsRel;
use App\Models\Goods;
use GuzzleHttp\Client;

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
    public function goodList($category, $sort, $keyword, $isTaoqianggou, $isJuhuashuan, $minPrice, $maxPrice, $isTmall, $minCommission, $minSellNum, $minCouponPrice, $maxCouponPrice){
        $sortVal = $this->sort($sort);
        $request = app('request');
        //分页参数
        $page = $request->input("page");
        $page = $page ?: 1;
        $limit = $request->input("limit");
        $limit = $limit ?: 20;
        $start = ($page - 1)*$limit;

        $filters = [];
        $filters[] = ['term'=>['is_del' => 0]];
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

        $esParams = [
            'index' => 'pyt',
            'type' => 'good',
            'body' => [
                'from' => $start,
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

        return (new EsHelper())->search($esParams);
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
        //淘口令
        $templateData['tao_code'] = isset($shareData['tao_code']) ? $shareData['tao_code'] : '(复制后生成)';
        //微信单页地址
        $templateData['wechat_url'] = isset($shareData['wechat_url']) ? $shareData['wechat_url'] : '(复制后生成)';
        //详情
        $templateData['description'] = isset($shareData['description']) ? $shareData['description'] : '优惠券数量有限，赶快来抢购吧！';
        //销量
        $templateData['sell_num'] = isset($shareData['sell_num']) ? $shareData['sell_num'] : 0;

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
    public function queryAllGoods($keyword, $page, $limit, $sort){
        $keyword = urlencode($keyword);
        $url = "http://pub.alimama.com/items/search.json?q={$keyword}&toPage={$page}&perPageSize={$limit}&auctionTag=&shopTag=&t=".time();
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
                'coupon_id' => $goods['couponActivityId'],
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

}