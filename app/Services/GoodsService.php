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
     * 销量排序
     */
    CONST SORT_SELL_NUM = 3;
    /**
     * 价格排序
     */
    CONST SORT_PRICE = 4;
    /**
     * 优惠券金额排序
     */
    CONST SORT_COUPON_PRICE = 5;


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

        if($keyword){
            $request = app('request');
            //分页参数
            $page = $request->input("page");
            $limit = $request->input("limit", 20);
            $start = ($page - 1)*$limit;

            $esParams = [
                'index' => 'pyt',
                'type' => 'good',
                'body' => [
                    'from' => $start,
                    'size' => $limit,
                    'query' =>[
                        'bool' => [
                            'must' =>[
                                'match' => [
                                    'title' => $keyword
                                ],
                            ],
                            'filter'=>[],
                        ],
                    ]
                ]
            ];

            if($category){
                $esParams['body']['query']['bool']['filter'][] = ['term'=>['catagory_id' => $category]];
            }
            if($isTaoqianggou){
                $esParams['body']['query']['bool']['filter'][] = ['term'=>['is_taoqianggou' => 1]];
            }
            if($isJuhuashuan){
                $esParams['body']['query']['bool']['filter'][] = ['term'=>['is_juhuashuan' => 1]];
            }
            if($minPrice || $maxPrice){
                $priceData = [];
                if($minPrice){
                    $priceData['gte'] = $minPrice;
                }
                if($maxPrice){
                    $priceData['lte'] = $maxPrice;
                }
                $esParams['body']['query']['bool']['filter'][] = ['range'=>['price' => $priceData]];
            }

            if($isTmall){
                $esParams['body']['query']['bool']['filter'][] = ['term'=>['is_tmall' => 1]];
            }
            if($minCommission){
                $esParams['body']['query']['bool']['filter'][] = ['range'=>['commission' => ['gte'=>$minCommission]]];
            }
            if($minSellNum){
                $esParams['body']['query']['bool']['filter'][] = ['range'=>['sell_num' => ['gte'=>$minSellNum]]];
            }

            if($minCouponPrice || $maxCouponPrice){
                $couponPriceData = [];
                if($minCouponPrice){
                    $couponPriceData['gte'] = $minCouponPrice;
                }
                if($maxCouponPrice){
                    $couponPriceData['lte'] = $maxCouponPrice;
                }
                $esParams['body']['query']['bool']['filter'][] = ['range'=>['coupon_price' => $couponPriceData]];
            }

            if($sortVal){
                $esParams['body']['sort'][] = [$sortVal[0] => ['order'=> $sortVal[1]]];
            }


            return (new EsHelper())->search($esParams);
        }

        $query = Goods::query();
        if($category){
            $query->where("catagory_id", $category);
        }
        if($isTaoqianggou){
            $query->where("is_taoqianggou", 1);
        }
        if($isJuhuashuan){
            $query->where("is_juhuashuan", 1);
        }
        if($minPrice){
            $query->where("price", '>=', $minPrice);
        }
        if($maxPrice){
            $query->where("price", '<=', $maxPrice);
        }
        if($isTmall){
            $query->where("is_tmall", 1);
        }
        if($minCommission){
            $query->where("commission", '>=', $minCommission);
        }
        if($minSellNum){
            $query->where("sell_num", '>=', $minSellNum);
        }
        if($minCouponPrice){
            $query->where("coupon_price", '>=', $minCouponPrice);
        }
        if($maxCouponPrice){
            $query->where("coupon_price", '<=', $maxCouponPrice);
        }

        if($sortVal){
            $query->orderBy($sortVal[0], $sortVal[1]);
        }
        $list = (new QueryHelper())->pagination($query)->get();
        return $list->toArray();
    }

    /**
     * 获取栏目商品列表
     */
    public function columnGoodList($columnCode){
        $query = Goods::query()->from((new Goods())->getTable().' as goods');
        $query->leftJoin((new ColumnGoodsRel())->getTable().' as ref', 'goods.id', '=', 'ref.goods_id');
        $query->where('ref.column_code', $columnCode);

        $query->select('goods.*', 'ref.goods_col_title', 'ref.goods_col_pic', 'ref.goods_col_des');
        $query->orderBy('ref.id', 'desc');

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
            case self::SORT_PRICE:{
                return ['price', 'desc'];
                break;
            }
            case self::SORT_COUPON_PRICE:{
                return ['coupon_price', 'desc'];
                break;
            }
        }
        return null;
    }

    /**
     * 全网搜索
     * @param $keyword
     */
    public function queryAllGoods($keyword, $page, $limit){
        $url = "http://pub.alimama.com/items/search.json?q={$keyword}&toPage={$page}&perPageSize={$limit}&freeShipment=&dpyhq=&auctionTag=&shopTag=&t=".time();
        $response = (new ProxyClient())->get($url)->getBody()->getContents();
        $response = json_decode($response, true);
        if(!isset($response['data']) || !isset($response['data']['pageList']) || !isset($response['data']['pageList'][0])) {
            return null;
        }

        $allGoods = $response['data']['pageList'];
        $result = [];
        foreach ($allGoods as $goods){
            $title = strip_tags($goods['title']);
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
                'commission' => $goods['tkRate'],
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