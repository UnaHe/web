<?php

namespace App\Http\Controllers;

use App\Helpers\CacheHelper;
use App\Helpers\GoodsHelper;
use App\Services\ChannelColumnService;
use App\Services\GoodsService;
use Illuminate\Http\Request;


/**
 * 商品列表
 * Class GoodsController
 * @package App\Http\Controllers
 */
class GoodsController extends Controller
{
    /**
     * 获取商品列表
     */
    public function goodList(Request $request){
        //商品分类
        $category = $request->get('category');
        //商品排序
        $sort = $request->get('sort');
        //搜索关键字
        $keyword = $request->get('keyword');
        //淘抢购筛选
        $isTaoqianggou = $request->get('tqg');
        //聚划算筛选
        $isJuhuashuan = $request->get('jhs');
        //最低价格筛选
        $minPrice = $request->get('min_price');
        //最高价格筛选
        $maxPrice = $request->get('max_price');
        //天猫筛选
        $isTmall = $request->get('is_tmall', 0);
        //最低佣金筛选
        $minCommission = $request->get('min_commission', 0);
        //最低销量筛选
        $minSellNum = $request->get('min_sell_num', 0);
        //最低券金额筛选
        $minCouponPrice = $request->get('min_coupon_price');
        //最高券金额筛选
        $maxCouponPrice = $request->get('max_coupon_price');

        $params = $request->all();
        if(!$list = CacheHelper::getCache($params)){
            $list = (new GoodsService())->goodList($category, $sort, $keyword, $isTaoqianggou, $isJuhuashuan, $minPrice, $maxPrice, $isTmall, $minCommission, $minSellNum, $minCouponPrice, $maxCouponPrice);
            if($list){
                $list = (new GoodsHelper())->resizeGoodsListPic($list, ['pic'=>'310x310']);
            }
            CacheHelper::setCache($list, 1, $params);
        }
        return $this->ajaxSuccess($list);
    }

    /**
     * 商品详情
     * @param $goodId
     * @return static
     */
    public function detail($goodId){
        $data = (new GoodsService())->detail($goodId);
        if(!$data){
            return $this->ajaxError("商品不存在", 404);
        }
        $data = (new GoodsHelper())->resizeGoodsListPic([$data], ['pic'=>'480x480']);
        return $this->ajaxSuccess($data[0]);
    }

    /**
     * 获取栏目商品列表
     * @param $columnCode 栏目代码
     * @return static
     */
    public function columnGoods(Request $request, $columnCode){
        //商品分类
        $category = $request->get('category');
        //商品排序
        $sort = $request->get('sort');
        //淘抢购筛选
        $isTaoqianggou = $request->get('tqg');
        //聚划算筛选
        $isJuhuashuan = $request->get('jhs');
        //最低价格筛选
        $minPrice = $request->get('min_price');
        //最高价格筛选
        $maxPrice = $request->get('max_price');
        //天猫筛选
        $isTmall = $request->get('is_tmall', 0);
        //最低佣金筛选
        $minCommission = $request->get('min_commission', 0);
        //最低销量筛选
        $minSellNum = $request->get('min_sell_num', 0);
        //最低券金额筛选
        $minCouponPrice = $request->get('min_coupon_price');
        //最高券金额筛选
        $maxCouponPrice = $request->get('max_coupon_price');

        if(!(new ChannelColumnService())->getByCode($columnCode)){
            return $this->ajaxError("栏目不存在");
        }

        $params = $request->all();
        $params['column_code'] = $columnCode;
        if(!$list = CacheHelper::getCache($params)){
            $list = (new GoodsService())->columnGoodList($columnCode, $category, $sort, $isTaoqianggou, $isJuhuashuan, $minPrice, $maxPrice, $isTmall, $minCommission, $minSellNum, $minCouponPrice, $maxCouponPrice);
            if($list){
                $list = (new GoodsHelper())->resizeGoodsListPic($list->toArray(), ['pic'=>'310x310']);
            }
            CacheHelper::setCache($list, 1, $params);
        }
        return $this->ajaxSuccess($list);
    }

    /**
     * 热搜词列表
     * @return static
     */
    public function hotKeyWord(){
        $data = ['耳机', '面膜', '口红', '保温杯', '卫衣', '毛衣女', '睡衣', '女鞋', '洗面奶', '充电宝'];
        return $this->ajaxSuccess($data);
    }

    /**
     * 全网搜索
     */
    public function queryAllGoods(Request $request){
        //搜索关键字
        $keyword = $request->get('keyword');
        $page = intval($request->input("page", 1));
        $limit = intval($request->input("limit", 20));
        //是否有店铺优惠券
        $hasShopCoupon = $request->get('has_shop_coupon', 0);
        //月成交转化率高于行业均值
        $isHighPayRate = $request->get('is_high_pay_rate', 0);
        //天猫旗舰店
        $isTmall = $request->get('is_tmall', 0);
        //最低销量筛选
        $minSellNum = $request->get('min_sell_num', 0);
        //最低佣金筛选
        $minCommission = $request->get('min_commission', 0);
        //最高佣金筛选
        $maxCommission = $request->get('max_commission', 0);
        //最低价格筛选
        $minPrice = $request->get('min_price');
        //最高价格筛选
        $maxPrice = $request->get('max_price');

        //商品排序
        $sort = $request->get('sort');
        $page = $page > 0 ? $page : 1;
        $limit = $limit > 0 ? $limit : 20;

        if(!$keyword){
            return $this->ajaxError("参数错误");
        }

        $params = $request->all();
        if(!$list = CacheHelper::getCache($params)){
            $list = (new GoodsService())->queryAllGoods($keyword, $hasShopCoupon, $isHighPayRate, $isTmall, $minSellNum, $minCommission, $maxCommission, $minPrice, $maxPrice, $page, $limit, $sort);
            if($list){
                $list = (new GoodsHelper())->resizeGoodsListPic($list, ['pic'=>'310x310']);
            }
            CacheHelper::setCache($list, 1, $params);
        }
        return $this->ajaxSuccess($list);
    }

}
