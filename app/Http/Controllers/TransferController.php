<?php

namespace App\Http\Controllers;

use App\Models\ChannelColumn;
use App\Models\Goods;
use App\Services\ChannelColumnService;
use App\Services\GoodsService;
use App\Services\TransferService;
use Illuminate\Database\Schema\Grammars\ChangeColumn;
use Illuminate\Http\Request;


/**
 * 转换工具
 * Class TransferController
 * @package App\Http\Controllers
 */
class TransferController extends Controller
{
    /**
     * 转链接
     */
    public function transferLink(Request $request){
        $taobaoGoodsId = $request->post('taobaoId');
        $couponId = $request->post('couponId');
        $title = $request->post('title');
        $description = $request->post('description');
        $pic = $request->post('pic');
        $priceFull = $request->post('priceFull');
        $couponPrice = $request->post('couponPrice');
        if(!$taobaoGoodsId || !$title || !$pic || !$priceFull || !$couponPrice){
            return $this->ajaxError("参数错误");
        }

        if(mb_strlen($title) < 5){
            return $this->ajaxError("商品标题不能少于5个字");
        }

        try{
            $data = (new TransferService())->transferGoodsByUser($taobaoGoodsId, $couponId, $title, $description, $pic, $priceFull, $couponPrice, $request->user()->id);
        }catch (\Exception $e){
            $errorCode = $e->getCode();
            return $this->ajaxError($e->getMessage(), $errorCode ?: 300);
        }
        return $this->ajaxSuccess($data);
    }

    /**
     * 淘口令解析
     */
    public function queryTaoCode(Request $request){
        $content = $request->post('content');
        if(!preg_match('/￥(.*?)￥/', $content, $matchs)){
            return $this->ajaxError("请求内容中无淘口令");
        }
        $data = (new TransferService())->queryTaoCode($matchs[1]);
        if($data === false){
            return $this->ajaxError("淘口令解析失败");
        }

        return $this->ajaxSuccess($data);
    }
}
