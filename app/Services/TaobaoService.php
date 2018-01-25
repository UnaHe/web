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
use App\Services\Requests\CouponGet;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\DB;
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
    public function saveAuthToken($userId, $tokens, $cookie)
    {
        $time = time();
        $now = date('Y-m-d H:i:s', $time);

        $token = TaobaoToken::where("user_id", $userId)->first();
        if (!$token) {
            $token = new TaobaoToken();
            $token['create_time'] = $now;
            $token['user_id'] = $userId;
        }
        try {
            $token['access_token'] = $tokens['access_token'];
            $token['token_type'] = $tokens['token_type'];
            $token['expires_at'] = date('Y-m-d H:i:s', $time + $tokens['expires_in']);
            $token['refresh_token'] = $tokens['refresh_token'];
            $token['re_expires_at'] = $tokens['re_expires_in'] ? date('Y-m-d H:i:s', $time + $tokens['re_expires_in']) : null;
            $token['taobao_user_id'] = $tokens['taobao_user_id'];
            $token['taobao_user_nick'] = $tokens['taobao_user_nick'];
            $token['update_time'] = $now;
            $token->save();

            if ($cookie) {
                $pid = $this->getTaobaoPid($cookie);
                if ($pid) {
                    $this->savePid($userId, $pid);
                }
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }

        return true;
    }


    /**
     * 刷新token
     * @param $userId
     * @return bool
     */
    public function refreshUserToken($userId)
    {
        $token = TaobaoToken::where("user_id", $userId)->first();
        if (!$token) {
            return false;
        }

        try {
            $url = 'https://oauth.taobao.com/token';
            $client = new Client();
            $response = $client->post($url, [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'client_id' => config('taobao.appkey'),
                    'client_secret' => config('taobao.secretkey'),
                    'refresh_token' => $token['refresh_token']
                ]
            ])->getBody()->getContents();

            $token = json_decode($response, true);
            return $this->saveAuthToken($userId, $token, null);
        } catch (\Exception $e) {
        }

        return false;
    }


    /**
     * 保存pid
     * @param $userId
     * @param $pid
     * @return bool
     */
    public function savePid($userId, $pid)
    {
        $time = time();
        $now = date('Y-m-d H:i:s', $time);

        $token = $this->getToken($userId);
        $this->testPid($token, $pid);

        $model = TaobaoPid::where("user_id", $userId)->first();
        if (!$model) {
            $model = new TaobaoPid();
            $model['create_time'] = $now;
            $model['user_id'] = $userId;
        }
        try {
            $model['pid'] = $pid;
            $model['update_time'] = $now;
            $model->save();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * 获取用户token
     * @param $userId
     * @return mixed
     */
    public function getAuthToken($userId)
    {
        return TaobaoToken::where("user_id", $userId)->first();
    }

    /**
     * 获取token
     * @param $userId
     * @return mixed
     */
    public function getToken($userId)
    {
        $token = $this->getAuthToken($userId);
        if (!$token) {
            return null;
        }
        return $token['access_token'];
    }

    /**
     * 获取用户pid
     * @param $userId
     * @return mixed
     */
    public function getPid($userId)
    {
        return TaobaoPid::where("user_id", $userId)->pluck("pid")->first();
    }

    /**
     * 查询用户授权信息
     * @param $userId
     */
    public function authInfo($userId)
    {
        $pid = $this->getPid($userId);
        $token = $this->getAuthToken($userId);

        return [
            'is_auth' => $token ? true : false,
            'auth_expire_time' => $token['expires_at'],
            'pid' => $pid
        ];
    }

    /**
     * 检测用户pid是否正确
     * @param $token
     * @param $pid
     */
    public function testPid($token, $pid)
    {
        $goodsId = Goods::orderBy("id", 'desc')->pluck("goodsid")->first();
        (new TransferService())->transferLink($goodsId, $pid, $token);
        return true;
    }

    /**
     * 同步阿里妈妈pid
     */
    public function getTaobaoPid($cookie)
    {
        $this->client = new ProxyClient(['cookie' => true]);

        try {
            //解析cookie字符串为数组
            $cookie = explode(";", $cookie);
            $cookieArray = [];
            foreach ($cookie as $cookieItem) {
                $item = explode("=", trim($cookieItem));
                if (in_array($item[0], ['_m_h5_tk_enc', '_m_h5_tk'])) {
                    continue;
                }
                $cookieArray[$item[0]] = $item[1];
            }
            $jar = new \GuzzleHttp\Cookie\CookieJar;
            $this->cookieJar = $jar->fromArray($cookieArray, "acs.m.taobao.com");
        } catch (\Exception $e) {
            throw new \Exception("cookie格式错误", 300);
        }

        $this->appKey = 12574478;
        $this->version = "1.0";

        //查询用户默认pid
        $defautPidInfo = $this->pidRequest('mtop.alimama.moon.adzone.default.get', '{"tag":"29"}');
        if (strpos($defautPidInfo['ret'][0], "ERROR_NOT_EXISTS_MAMA") !== false) {
            throw new \Exception("您可能没有阿里妈妈账户哦", 201);
        }
        if (strpos($defautPidInfo['ret'][0], "FAIL_SYS_SESSION_EXPIRED") !== false) {
            throw new \Exception("cookie过期", 201);
        }
        if (!isset($defautPidInfo['data'])) {
            throw new \Exception("cookie无效", 300);
        }
        if (!isset($defautPidInfo['data']['pid'])) {
            throw new \Exception("您还没有设置默认推广位，请在淘宝联盟设置", 201);
        }
        $pid = $defautPidInfo['data']['pid'];
        if (!$pid) {
            //默认网站
            $defaultSite = null;
            try {
                $siteList = $this->pidRequest('mtop.alimama.moon.adzone.site.list', '{"siteGcid":"8"}');
                $siteList = $siteList['data']['result'];
                foreach ($siteList as $site) {
                    if (strpos($site['name'], "微信") !== false) {
                        $defaultSite = $site['siteid'];
                    }
                }
                if (!$defaultSite) {
                    $defaultSite = $siteList[0]['siteid'];
                }
            } catch (\Exception $e) {
                throw new \Exception("无可用推广位", 201);
            }

            try {
                $adzoneList = $this->pidRequest('mtop.alimama.moon.adzone.list', '{"gcid":"8","siteId":"' . $defaultSite . '","tag":"29","page":"1","pageSize":"20"}');
                $adzone = $adzoneList['data']['result'][0];
            } catch (\Exception $e) {
                throw new \Exception("无可用推广位", 201);
            }

            $pid = "mm_123_" . $adzone['siteId'] . "_" . $adzone['adzoneId'];
        }

        return $pid;
    }

    public function pidRequest($api, $data, $extraData = null)
    {
        $appKey = $this->appKey;
        $v = $this->version;
        $h5Tk = $this->h5Tk;
        $t = time() . "000";
        $cookieUrl = 'https://acs.m.taobao.com/h5/' . $api . '/1.0/?type=json&api=' . $api . '&v=' . $v;

        //拼接实际请求地址
        $sign = md5($h5Tk . '&' . $t . '&' . $appKey . '&' . $data);
        $url = $cookieUrl . '&appKey=' . $appKey . '&sign=' . $sign . '&t=' . $t . '&data=' . $data;
        if ($extraData) {
            $url .= "&" . http_build_query($extraData);
        }

        //第一次取cookie参数
        $response = $this->client->request('GET', $url, ['cookies' => $this->cookieJar])->getBody()->getContents();

        if (strpos($response, "令牌为空")) {
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
    public function getTaobaoCoupon($goodsId, $couponId = "")
    {
        if ($cache = CacheHelper::getCache()) {
            return $cache;
        }

        if ($couponId && $couponId != '1') {
            $result = (new CouponGet())->initWithItemInfo($goodsId, $couponId);
            try {
                $status = $result->getStatus();
            } catch (\Exception $e) {
                Log::error(__METHOD__ . "  系统错误" . var_export($result, true));
                throw new \Exception("系统错误", 500);
            }

            try {
                if ($status != 0) {
                    throw new \Exception("券已失效", 300);
                }

                $couponPrice = $result->getCouponPrice();
                $couponStartTime = $result->getCouponStartTime();
                $couponTime = $result->getCouponEndTime();
                $couponPrerequisite = $result->getCouponPrerequisite();
                $couponNum = 0;
                $couponOver = 0;
            } catch (\Exception $e) {
                if ($e->getCode() != 300) {
                    Log::error(__METHOD__ . "  " . $e->getMessage() . var_export($result, true));
                }
                throw new \Exception("券已失效");
            }
        } else {
            $mamaDetail = (new AlimamaGoodsService())->detail($goodsId);
            if (!$mamaDetail) {
                throw new \Exception("系统错误", 500);
            }

            if ($mamaDetail) {
                if (!$mamaDetail['couponAmount']) {
                    throw new \Exception("券已失效");
                }

                $couponStartTime = $mamaDetail['couponEffectiveStartTime'] . " 00:00:00";
                $couponTime = $mamaDetail['couponEffectiveEndTime'] . " 23:59:59";

                $couponPrice = $mamaDetail['couponAmount'];
                $couponPrerequisite = $mamaDetail['couponStartFee'];
                $couponNum = $mamaDetail['couponTotalCount'];
                $couponOver = $mamaDetail['couponLeftCount'];
            }
        }

        $data = [
            'coupon_id' => $couponId,
            'coupon_start_time' => $couponStartTime,
            'coupon_time' => $couponTime,
            'coupon_price' => $couponPrice,
            'coupon_prerequisite' => $couponPrerequisite,
            'coupon_num' => $couponNum,
            'coupon_over' => $couponOver,
        ];

        CacheHelper::setCache($data, 1);
        return $data;
    }

    /**
     * 授权管理信息
     * @param $userId
     * @return array
     */
    public function accountAuthInfo($userId)
    {
        $token = $this->getAuthToken($userId);
        if (!$token) {
            return [];
        }
        $pids = $this->getPids($userId);

        $auth_expire_time = 0;

        $time = (strtotime($token->expires_at) - time()) > 60 ? (strtotime($token->expires_at) - time()) : 0;
        $auth_expire_time = '';
        if ($time > 0) {
            $day = floor($time / 86400);
            if ($day) {
                $auth_expire_time .= $day . '天';
            }
            $time = $time % 86400;
            $hour = floor(($time) / 3600);
            if ($hour) {
                $auth_expire_time .= $hour . '小时';
            }
            $time = $time % 3600;
            $minute = floor($time / 60);
            if ($hour) {
                $auth_expire_time .= $minute . '分';
            }

        }
        $taobao_user_nick = $token->taobao_user_nick;


        $tmp_arr = ['weixin' => '', 'qq' => ''];
        foreach ($pids as $p) {
            if ($p['pid_type'] == 1) {
                $tmp_arr['weixin'] = $p['pid'];
            } else {
                $tmp_arr['qq'] = $p['pid'];
            }
        }
        $data = [
            'taobao_user_nick' => $taobao_user_nick,
            'auth_expire_time' => $auth_expire_time,
            'pids' => $tmp_arr,
        ];
        return $data;
    }

    /**
     * 获取用户的pid和pid的类型
     * @param $userId
     * @return mixed
     */
    public function getPids($userId)
    {
        return TaobaoPid::where("user_id", $userId)->select('pid', 'pid_type')->get();
    }

    /**
     * 新增或者修改用户的pid信息
     * @param $userId
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public function updateAuth($userId, $data)
    {
        try {
            DB::beginTransaction();
            $token = $this->getToken($userId);
            $time = date('Y-m-d H:i:m', time());

            //插入微信渠道PID
            if ($data['weixin_pid']) {
                $this->testPid($token, $data['weixin_pid']);
                $weixin_pid = TaobaoPid::where(['user_id' => $userId, 'pid_type' => 1])->first();
                if (!$weixin_pid) {
                    $weixin_pid = new TaobaoPid();
                    $weixin_pid['create_time'] = $time;
                    $weixin_pid['user_id'] = $userId;
                    $weixin_pid['pid_type'] = 1;
                }
                $weixin_pid['pid'] = $data['weixin_pid'];
                $weixin_pid['update_time'] = $time;
                $weixin_pid->save();
            }else{
                TaobaoPid::where(['user_id' => $userId, 'pid_type' => 1])->delete();
            }

            //插入QQ渠道PID
            if ($data['qq_pid']) {
                $this->testPid($token, $data['qq_pid']);
                $qq_pid = TaobaoPid::where(['user_id' => $userId, 'pid_type' => 2])->first();
                if (!$qq_pid) {
                    $qq_pid = new TaobaoPid();
                    $qq_pid['create_time'] = $time;
                    $qq_pid['user_id'] = $userId;
                    $qq_pid['pid_type'] = 2;
                }
                $qq_pid['pid'] = $data['qq_pid'];
                $qq_pid['update_time'] = $time;
                $qq_pid->save();
            }else{
                 TaobaoPid::where(['user_id' => $userId, 'pid_type' => 2])->delete();
            }

            DB::commit();
            return ['success' => true];
        } catch (\Exception  $e) {
            DB::rollback();
            $error = $e->getMessage();
            return ['success' => false, 'msg' => $error];
        }
    }

    /**
     * 用户删除授权
     * @param $userId
     * @return mixed
     */
    public function delAuth($userId)
    {
        DB::beginTransaction();
        try {
            TaobaoToken::where("user_id", $userId)->delete();
            TaobaoPid::where(['user_id' => $userId])->delete();
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
        DB::commit();
        return true;
    }
}
