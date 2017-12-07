<?php
/**
 * Created by PhpStorm.
 * User: yangtao
 * Date: 2017/10/27
 * Time: 13:00
 */
namespace App\Helpers;

use GuzzleHttp\Client;

class UrlHelper
{
    /**
     * 网站缩短
     * @param $url
     * @return null
     */
    public function shortUrl($url){
        $appId = config('services.sina_open.key');
        $apiUrl = "http://api.weibo.com/2/short_url/shorten.json?source=5786724301&url_long=".$url;
        $client = new Client(['timeout' => 3]);
        try{
//            throw new \Exception('暂停使用新浪');
            $response = $client->get($apiUrl)->getBody()->getContents();
            if(!$response){
                throw new \Exception('短网址转换失败');
            }
            $response = json_decode($response, true);
            $code = parse_url($response['urls'][0]['url_short']);
            $path = trim($code['path'], '/');
            if(!isset($response['urls'][0]['url_short'])){
                return null;
            }
            if (!(strlen($path) > 1 && strlen($path) <= 8)){
                $this ->shortUrl($url);
            }
            return $response['urls'][0]['url_short'];
        }catch (\Exception $e){
            $apiUrl = "http://6du.in/?is_api=1&lurl=".$url;
            $response = $client->get($apiUrl)->getBody()->getContents();
            if(!strpos("http", $response) === 0){
                throw new \Exception('短网址转换失败');
            }
            return $response;
        }
    }
}