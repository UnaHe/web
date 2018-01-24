<?php

namespace App\Http\Controllers;

use App\Services\MarketStateService;
use Illuminate\Http\Request;

/**
 * 市场状态
 * Class MarketStateController
 * @package App\Http\Controllers
 */
class MarketStateController extends Controller
{
    /**
     * 获取APP市场状态
     * @param Request $request
     */
    public function marketState(Request $request){
        $appName = $request->header('app');
        $version = $request->header('version');

        $isAudit = (new MarketStateService())->isAudit($appName, $version);
        if($isAudit){
            return $this->ajaxError('');
        }else{
            return $this->ajaxSuccess();
        }
    }
}
