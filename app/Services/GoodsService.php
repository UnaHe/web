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
     */
    public function goodList($category, $sort){
        $query = Goods::query();
        if($category){
            $query->where("catagory_id", $category);
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
        return $data;
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