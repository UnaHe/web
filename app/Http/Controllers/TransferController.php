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
        $couponPrice = $request->post('couponPrice', 0);
        $sellNum = $request->post('sell_num', 0);
        if(!$taobaoGoodsId || !$title || !$pic || !$priceFull){
            return $this->ajaxError("参数错误");
        }

        if(mb_strlen($title) < 5){
            return $this->ajaxError("商品标题不能少于5个字");
        }

        try{
            $data = (new TransferService())->transferGoodsByUser($taobaoGoodsId, $couponId, $title, $description, $pic, $priceFull, $couponPrice, $sellNum, $request->user()->id);
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
        $code = null;
        $isMiao = false;
        $isLink = false;
        //淘口令
        if(preg_match('/([\x{300a}\x{ffe5}]){1}([0-9A-Za-z]+?)\1/u', $content, $matchs)){
            $code = $matchs[2];
        //淘口令
        }else if(preg_match('/🔑([0-9A-Za-z]+?)🔑/', $content, $matchs)){
            $code = $matchs[1];
        //匹配喵口令
        }else if(preg_match('/(http:\/\/[\w0-9\.\/\?\&=\-\+%]+).*?喵口令/', $content, $matchs)){
            $code = $matchs[1];
            $isMiao = true;
        //匹配天猫详情
        }else if(preg_match('/(http[s]?:\/\/detail\.tmall\.com\/item\.htm[\w0-9\.\/\?\&=\-\+%]+)/', $content, $matchs)){
            $code = $matchs[1];
            $isLink = true;
        //匹配淘宝详情
        }else if(preg_match('/(http[s]?:\/\/item\.taobao\.com\/item\.htm[\w0-9\.\/\?\&=\-\+%]+)/', $content, $matchs)){
            $code = $matchs[1];
            $isLink = true;
        //匹配短链接
        }else if(preg_match('/(http[s]?:\/\/s\.click\.taobao\.com[\w0-9\.\/\?\&=\-\+%]+)/', $content, $matchs)){
            $code = $matchs[1];
            $isLink = true;
        }else{
            return $this->ajaxError("请求内容中无淘口令或淘宝详情地址");
        }

        try{
            $data = (new TransferService())->queryTaoCode($code, $isMiao, $isLink, $request->user()->id);
            if($data === false){
                throw new \Exception('淘口令解析失败');
            }
        }catch (\Exception $e){
            $errorCode = $e->getCode();
            return $this->ajaxError($e->getMessage(), $errorCode ?: 300);
        }

        return $this->ajaxSuccess($data);
    }
}
