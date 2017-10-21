<?php
/**
 * Created by PhpStorm.
 * User: yangtao
 * Date: 2017/10/18
 * Time: 16:26
 */
namespace App\Helpers;


class GoodsHelper
{
    /**
     * 生成淘宝链接
     * @param $taobaoGoodsId
     * @param $isTmall
     */
    public function generateTaobaoUrl($taobaoGoodsId, $isTmall){
        $taobaoUrl = 'https://item.taobao.com/item.htm?id=%s';
        $tmallUrl = 'https://detail.tmall.com/item.htm?id=%s';
        $url = $isTmall ? $tmallUrl : $taobaoUrl;

        return sprintf($url, $taobaoGoodsId);
    }
}