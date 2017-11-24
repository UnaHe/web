<?php
/**
 * Created by PhpStorm.
 * User: yangtao
 * Date: 2017/10/23
 * Time: 15:51
 */
namespace App\Services;


use App\Helpers\CacheHelper;
use App\Helpers\ErrorHelper;
use App\Helpers\ProxyClient;
use App\Models\Goods;
use App\Models\TaobaoPid;
use App\Models\TaobaoToken;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Log;

class TaobaoService
{
    private $appKey = 12574478;
    private $version = "1.0";
    private $h5Tk;
    private $client;
    private $cookieJar;

    /**
     * 保存淘宝token
     * @param $userId
     * @param $tokens
     */
    public function saveAuthToken($userId, $tokens, $cookie){
        $time = time();
        $now  = date('Y-m-d H:i:s', $time);

        $token = TaobaoToken::where("user_id", $userId)->first();
        if(!$token){
            $token = new TaobaoToken();
            $token['create_time'] = $now;
            $token['user_id'] = $userId;
        }
        try{
            $token['access_token'] = $tokens['access_token'];
            $token['token_type'] = $tokens['token_type'];
            $token['expires_at'] = date('Y-m-d H:i:s', $time+$tokens['expires_in']);
            $token['refresh_token'] = $tokens['refresh_token'];
            $token['re_expires_at'] = $tokens['re_expires_in'] ? date('Y-m-d H:i:s', $time+$tokens['re_expires_in']) : null;
            $token['taobao_user_id'] = $tokens['taobao_user_id'];
            $token['taobao_user_nick'] = $tokens['taobao_user_nick'];
            $token['update_time'] = $now;
            $token->save();

            if($cookie){
                $pid = $this->getTaobaoPid($cookie);
                if($pid){
                    $this->savePid($userId, $pid);
                }
            }
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }

        return true;
    }

    /**
     * 保存pid
     * @param $userId
     * @param $pid
     * @return bool
     */
    public function savePid($userId, $pid){
        $time = time();
        $now  = date('Y-m-d H:i:s', $time);

        $token = $this->getToken($userId);
        $this->testPid($token, $pid);

        $model = TaobaoPid::where("user_id", $userId)->first();
        if(!$model){
            $model = new TaobaoPid();
            $model['create_time'] = $now;
            $model['user_id'] = $userId;
        }
        try{
            $model['pid'] = $pid;
            $model['update_time'] = $now;
            $model->save();
        }catch (\Exception $e){
            return false;
        }

        return true;
    }

    /**
     * 获取用户token
     * @param $userId
     * @return mixed
     */
    public function getAuthToken($userId){
        return TaobaoToken::where("user_id", $userId)->first();
    }

    /**
     * 获取token
     * @param $userId
     * @return mixed
     */
    public function getToken($userId){
        $token = $this->getAuthToken($userId);
        if(!$token){
            return null;
        }
        return $token['access_token'];
    }

    /**
     * 获取用户pid
     * @param $userId
     * @return mixed
     */
    public function getPid($userId){
        return TaobaoPid::where("user_id", $userId)->pluck("pid")->first();
    }

    /**
     * 查询用户授权信息
     * @param $userId
     */
    public function authInfo($userId){
        $pid = $this->getPid($userId);
        $token = $this->getAuthToken($userId);

        return [
            'is_auth'=> $token ? true : false,
            'auth_expire_time' => $token['expires_at'],
            'pid' => $pid
        ];
    }

    /**
     * 检测用户pid是否正确
     * @param $token
     * @param $pid
     */
    public function testPid($token, $pid){
        $goodsId = Goods::orderBy("id", 'desc')->pluck("goodsid")->first();
        (new TransferService())->transferLink($goodsId, $pid, $token);
        return true;
    }

    /**
     * 同步阿里妈妈pid
     */
    public function getTaobaoPid($cookie){
        $this->client = new ProxyClient(['cookie'=>true]);

        try{
            //解析cookie字符串为数组
            $cookie = explode(";", $cookie);
            $cookieArray = [];
            foreach ($cookie as $cookieItem){
                $item = explode("=", trim($cookieItem));
                if(in_array($item[0], ['_m_h5_tk_enc', '_m_h5_tk'])){
                    continue;
                }
                $cookieArray[$item[0]] = $item[1];
            }
            $jar = new \GuzzleHttp\Cookie\CookieJar;
            $this->cookieJar = $jar->fromArray($cookieArray, "acs.m.taobao.com");
        }catch (\Exception $e){
            throw new \Exception("cookie格式错误", 300);
        }

        $this->appKey = 12574478;
        $this->version = "1.0";

        //查询用户默认pid
        $defautPidInfo = $this->pidRequest('mtop.alimama.moon.adzone.default.get', '{"tag":"29"}');
        if(strpos($defautPidInfo['ret'][0], "ERROR_NOT_EXISTS_MAMA") !== false){
            throw new \Exception("您可能没有阿里妈妈账户哦", 201);
        }
        if(strpos($defautPidInfo['ret'][0], "FAIL_SYS_SESSION_EXPIRED") !== false){
            throw new \Exception("cookie过期", 201);
        }
        if(!isset($defautPidInfo['data'])){
            throw new \Exception("cookie无效", 300);
        }
        if(!isset($defautPidInfo['data']['pid'])){
            throw new \Exception("您还没有设置默认推广位，请在淘宝联盟设置", 201);
        }
        $pid = $defautPidInfo['data']['pid'];
        if(!$pid){
            //默认网站
            $defaultSite = null;
            try{
                $siteList = $this->pidRequest('mtop.alimama.moon.adzone.site.list', '{"siteGcid":"8"}');
                $siteList = $siteList['data']['result'];
                foreach ($siteList as $site){
                    if(strpos($site['name'], "微信") !== false){
                        $defaultSite = $site['siteid'];
                    }
                }
                if(!$defaultSite){
                    $defaultSite = $siteList[0]['siteid'];
                }
            }catch (\Exception $e){
                throw new \Exception("无可用推广位", 201);
            }

            try{
                $adzoneList = $this->pidRequest('mtop.alimama.moon.adzone.list', '{"gcid":"8","siteId":"'.$defaultSite.'","tag":"29","page":"1","pageSize":"20"}');
                $adzone = $adzoneList['data']['result'][0];
            }catch (\Exception $e){
                throw new \Exception("无可用推广位", 201);
            }

            $pid = "mm_123_".$adzone['siteId']."_".$adzone['adzoneId'];
        }

        return $pid;
    }

    public function pidRequest($api, $data, $extraData = null){
        $appKey = $this->appKey;
        $v		= $this->version;
        $h5Tk   = $this->h5Tk;
        $t		= time()."000";
        $cookieUrl	= 'https://acs.m.taobao.com/h5/'.$api.'/1.0/?type=json&api='.$api.'&v='.$v;

        //拼接实际请求地址
        $sign	= md5($h5Tk.'&'.$t.'&'.$appKey.'&'.$data);
        $url	= $cookieUrl.'&appKey='.$appKey.'&sign='.$sign.'&t='.$t.'&data='.$data;
        if($extraData){
            $url .= "&".http_build_query($extraData);
        }

        //第一次取cookie参数
        $response = $this->client->request('GET', $url, ['cookies' => $this->cookieJar])->getBody()->getContents();

        if(strpos($response, "令牌为空")){
            $h5TkCookie = $this->cookieJar->getCookieByName('_m_h5_tk')->getValue();
            $this->h5Tk = explode('_', $h5TkCookie)[0];
            return $this->pidRequest($api, $data, $extraData);
        }

        return json_decode($response, true);
    }

    /**
     * 查询淘宝优惠券信息
     * @param $goodsId
     * @param $couponId
     */
    public function getTaobaoCoupon($goodsId, $couponId=""){
        if($cache = CacheHelper::getCache()){
            return $cache;
        }

        $this->client = new ProxyClient(['cookie'=>true]);
        if($couponId && $couponId != '1'){
            //需要传递的参数
            $apiParamData = [
                'itemId'=>$goodsId,
                'activityId' => $couponId
            ];
            $this->cookieJar = new \GuzzleHttp\Cookie\CookieJar;
            $result = $this->pidRequest('mtop.alimama.union.hsf.coupon.get', json_encode($apiParamData));
            try{
                $status = $result['data']['result']['retStatus'];
            }catch (\Exception $e){
                Log::error(__METHOD__."  系统错误".var_export($result, true));
                throw new \Exception("系统错误", 500);
            }

            try{
                if($status != 0){
                    throw new \Exception("券已失效", 300);
                }

                $couponPrice = $result['data']['result']['amount'];
                $couponTime = $result['data']['result']['effectiveEndTime'];
                $couponPrerequisite = $result['data']['result']['startFee'];
                $couponNum = 0;
                $couponOver = 0;
            }catch (\Exception $e){
                if($e->getCode() != 300){
                    Log::error(__METHOD__."  ".$e->getMessage().var_export($result, true));
                }
                throw new \Exception("券已失效");
            }
        }else{
            $url = "http://pub.alimama.com/items/search.json?q=".urlencode("https://item.taobao.com/item.htm?id=".$goodsId)."&auctionTag=&perPageSize=40&shopTag=";
            $mamaDetail = $this->client->get($url)->getBody()->getContents();
            if(!$mamaDetail){
                throw new \Exception("系统错误", 500);
            }

            if($mamaDetail){
                $mamaDetail = json_decode($mamaDetail, true);
                $mamaDetail = $mamaDetail['data']['pageList'][0];
                if(!$mamaDetail['couponAmount']){
                    throw new \Exception("券已失效");
                }
                $couponTime = $mamaDetail['couponEffectiveEndTime']." 23:59:59";
                $couponPrice = $mamaDetail['couponAmount'];
                $couponPrerequisite = $mamaDetail['couponStartFee'];
                $couponNum = $mamaDetail['couponTotalCount'];
                $couponOver = $mamaDetail['couponLeftCount'];
                $couponId = $mamaDetail['couponActivityId'];
            }
        }

        $data = [
            'coupon_id' => $couponId,
            'coupon_time' => $couponTime,
            'coupon_price' => $couponPrice,
            'coupon_prerequisite' => $couponPrerequisite,
            'coupon_num' => $couponNum,
            'coupon_over' => $couponOver,
        ];

        CacheHelper::setCache($data, 1);
        return $data;
    }
}
