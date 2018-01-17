<?php

namespace App\Http\Controllers\Web;

use App\Helpers\CacheHelper;
use App\Helpers\GoodsHelper;
use App\Models\TaobaoToken;
use App\Models\User;
use App\Services\CategoryService;
use App\Services\ChannelColumnService;
use App\Services\GoodsService;
use App\Services\TaobaoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
    public function goodList(Request $request)
    {
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
        //金牌卖家
        $isJpseller = $request->get('is_jpseller', 0);
        //旗舰店
        $isQjd = $request->get('is_qjd', 0);
        //海淘
        $isHaitao = $request->get('is_haitao', 0);
        //极有家
        $isJyj = $request->get('is_jyj', 0);
        //运费险
        $isYfx = $request->get('is_yfx', 0);

        $userId = $request->user()->id;

        $list = (new GoodsService())->goodList($category, $sort, $keyword, $isTaoqianggou, $isJuhuashuan, $minPrice, $maxPrice, $isTmall, $minCommission, $minSellNum, $minCouponPrice, $maxCouponPrice, $isJpseller, $isQjd, $isHaitao, $isJyj, $isYfx, $userId);
        if ($list) {
            foreach ($list as $k => &$item) {
                $list[$k]['commission_finally'] = round($item['commission'] * ($item['price'] > 0 ? $item['price'] : $item['price_full']) / 100, 1);
                $keys = ['is_jpseller', 'is_qjd', 'is_haitao', 'is_tmallgj', 'is_jyjseller', 'is_freight_insurance'];
                foreach ($keys as $key) {
                    $value = $item[$key];
                    if ($value == 1) {
                        $item[$key] = 0;
                    } else if ($value == 2) {
                        $item[$key] = 1;
                    }
                }
            }
            $list = (new GoodsHelper())->resizeGoodsListPic($list, ['pic' => '240x240']);
        }

        return $this->ajaxSuccess($list);
    }

    /**
     * 推荐商品列表
     * @param Request $request
     * @return static
     */
    public function recommendGoods(Request $request)
    {

        //当前商品标题
        $title = $request->get('title');
        //淘宝商品id
        $taobaoGoodsId = $request->get('taobao_id');

        if (!$title) {
            return $this->ajaxError("参数错误");
        }

        $list = (new GoodsService())->recommendGoods($title, $taobaoGoodsId);
        if ($list) {
            $list = (new GoodsHelper())->resizeGoodsListPic($list, ['pic' => '240x240']);
        }
        return $list;

    }


    /**
     * 商品详情
     * @param $goodId
     * @return static
     */
    public function detail(Request $request, $goodId)
    {
        $columnCode = $request->get('columnCode');
        $data = (new GoodsService())->detail($goodId);
        if (!$data) {
            return $this->ajaxError("商品不存在", 404);
        }
        $data = (new GoodsHelper())->resizeGoodsListPic([$data], ['pic' => '480x480']);
        $title = '商品详情';
        $good = $data[0];

        $good['commission_finally'] = round($good['commission'] * ($good['price'] > 0 ? $good['price'] : $good['price_full']) / 100, 1);

        $request->offsetSet('title', $good['short_title']);
        $request->offsetSet('taobao_id', $good['id']);
        $list = $this->recommendGoods($request);
        $this->commissionHandler($list);

        $active = ['active_column_code' => $columnCode];

        return view('web.info', compact('good', 'list', 'title', 'active'));
    }

    /**
     * 去掉券后面多余的零计算佣金
     * @param $list
     * @return mixed
     */
    protected function  commissionHandler(&$list)
    {
        foreach ($list as $k => &$v) {
            $list[$k]['coupon_price'] = floatval($v['coupon_price']);
            $list[$k]['commission_finally'] = round($v['commission'] * ($v['price'] > 0 ? $v['price'] : $v['price_full']) / 100, 1);
        }
        return $list;
    }

    /**
     * 获取栏目商品列表
     * @param $columnCode 栏目代码
     * @return static
     */
    public function columnGoods(Request $request, $columnCode)
    {
        //商品分类
        $category = $request->get('category');
        //商品排序
        $sort = $request->get('sort');
        if ($isTmall = $request->get('today')) {
            $sort = 2;
        }
        //天猫筛选
        $isTmall = $request->get('isTmall', 0);
        $isJpseller = $request->get('isJpseller', 0);
        $isQjd = $request->get('isQjd', 0);
        $isHaitao = $request->get('isHaitao', 0);
        $isJyj = $request->get('isJyj', 0);
        $isYfx = $request->get('isYfx', 0);
        //淘抢购筛选
        $isTaoqianggou = $request->get('isTaoqianggou');
        //聚划算筛选
        $isJuhuashuan = $request->get('isJuhuashuan');
        //最低价格筛选
        $minPrice = $request->get('minPrice');
        //最高价格筛选
        $maxPrice = $request->get('maxPrice');
        $maxPrice = $request->get('isNine') ? 9.9 : $maxPrice;
        $maxPrice = $request->get('isTwenty') ? 20 : $maxPrice;

        //最低佣金筛选
        $minCommission = $request->get('minCommission', 0);
        //最低销量筛选
        $minSellNum = $request->get('minSellNum', 0);
        //最低券金额筛选
        $minCouponPrice = $request->get('minCouponPrice');
        //最高券金额筛选
        $maxCouponPrice = $request->get('maxCouponPrice');
        //关键字
        $keyword = $request->get('keyword');

        if ($columnCode == 'meishijingxuan' || $columnCode == 'jiajujingxuan') {
            $category = $columnCode == 'meishijingxuan' ? 6 : 4;
        } else {
            if (!(new ChannelColumnService())->getByCode($columnCode)) {
                return $this->ajaxError("栏目不存在");
            }
        }
        $params = $request->all();
        $params['column_code'] = $columnCode;


        if (!$list = CacheHelper::getCache($params) && !empty($list)) {
            /**
             *
             * 有条件的走goodList
             */
            if (!empty($keyword) || !empty($isJpseller) || !empty($isQjd) || !empty($isHaitao) || !empty($isJyj) || !empty($isYfx)
                || $columnCode == 'meishijingxuan' || $columnCode == 'jiajujingxuan'
            ) {
                $list = (new GoodsService())->goodList($category, $sort, $keyword, $isTaoqianggou, $isJuhuashuan, $minPrice, $maxPrice, $isTmall, $minCommission, $minSellNum, $minCouponPrice, $maxCouponPrice, $isJpseller, $isQjd, $isHaitao, $isJyj, $isYfx, 0);
            } else {
                //走栏目GoodList
                $list = (new GoodsService())->columnGoodList($columnCode, $category, $sort, $isTaoqianggou, $isJuhuashuan, $minPrice, $maxPrice, $isTmall, $minCommission, $minSellNum, $minCouponPrice, $maxCouponPrice);
            }

            $this->commissionHandler($list);

            CacheHelper::setCache($list, 1, $params);
        }

        /**
         * ajax加载更多
         */
        if ($request->ajax() && !empty($request->input('page'))) {
            return $this->ajaxSuccess($list);
        }

        $titles = ['today_tui' => '今日必推', 'today_jing' => '今日精选', 'xiaoliangbaokuan' => '爆款专区',
            'zhengdianmiaosha' => '限时快抢', 'meishijingxuan' => '美食精选', 'jiajujingxuan' => '家居精选'];
        $title = $titles[$columnCode];
        $categorys = (new CategoryService())->getAllCategory();
        $active_category = empty($category) ? '' : $category;
        $active = ['active_category' => $active_category, 'active_sort' => $sort, 'active_column_code' => $columnCode];
        return view('web.push_list', compact('list', 'title', 'categorys', 'active', 'keyword'));
    }


    public function getMiaoshaGoods(Request $request)
    {
        $time_step = $this->getTimes();
        $active_time = null;
        foreach ($time_step as $key => $val) {
            if ($val['status'] == '即将开始') {
                $key = $key - 1 >= 0 ? $key - 1 : 0;
                $active_time = $time_step[$key]['active_time'];
                break;
            }
        }
        //如果没有即将开始就让当前最接近时间做作为当前抢购时间
        if (!$active_time) {
            $active_time = $time_step[sizeof($time_step) - 1]['active_time'];
        }


        //秒杀时间点
        $activeTime = $request->get('active_time', $active_time);
        $params = $request->all();
        if (!$list = CacheHelper::getCache($params)) {
            $list = (new ChannelColumnService())->miaoshaGoods($activeTime);
            if ($list) {
                $list = (new GoodsHelper())->resizeGoodsListPic($list->toArray(), ['pic' => '240x240']);
            }
            $this->commissionHandler($list);

            CacheHelper::setCache($list, 5, $params);
        }
        $columnCode = 'zhengdianmiaosha';
        $titles = ['today_tui' => '今日必推', 'today_jing' => '今日精选', 'xiaoliangbaokuan' => '爆款专区',
            'zhengdianmiaosha' => '限时快抢', 'meishijingxuan' => '美食精选', 'jiajujingxuan' => '家居精选'];
        $title = $titles[$columnCode];
        $active = ['active_column_code' => $columnCode, 'active_time' => $activeTime];
        return view('web.zhengdianmiaosha', compact('list', 'title', 'active', 'time_step'));

    }


    public function getTimes()
    {
        if (!$data = CacheHelper::getCache()) {
            $year = date("Y");
            $month = date("m");
            $day = date("d");
            $start = mktime(0, 0, 0, $month, $day, $year);//当天开始时间戳
            $end = mktime(23, 59, 59, $month, $day + 1, $year);//明天结束时间戳

            $startTime = date('Y-m-d H:i:s', $start);
            $endTime = date('Y-m-d H:i:s', $end);

            $data = (new ChannelColumnService())->miaoshaTimes($startTime, $endTime);
            CacheHelper::setCache($data, 5);
        }
        $times = [];

        foreach ($data as $key => $val) {
            $times[$key]['time'] = $val['time'];
            $times[$key]['active_time'] = $val['active_time'];
            if (strtotime($val['active_time']) < time()) {
                $times[$key]['status'] = '进行中';
            } else {
                $times[$key]['status'] = '即将开始';
            }
        }
        return $times;
    }

    /**
     * 热搜词列表
     * @return static
     */
    public function hotKeyWord()
    {
        $data = ['耳机', '面膜', '口红', '保温杯', '卫衣', '毛衣女', '睡衣', '女鞋', '洗面奶', '充电宝'];
        return $this->ajaxSuccess($data);
    }

    /**
     * 全网搜索
     */
    public function queryAllGoods(Request $request)
    {
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

        if (!$keyword) {
            return $this->ajaxError("参数错误");
        }

        $params = $request->all();
        if (!$list = CacheHelper::getCache($params)) {
            $list = (new GoodsService())->queryAllGoods($keyword, $hasShopCoupon, $isHighPayRate, $isTmall, $minSellNum, $minCommission, $maxCommission, $minPrice, $maxPrice, $page, $limit, $sort);
            if ($list) {
                $list = (new GoodsHelper())->resizeGoodsListPic($list, ['pic' => '310x310']);
            }
            CacheHelper::setCache($list, 1, $params);
        }
        return $this->ajaxSuccess($list);
    }

    /**
     * 查询商品佣金
     */
    public function commission(Request $request)
    {
        $taobaoId = $request->get('taobao_id');
        $data = (new GoodsService())->commission($taobaoId);
        $data = $data ?: [
            //实际佣金
            'commission' => -1,
            //原始佣金
            'originCommission' => -1
        ];
        return $this->ajaxSuccess($data);
    }

}
