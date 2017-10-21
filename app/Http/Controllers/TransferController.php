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
        $token = '70002100147174d2238ce84718120cb3445cc38fd28ee5cc95b3640a8d51d55072ecd15678083733';
        $pid = 'mm_99303416_7688581_25870399';
        $taobaoGoodsId = $request->post('taobaoId');
        $title = $request->post('title');
        if(!$taobaoGoodsId || !$title){
            return $this->ajaxError("参数错误");
        }

        if(mb_strlen($title) < 5){
            return $this->ajaxError("商品标题不能少于5个字");
        }

        try{
            $data = (new TransferService())->transferGoods($taobaoGoodsId, $title,$pid,$token);
        }catch (\Exception $e){
            return $this->ajaxError($e->getMessage());
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
