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
use App\Models\WechatPage;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\URL;

class WechatPageService
{
    /**
     * 创建微信单页
     * @param $taotaoGoodsId 淘宝商品id
     * @param $taoCode 淘口令
     * @param $url 二合一链接
     * @param $userId 用户id
     * @param $shortUrl 短链接
     * @param $goodsLibId 商品库id
     */
    public function createPage($taotaoGoodsId, $taoCode, $url, $userId, $shortUrl=null){
        $goodsLibId = Goods::where('goodsid', $taotaoGoodsId)->pluck('id')->first();
        $data = [
            'user_id' => $userId,
            'goods_id' => $taotaoGoodsId,
            'url' => $url,
            'tao_code' => $taoCode,
            'create_time' => date('Y-m-d h:i:s')
        ];
        if($shortUrl){
            $data['short_url'] = $shortUrl;
        }
        if($goodsLibId){
            $data['goods_lib_id'] = $goodsLibId;
        }

        $id = WechatPage::create($data);
        if($id){
            return $this->getPageUrl($id);
        }
        return false;
    }

    /**
     * 获取微信单页链接
     * @param $id
     * @return mixed
     */
    public function getPageUrl($id){
        return URL::action('WechatPageController@page', ['id'=>$id]);
    }

    /**
     * 查询单页商品信息
     * @param $id
     */
    public function getPage($id){
        $wechatPage = WechatPage::where("id", $id)->first();
        if(!$wechatPage){
            throw new \Exception("商品不存在");
        }
    }
}
