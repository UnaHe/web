<?php

namespace App\Http\Controllers;

use App\Helpers\CacheHelper;
use App\Helpers\GoodsHelper;
use App\Services\ChannelColumnService;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * 整点秒杀
 * Class MiaoshaController
 * @package App\Http\Controllers
 */
class MiaoshaController extends Controller
{
    /**
     * 获取秒杀时间点
     */
    public function getTimes(){
        if(!$data = CacheHelper::getCache()){
//            $startTime = (new Carbon())->startOfDay()->toDateTimeString();
//            $endTime = (new Carbon())->endOfDay()->toDateTimeString();

            $year = date("Y");
            $month = date("m");
            $day = date("d");
            $start = mktime(0,0,0,$month,$day,$year);//当天开始时间戳
            $end= mktime(23,59,59,$month,$day+1,$year);//明天结束时间戳

            $startTime = date('Y-m-d H:i:s', $start);
            $endTime =date('Y-m-d H:i:s', $end);

            $data = (new ChannelColumnService())->miaoshaTimes($startTime, $endTime);
            CacheHelper::setCache($data, 5);
        }

        return $this->ajaxSuccess($data);
    }

    /**
     * 服务器时间
     */
    public function getServerTime(){
        return $this->ajaxSuccess(time());
    }


    /**
     * 获取秒杀时间点商品列表
     */
    public function getGoods(Request $request){
        //秒杀时间点
        $activeTime = $request->get('active_time');
        $params = $request->all();
        if(!$data = CacheHelper::getCache($params)){
            $data = (new ChannelColumnService())->miaoshaGoods($activeTime);
            if($data){
                $data = (new GoodsHelper())->resizeGoodsListPic($data->toArray(), ['pic'=>'240x240']);
            }
            CacheHelper::setCache($data, 5, $params);
        }

        return $this->ajaxSuccess($data);
    }

}
