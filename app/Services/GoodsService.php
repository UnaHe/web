<?php
/**
 * Created by PhpStorm.
 * User: yangtao
 * Date: 2017/10/18
 * Time: 15:51
 */
namespace App\Services;

use App\Helpers\QueryHelper;
use App\Models\ColumnGoodsRel;
use App\Models\Goods;

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
    public function goodList($category, $sort, $keyword, $isTaoqianggou=0, $isJuhuashuan=0){
        $query = Goods::query();
        if($category){
            $query->where("catagory_id", $category);
        }
        if($keyword){
            $query->where("title",'like', "%".$keyword."%");
        }
        if($isTaoqianggou){
            $query->where("is_taoqianggou", 1);
        }
        if($isJuhuashuan){
            $query->where("is_juhuashuan", 1);
        }

        $this->sort($query, $sort);
        $list = (new QueryHelper())->pagination($query)->get();
        return $list;
    }

    /**
     * 获取栏目商品列表
     */
    public function columnGoodList($columnCode){
        $query = Goods::query()->from((new Goods())->getTable().' as goods');
        $query->leftJoin((new ColumnGoodsRel())->getTable().' as ref', 'goods.id', '=', 'ref.goods_id');
        $query->where('ref.column_code', $columnCode);

        $query->select('goods.*', 'ref.goods_col_title', 'ref.goods_col_pic', 'ref.goods_col_des');

        $list = (new QueryHelper())->pagination($query)->get();
        return $list;
    }


    /**
     * 商品详情
     * @param $goodId
     * @return mixed
     */
    public function detail($goodId){
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
            'description' => $data['des']
        ];
        //分享描述
        $data['share_desc'] = $this->getShareDesc($shareData);
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
        $templateData['price'] = isset($shareData['price']) ? $shareData['price'] : 0;
        //券后价
        $templateData['used_price'] = isset($shareData['used_price']) ? $shareData['used_price'] : 0;
        //优惠券金额
        $templateData['coupon_price'] = isset($shareData['coupon_price']) ? $shareData['coupon_price'] : 0;
        //淘口令
        $templateData['tao_code'] = isset($shareData['tao_code']) ? $shareData['tao_code'] : '(复制后生成)';
        //微信单页地址
        $templateData['wechat_url'] = isset($shareData['wechat_url']) ? $shareData['wechat_url'] : '(复制后生成)';
        //详情
        $templateData['description'] = isset($shareData['description']) ? $shareData['description'] : '';

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
    private function sort($query, $sort){
        switch ($sort){
            case self::SORT_RENQI:{
                break;
            }
            case self::SORT_NEW:{
                $query->orderBy('create_time', 'desc');
                break;
            }
            case self::SORT_SELL_NUM:{
                $query->orderBy('sell_num', 'desc');
                break;
            }
            case self::SORT_PRICE:{
                $query->orderBy('price', 'desc');
                break;
            }
            case self::SORT_COUPON_PRICE:{
                $query->orderBy('coupon_price', 'desc');
                break;
            }
        }
    }

}