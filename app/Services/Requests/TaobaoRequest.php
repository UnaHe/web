<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/27
 * Time: 10:45
 */

namespace App\Services\Requests;


use App\Helpers\ProxyClient;
use GuzzleHttp\Cookie\CookieJar;

class TaobaoRequest{

    protected $appKey = 12574478;
    protected $version = "1.0";
    protected $h5Tk;
    protected $client;
    protected $cookieJar;

    public function __construct(){
        $this->client = new ProxyClient(['cookie'=>true]);
        $this->cookieJar = new CookieJar;
    }

    /**
     * 淘宝接口请求
     * @param $api
     * @param $data
     * @param null $extraData
     * @return mixed
     */
    public function requestWithH5tk($api, $data, $extraData = null){
        if(is_array($data)){
            $data = json_encode($data);
        }

        $t		= intval(microtime(true)*1000);
        $cookieUrl	= 'https://acs.m.taobao.com/h5/'.$api.'/1.0/?type=json&api='.$api.'&v='.$this->version;

        //拼接实际请求地址
        $sign	= md5($this->h5Tk.'&'.$t.'&'.$this->appKey.'&'.$data);
        $url	= $cookieUrl.'&appKey='.$this->appKey.'&sign='.$sign.'&t='.$t.'&data='.urlencode($data);
        if($extraData){
            $url .= "&".http_build_query($extraData);
        }

        //第一次取cookie参数
        $response = $this->client->request('GET', $url, ['cookies' => $this->cookieJar])->getBody()->getContents();

        if(strpos($response, "令牌为空")){
            $h5TkCookie = $this->cookieJar->getCookieByName('_m_h5_tk')->getValue();
            $this->h5Tk = explode('_', $h5TkCookie)[0];
            return $this->requestWithH5tk($api, $data, $extraData);
        }

        return json_decode($response, true)['data'];
    }

}