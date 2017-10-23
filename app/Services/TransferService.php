<?php
/**
 * Created by PhpStorm.
 * User: yangtao
 * Date: 2017/10/18
 * Time: 15:51
 */
namespace App\Services;

use App\Helpers\ErrorHelper;
use App\Helpers\GoodsHelper;
use App\Models\Banner;
use App\Models\GoodsCategory;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class TransferService
{
    private $topClient;

    public function __construct(){
        include_once app_path("Librarys/Taobao/TopSdk.php");
        $this->topClient = new \TopClient(env('TAOBAO_OPEN_APPKEY'), env('TAOBAO_OPEN_SECRETKEY'));
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
        if(isset($resp['sub_code'])){
            if ('invalid-sessionkey' == $resp['sub_code']){
                //session过期
                throw new \Exception("授权过期", ErrorHelper::ERROR_TAOBAO_INVALID_SESSION);
            }else if ('isv.item-not-exist' == $resp['sub_code']){
                //商品错误
                throw new \Exception("宝贝已下架或非淘客宝贝", ErrorHelper::ERROR_TAOBAO_INVALID_GOODS);
            }else if ('isv.pid-not-correct' == $resp['sub_code']){
                //pid错误
                throw new \Exception("PID错误", ErrorHelper::ERROR_TAOBAO_INVALID_PID);
            }
            throw new \Exception("转链失败");
        }

        return $resp['result']['data'];
    }

    /**
     * 淘宝短链接sclick转换
     * @param $url 原始url
     * @return mixed
     */
    public function transferSclick($url){
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

        return $data;
    }

    /**
     * 转淘口令
     * @param $title
     * @param $url
     * @return mixed
     */
    public function transferTaoCode($title, $url){
        try{
            $req = new \TbkTpwdCreateRequest;
            $req->setUserId("1");
            $req->setText($title);
            $req->setUrl($url);
            $req->setLogo("");
            $req->setExt("{}");
            $resp = $this->topClient->execute($req);
            $result = (array)$resp;
            $data = $result['data']['model'];
        }catch (\Exception $e){
            throw new \Exception('淘口令转换失败');
        }

        return $data;
    }

    /**
     * 商品转链
     */
    public function transferGoodsByUser($goodsId, $title, $userId){
        try{
            $token = (new TaobaoService())->getToken($userId);
            $pid = (new TaobaoService())->getPid($userId);
            $data = $this->transferGoods($goodsId, $title, $pid, $token);
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }

        return $data;
    }

    /**
     * 商品转链
     */
    public function transferGoods($goodsId, $title, $pid, $token){
        try{
            $result = $this->transferLink($goodsId,$pid,$token);
            $url = $result['coupon_click_url'];
            $slickUrl = $this->transferSclick($url);
            $taoCode = $this->transferTaoCode($title, $slickUrl);
            $data = [
                'goods_id' => $goodsId,
                'url' => $url,
                's_url' => $slickUrl,
                'tao_code' => $taoCode
            ];
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }

        return $data;
    }


    /**
     * 解析淘口令
     * @param $taoCode
     * @return mixed
     */
    public function queryTaoCode($taoCode){
        $client = new Client(['cookie'=>true]);
        $jar = new \GuzzleHttp\Cookie\CookieJar;

        $data	= '{"password":"'.$taoCode.'"}';
        $api	= 'com.taobao.redbull.getpassworddetail';
        $appKey = '21646297';
        $v		= '1.0';
        $t		= '0';
        $cookieUrl	= 'http://api.m.taobao.com/rest/h5ApiUpdate.do?callback=jsonp11&timeout=10050&type=&api='.$api.'&v='.$v;

        //第一次取cookie参数
        $client->request('GET', $cookieUrl, ['cookies' => $jar]);
        $h5TkCookie = $jar->getCookieByName('_m_h5_tk')->getValue();
        $h5Tk = explode('_', $h5TkCookie)[0];

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

        //不是二合一页面则打开页面并跟踪跳转到二合一界面
        if(!strpos($lastUrl, 'uland.taobao.com')){
            $client = new Client();
            //打开url并跟踪跳转
            $response = $client->request('GET', $lastUrl, [
                'verify' => false,
                RequestOptions::ALLOW_REDIRECTS => [
                    'max'             => 10,        // allow at most 10 redirects.
                    'strict'          => true,      // use "strict" RFC compliant redirects.
                    'referer'         => true,      // add a Referer header
                    'track_redirects' => true,
                ],
            ]);

            //获取最终跳转地址
            $redirectUriHistory = $response->getHeader('X-Guzzle-Redirect-History'); // retrieve Redirect URI history
            $lastUrl = array_pop($redirectUriHistory);
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

        if(!preg_match('/mtopjsonp1\((.*?)\)/', $response, $matchs)){
            return false;
        }

        $result = json_decode($matchs[1], true);

        $itemId = $result['data']['result']['item']['itemId'];
        $isTmall = $result['data']['result']['item']['tmall'];
        $data = [
            'url' => $taoCodeData['url'],
            'goods_url' => (new GoodsHelper())->generateTaobaoUrl($itemId, $isTmall),
            'short_title' => $taoCodeData['content'],
            'sell_num' => $result['data']['result']['item']['biz30Day'],
            'goodsid' => $itemId,
            'pic' => $result['data']['result']['item']['picUrl'],
            'title' => $result['data']['result']['item']['title'],
            'price_full' => $result['data']['result']['item']['discountPrice'],
            'coupon_start_time' => $result['data']['result']['effectiveStartTime'],
            'coupon_end_time' => $result['data']['result']['effectiveEndTime'],
            'coupon_price' => $result['data']['result']['amount'],
            'coupon_prerequisite' => $result['data']['result']['startFee'],
            'seller_name' => $result['data']['result']['shopName'],
            'seller_icon_url' => $result['data']['result']['shopLogo'],
            'is_tmall' => $isTmall,
        ];

        return $data;

    }
}
