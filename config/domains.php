<?php
/**
 * 域名配置
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/26
 * Time: 15:02
 */

//去除前后可能出现的逗号
$domainConfig = trim(env('WECHAT_DOMAINS'), ',');
$domains = explode(',', $domainConfig);

return [
    /**
     * api域名
     */
    'api_domain' => env('API_DOMAIN'),
    /**
     * 重定向域名
     */
    'redirect_domain' => env('REDIRECT_DOMAIN'),
    /**
     * 微信单页域名列表
     */
    'wechat_domains' => $domains,
    /**
     * 朋友淘域名
     */
    'pytao_domains' => env('PYTAO_DOMAINS'),

];