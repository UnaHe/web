<?php
/**
 * Created by PhpStorm.
 * User: yangtao
 * Date: 2017/12/26
 * Time: 13:46
 */
namespace App\Services;

use App\Helpers\CacheHelper;
use App\Helpers\EsHelper;
use App\Helpers\GoodsHelper;
use App\Helpers\ProxyClient;
use App\Helpers\QueryHelper;
use App\Helpers\UtilsHelper;
use App\Models\ColumnGoodsRel;
use App\Models\Goods;
use App\Models\TaobaoToken;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * 查询阿里妈妈商品详情
 * Class AlimamaGoodsService
 * @package App\Services
 */
class AlimamaGoodsService
{
    private $client;

    public function __construct(){
        $this->client = new ProxyClient();
    }


    /**
     * 获取商品详情
     * @param $goodsId
     * @return mixed
     */
    public function detail($goodsId){
        $goodsUrl = (new GoodsHelper())->generateTaobaoUrl($goodsId);

        $url = "http://pub.alimama.com/items/search.json?q=".urlencode($goodsUrl)."&auctionTag=&perPageSize=40&shopTag=";
        $mamaDetail = $this->client->get($url)->getBody()->getContents();

        try{
            $mamaDetail = json_decode($mamaDetail, true);
            $result = $mamaDetail['data']['pageList'][0];
        }catch (\Exception $e){
            return null;
        }

        return $result;
    }

}