<?php
/**
 * Created by PhpStorm.
 * User: yangtao
 * Date: 2017/10/24
 * Time: 15:11
 */
namespace App\Services;

use App\Helpers\ErrorHelper;
use App\Helpers\GoodsHelper;
use App\Models\Banner;
use App\Models\Goods;
use App\Models\GoodsCategory;
use App\Models\MarketState;
use App\Models\WechatPage;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class MarketStateService
{
    /**
     * 指定APP是否在审核中
     * @param $app app名称
     * @param $version app版本号
     */
    public function isAudit($app, $version){
        return MarketState::where([
            'app' => trim($app),
            'version' => trim($version)
        ])->exists();
    }
}
