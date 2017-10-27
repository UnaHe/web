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
        $apiUrl = "http://api.t.sina.com.cn/short_url/shorten.json?source=3271760578&url_long=".$url;
        $client = new Client();
        $response = $client->get($apiUrl)->getBody()->getContents();
        if(!$response){
            return null;
        }
        $response = json_decode($response, true);
        if(!isset($response[0]['url_short'])){
            return null;
        }
        return $response[0]['url_short'];
    }
}