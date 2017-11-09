<?php
/**
 * Created by PhpStorm.
 * User: yangtao
 * Date: 2017/10/18
 * Time: 15:51
 */
namespace App\Services;

use App\Helpers\CacheHelper;
use App\Helpers\ErrorHelper;
use App\Helpers\GoodsHelper;
use App\Helpers\ProxyClient;
use App\Helpers\UrlHelper;
use App\Models\Banner;
use App\Models\GoodsCategory;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Log;

class TransferService
{
    private $topClient;

    public function __construct(){
        include_once app_path("Librarys/Taobao/TopSdk.php");
        $this->topClient = new \TopClient(config('taobao.appkey'), config('taobao.secretkey'));
        $this->topClient->format="json";
    }

    /**
     * 高效转链
     * @param $taobaoGoodsId 淘宝商品id
     * @param $pid 用户联盟PID
     * @param $token 用户授权token
     * @return mixed
     * @throws \Exception
     */
    public function transferLink($taobaoGoodsId, $pid, $token){
        if($cache = CacheHelper::getCache()){
            return $cache;
        }

        $pids = explode('_',$pid);
        $req = new \TbkPrivilegeGetRequest;
        $req->setItemId($taobaoGoodsId);
        $req->setAdzoneId($pids[3]); //B pid 第三位
        $req->setPlatform("1");
        $req->setSiteId($pids[2]);//A pid 第二位
        $resp = $this->topClient->execute($req, $token);

        //转换失败
        if (!$resp){
            throw new \Exception("转链失败");
        }

        //判断结果
        if(isset($resp['code'])){
            if($resp['code'] == 26){
                throw new \Exception("授权过期", ErrorHelper::ERROR_TAOBAO_INVALID_SESSION);
            }

            if(isset($resp['sub_code'])) {
                if ('invalid-sessionkey' == $resp['sub_code']) {
                    //session过期
                    throw new \Exception("授权过期", ErrorHelper::ERROR_TAOBAO_INVALID_SESSION);
                } else if ('isv.item-not-exist' == $resp['sub_code']) {
                    //商品错误
                    throw new \Exception("宝贝已下架或非淘客宝贝", ErrorHelper::ERROR_TAOBAO_INVALID_GOODS);
                } else if ('isv.pid-not-correct' == $resp['sub_code']) {
                    //pid错误
                    throw new \Exception("PID错误", ErrorHelper::ERROR_TAOBAO_INVALID_PID);
                }
            }
            throw new \Exception("转链失败");
        }

        $result = $resp['result']['data'];
        CacheHelper::setCache($result, 5);
        return $result;
    }

    /**
     * 淘宝短链接sclick转换
     * @param $url 原始url
     * @return mixed
     */
    public function transferSclick($url){
        if($cache = CacheHelper::getCache()){
            return $cache;
        }

        try{
            $req = new \TbkSpreadGetRequest;
            $requests = new \TbkSpreadRequest;
            $requests->url = $url;
            $req->setRequests(json_encode($requests));
            $resp = $this->topClient->execute($req);
            $result = (array)$resp;

            if(isset($result['code'])){
                switch($result['sub_code']){
                    case 'isv.appkey-not-exists':
                        $error = "官方接口数据出错，请稍后再试！";
                        break;
                    case 'PARAMETER_ERROR_TITLE_ILLEGAL':
                        $error = "标题中包含敏感词汇，请检查标题内容后重试。";
                        break;
                    default:
                        $error = "官方接口数据出错，请稍后再试！";
                        break;
                }
                throw new \Exception($error);
            }

            $data = $result['results']['tbk_spread'][0]['content'];
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }

        CacheHelper::setCache($data, 5);
        return $data;
    }

    /**
     * 转淘口令
     * @param $title
     * @param $url
     * @return mixed
     */
    public function transferTaoCode($title, $url, $pic=""){
        if($cache = CacheHelper::getCache()){
            return $cache;
        }

        try{
            $req = new \TbkTpwdCreateRequest;
            $req->setUserId("1");
            $req->setText($title);
            $req->setUrl($url);
            $req->setLogo($pic);
            $req->setExt("{}");
            $resp = $this->topClient->execute($req);
            $result = (array)$resp;
            $data = $result['data']['model'];
        }catch (\Exception $e){
            throw new \Exception('淘口令转换失败');
        }

        CacheHelper::setCache($data);
        return $data;
    }

    /**
     * 商品转链
     */
    public function transferGoodsByUser($goodsId, $couponId, $title, $description, $pic, $priceFull, $couponPrice, $sellNum, $userId){
        if($cache = CacheHelper::getCache()){
            return $cache;
        }

        try{
            $token = (new TaobaoService())->getToken($userId);
            $pid = (new TaobaoService())->getPid($userId);
            if(!$token){
                throw new \Exception("未授权", ErrorHelper::ERROR_TAOBAO_INVALID_SESSION);
            }
            if(!$pid){
                throw new \Exception("PID错误", ErrorHelper::ERROR_TAOBAO_INVALID_PID);
            }
            $data = $this->transferGoods($goodsId, $couponId, $title, $pic, $pid, $token);

            $goodsInfo = [
                'goods_id' => $goodsId,
                'tao_code' => $data['tao_code'],
                'url' => $data['url'],
                's_url' => $data['s_url'],
                'pic' => $pic,
                'title' => $title,
                'description' => $description,
                'coupon_price' => $couponPrice,
                'price_full' => $priceFull,
            ];
            $wechatUrl = (new WechatPageService())->createPage($goodsInfo, $userId);
            //使用短网址
            $wechatUrl = (new UrlHelper())->shortUrl($wechatUrl);
            $data['wechat_url'] = $wechatUrl;

            $shareData = [
                'title' => $title,
                'price' => $priceFull,
                'used_price' => bcsub($priceFull, $couponPrice, 2),
                'coupon_price' => $couponPrice,
                'description' => $description,
                'tao_code' => $data['tao_code'],
                'wechat_url' => $wechatUrl,
                'sell_num' => $sellNum,
            ];
            //分享描述
            $data['share_desc'] = (new GoodsService())->getShareDesc($shareData);

        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }

        CacheHelper::setCache($data, 5);
        return $data;
    }

    /**
     * 商品转链
     * @param $goodsId 淘宝商品id
     * @param $couponId 指定优惠券
     * @param $title 标题
     * @param $pid pid
     * @param $token 淘宝session
     * @return array
     * @throws \Exception
     */
    public function transferGoods($goodsId, $couponId, $title, $pic, $pid, $token){
        if($cache = CacheHelper::getCache()){
            return $cache;
        }

        try{
            $result = $this->transferLink($goodsId,$pid,$token);
            $url = $result['coupon_click_url'];
            if($couponId){
                $url .= "&activityId=".$couponId;
            }
            $slickUrl = $this->transferSclick($url);
            $taoCode = $this->transferTaoCode($title, $slickUrl, $pic);
            $data = [
                'goods_id' => $goodsId,
                'url' => $url,
                's_url' => $slickUrl,
                'tao_code' => $taoCode
            ];
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }

        CacheHelper::setCache($data, 5);
        return $data;
    }

    /**
     * 获取跳转地址
     * @param $url
     * @param null $referer
     * @return mixed
     */
    public function getRedirectUrl($url, $referer=null){
        static $client;
        if(!$client){
            $client = new ProxyClient();
        }
        $response = $client->request('GET', $url, [
            'verify' => false,
            'headers' => [
                'Referer' => $referer,
            ],
            RequestOptions::ALLOW_REDIRECTS => [
                'max'             => 10,        // allow at most 10 redirects.
                'strict'          => true,      // use "strict" RFC compliant redirects.
                'referer'         => true,      // add a Referer header
                'track_redirects' => true,
            ],
        ]);
        $redirectUriHistory = $response->getHeader('X-Guzzle-Redirect-History'); // retrieve Redirect URI history
        return array_pop($redirectUriHistory);
    }

    /**
     * 获取最终跳转链接地址
     * @param $url
     * @return mixed
     */
    public function getFinalUrl($url){
        if(strpos($url, 's.click.taobao.com/t?')){
            $url = $this->getRedirectUrl($url);
            return $this->getFinalUrl($url);
        }else if(strpos($url, 's.click.taobao.com/t_js?tu=')){
            parse_str(parse_url($url)['query'], $query);
            $tu = $query['tu'];
            $url = $this->getRedirectUrl($tu, $url);
            return $url;
        }else if(strpos($url, 's.click.taobao.com/')){
            $url = $this->getRedirectUrl($url);
            return $this->getFinalUrl($url);
        }else if(strpos($url, 'item.taobao.com/item.htm')){
            return $url;
        }else if(strpos($url, 'a.m.taobao.com/i')){
            preg_match("/a\.m\.taobao\.com\/i(\d+)/", $url, $matchItemId);
            return "http://item.taobao.com/item.htm?id=".$matchItemId[1];
        }else if(strpos($url, 'uland.taobao.com')){
            return $url;
        }else if(strpos($url, 'detail.tmall.com')){
            return $url;
        }else if(strpos($url, 'detail.ju.taobao.com')){
            preg_match("/detail\.ju\.taobao\.com.*?[\?&]item_id=(\d+)/", $url, $matchItemId);
            return "http://item.taobao.com/item.htm?id=".$matchItemId[1];
        }else if(strpos($url, 'tqg.taobao.com')){
            preg_match("/tqg\.taobao\.com.*?[\?&]itemId=(\d+)/", $url, $matchItemId);
            return "http://item.taobao.com/item.htm?id=".$matchItemId[1];
        }else{
            //默认查询关键字拼url
            if(preg_match("/(taobao|tmall)\.com.*?[\?&]itemId=(\d+)/", $url, $matchItemId)){
                return "http://item.taobao.com/item.htm?id=".$matchItemId[2];
            }else if(preg_match("/(taobao|tmall)\.com.*?[\?&]item_id=(\d+)/", $url, $matchItemId)){
                return "http://item.taobao.com/item.htm?id=".$matchItemId[2];
            }else if(preg_match("/(taobao|tmall)\.com.*?[\?&]id=(\d+)/", $url, $matchItemId)){
                return "http://item.taobao.com/item.htm?id=".$matchItemId[2];
            }
        }
    }

    /**
     * 解析淘口令
     * @param $taoCode
     * @return mixed
     */
    public function queryTaoCode($code, $isMiao, $userId){
        if($cache = CacheHelper::getCache()){
            return $cache;
        }

        $client = new ProxyClient(['cookie'=>true]);
        $jar = new \GuzzleHttp\Cookie\CookieJar;

        //淘口令解析
        $data	= '{"password":"'.$code.'"}';
        $api	= 'com.taobao.redbull.getpassworddetail';
        $appKey = '21646297';
        $v		= '1.0';
        $t		= '0';
        $cookieUrl	= 'http://api.m.taobao.com/rest/h5ApiUpdate.do?callback=jsonp11&timeout=10050&type=&api='.$api.'&v='.$v;

        //第一次取cookie参数
        $client->request('GET', $cookieUrl, ['cookies' => $jar]);
        $h5TkCookie = $jar->getCookieByName('_m_h5_tk')->getValue();
        $h5Tk = explode('_', $h5TkCookie)[0];

        if(!$isMiao){
            //拼接实际请求地址
            $sign	= md5($h5Tk.'&'.$t.'&'.$appKey.'&'.$data);
            $url	= $cookieUrl.'&appKey='.$appKey.'&sign='.$sign.'&t='.$t.'&data='.$data;

            $response = $client->request('GET', $url, ['cookies' => $jar])->getBody()->getContents();
            $result = json_decode($response, true);

            if(!strstr($response, '调用成功') || !isset($result['data'])){
                return false;
            }

            $taoCodeData = $result['data'];
            $lastUrl = $taoCodeData['url'];

            //获取最终跳转地址
            $lastUrl = $this->getFinalUrl($lastUrl);
        }else{
            //喵口令解析
            $response = $client->get($code);
            if(!$response){
                throw new \Exception("喵口令解析失败");
            }
            $content = $response->getBody()->getContents();
            if(!preg_match("/\"itemId\":(\d+)/", $content, $matchItemId)){
                throw new \Exception("喵口令解析失败");
            }
            $lastUrl =  "http://item.taobao.com/item.htm?id=".$matchItemId[1];
        }
        //var_dump($lastUrl);exit;
        if(!strpos($lastUrl, "uland.taobao.com")){
            if(preg_match("/item\.taobao\.com.*?[\?&]id=(\d+)/", $lastUrl, $matchItemId)){
                $matchItemId = $matchItemId[1];
            }else if(preg_match("/edetail\.tmall\.com.*?[\?&]id=(\d+)/", $lastUrl, $matchItemId)){
                $matchItemId = $matchItemId[1];
            }

            if(!$matchItemId){
                throw new \Exception("淘口令解析失败");
            }
            $itemId = $matchItemId;

            $token = (new TaobaoService())->getToken($userId);
            $pid = (new TaobaoService())->getPid($userId);
            if(!$token){
                throw new \Exception("未授权", ErrorHelper::ERROR_TAOBAO_INVALID_SESSION);
            }
            if(!$pid){
                throw new \Exception("PID错误", ErrorHelper::ERROR_TAOBAO_INVALID_PID);
            }
            try{
                $result = $this->transferLink($itemId, $pid, $token);
                $lastUrl = $result['coupon_click_url'];

            }catch (\Exception $e){
                throw new \Exception($e->getMessage(), $e->getCode());
            }
        }

        parse_str(parse_url($lastUrl)['query'], $lastUrlParams);

        //需要传递的参数
        $apiParamData = [];
        $params = ['e','me','dx','itemId','activityId','pid','src','scm','engpvid','mt','couponType','ptl'];
        foreach($params as $param){
            if(isset($lastUrlParams[$param])){
                $apiParamData[$param] = $lastUrlParams[$param];
            }
        }

        $apiUrl = 'https://acs.m.taobao.com/h5/mtop.alimama.union.hsf.coupon.get/1.0/';
        $apiParams = [
            'jsv' => '2.3.16',
            'appKey' => '12574478',
            't' => time(),
            'api' => 'mtop.alimama.union.hsf.coupon.get',
            'v' => '1.0',
            'AntiCreep' => 'true',
            'type' => 'jsonp',
            'dataType' => 'jsonp',
            'callback' => 'mtopjsonp1',
            'data' => str_replace("\\/", "/", json_encode($apiParamData))
        ];


        //拼接实际请求地址
        $sign	= md5($h5Tk.'&'.$apiParams['t'].'&'.$apiParams['appKey'].'&'.$apiParams['data']);
        $apiParams['sign'] = $sign;
        $url	= $apiUrl."?".http_build_query($apiParams);

        $response = $client->request('GET', $url, ['cookies' => $jar, 'verify' => false])->getBody()->getContents();
        if(!strstr($response, '调用成功')){
            return false;
        }

        if(!preg_match('/mtopjsonp1\((.*)\)/', $response, $matchs)){
            return false;
        }

        $result = json_decode($matchs[1], true);

        $itemId = $result['data']['result']['item']['itemId'];
        $isTmall = $result['data']['result']['item']['tmall'];
        $priceFull = $result['data']['result']['item']['discountPrice'];
        $title = $result['data']['result']['item']['title'];
        $sellerName = $result['data']['result']['shopName'];
        $sellerIcon = isset($result['data']['result']['shopLogo']) ? $result['data']['result']['shopLogo'] : '';
        $couponId = isset($lastUrlParams['activityId']) ? $lastUrlParams['activityId'] : null;
        $couponPrice = isset($result['data']['result']['amount']) ? $result['data']['result']['amount'] : 0;
        $couponTime = isset($result['data']['result']['effectiveEndTime']) ? $result['data']['result']['effectiveEndTime'] : null;
        $couponPrerequisite = isset($result['data']['result']['startFee']) ? $result['data']['result']['startFee'] : 0;

        //从数据库获取信息填充
        $detail = (new GoodsService())->getByGoodsId($itemId);
        $couponMLink = (!$couponId && $detail) ? $detail['coupon_m_link'] : null;
        $couponLink = (!$couponId && $detail) ? $detail['coupon_link']: null;
        $couponPrice = (!$couponId && $detail) ? $detail['coupon_price'] : $couponPrice;
        $couponTime = (!$couponId && $detail) ? $detail['coupon_time'] : $couponTime;
        $couponPrerequisite = (!$couponId && $detail) ? $detail['coupon_prerequisite'] : $couponPrerequisite;
        $couponNum = (!$couponId && $detail) ? $detail['coupon_num'] : 0;
        $couponOver = (!$couponId && $detail) ? $detail['coupon_over'] : 0;
        $couponId = (!$couponId && $detail) ? $detail['coupon_id'] : $couponId;

        $commissionType = $detail ? $detail['commission_type'] : 0;
        $commission = $detail? $detail['commission'] : 0;
        $commissionMarketing = $detail? $detail['commission_marketing'] : 0;
        $commissionPlan = $detail? $detail['commission_plan'] : 0;
        $commissionBridge = $detail? $detail['commission_bridge'] : 0;

        $sellerId = $detail ? $detail['seller_id'] : null;
        $sellerName = (!$sellerName && $detail) ? $detail['seller_name'] : $sellerName;
        $sellerIcon = (!$sellerIcon && $detail) ? $detail['seller_icon_url'] : $sellerIcon;

        $isJuhuashuan = $detail ? $detail['is_juhuashuan'] : 0;
        $isTaoqianggou = $detail ? $detail['is_taoqianggou'] : 0;
        $isDeliveryFee = $detail ? $detail['is_delivery_fee'] : 0;

        $planLink = $detail ? $detail['plan_link'] : 0;
        $planApply = $detail ? $detail['plan_apply'] : 0;

        $catagoryId = $detail ? $detail['catagory_id'] : 0;
        $dsr = $detail ? $detail['dsr'] : 0;
        $des = $detail ? $detail['des'] : "";
        $goodsUrl = (new GoodsHelper())->generateTaobaoUrl($itemId, $isTmall);

        //没有佣金则从联盟查询
        if(!$commission){
            $url = "http://pub.alimama.com/items/search.json?q=".urlencode($goodsUrl)."&auctionTag=&perPageSize=40&shopTag=";
            $mamaDetail = $client->get($url)->getBody()->getContents();
            if($mamaDetail){
                try{
                    $mamaDetail = json_decode($mamaDetail, true);
                    $mamaDetail = $mamaDetail['data']['pageList'][0];
                    $commission = $commission?: ($mamaDetail['eventRate'] > $mamaDetail['tkRate'] ? $mamaDetail['eventRate'] : $mamaDetail['tkRate']);
                    if(!$couponId && $mamaDetail['couponAmount']){
                        $couponTime = $mamaDetail['couponEffectiveEndTime']." 23:59:59";
                        $couponPrice = $mamaDetail['couponAmount'];
                        $couponPrerequisite = $mamaDetail['couponStartFee'];
                        $couponNum = $mamaDetail['couponTotalCount'];
                        $couponOver = $mamaDetail['couponLeftCount'];
                        $couponId = $mamaDetail['couponActivityId'];
                    }
                }catch (\Exception $e){
                    Log::error("查询联盟商品佣金失败， 商品id:".$itemId);
                }
            }
        }

        $data = [
            'goodsid' => $itemId,
            'goods_url' => $goodsUrl,
            'short_title' => $title,
            'title' => $title,
            'sell_num' => $result['data']['result']['item']['biz30Day'],
            'pic' => $result['data']['result']['item']['picUrl'],
            'price' => bcsub($priceFull, $couponPrice, 2),
            'price_full' => $priceFull,
            'coupon_time' => $couponTime,
            'coupon_price' => $couponPrice,
            'coupon_prerequisite' => $couponPrerequisite,
            'coupon_num' => $couponNum,
            'coupon_over' => $couponOver,
            'seller_name' => $sellerName,
            'seller_icon_url' => $sellerIcon,
            'is_tmall' => $isTmall,
            'coupon_id' => $couponId,
            'coupon_m_link'=> $couponMLink,
            'coupon_link'=> $couponLink,
            'catagory_id' => $catagoryId,
            'dsr' => $dsr,
            'seller_id' => $sellerId,
            'is_juhuashuan' => $isJuhuashuan,
            'is_taoqianggou' => $isTaoqianggou,
            'is_delivery_fee' => $isDeliveryFee,
            'des' => $des,
            'plan_link' => $planLink,
            'plan_apply' => $planApply,
            'commission_type' => $commissionType,
            'commission' => $commission,
            'commission_marketing' => $commissionMarketing,
            'commission_plan' => $commissionPlan,
            'commission_bridge' => $commissionBridge,
        ];

        $shareData = [
            'title' => $data['title'],
            'price' => $data['price_full'],
            'used_price' => $data['price'],
            'coupon_price' => $data['coupon_price'],
            'description' => $data['des'],
            'sell_num' => $data['sell_num'],
        ];
        //分享描述
        $data['share_desc'] = (new GoodsService())->getShareDesc($shareData);

        $expireTime = null;
        if(!$isMiao){
            $expireTime = Carbon::createFromTimestamp(substr($taoCodeData['validDate'], 0, 10));
        }else{
            $expireTime = Carbon::now()->addDay(5);
        }
        CacheHelper::setCache($data, $expireTime);
        return $data;
    }
}
