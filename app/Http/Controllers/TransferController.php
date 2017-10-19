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
        if(!$taobaoGoodsId){
            return $this->ajaxError("参数错误");
        }

        try{
            $data = (new TransferService())->transferLink($taobaoGoodsId,$pid,$token);
        }catch (\Exception $e){
            return $this->ajaxError($e->getMessage());
        }
        return $this->ajaxSuccess($data);
    }
}
