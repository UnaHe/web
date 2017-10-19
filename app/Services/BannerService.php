<?php
/**
 * Created by PhpStorm.
 * User: yangtao
 * Date: 2017/10/18
 * Time: 15:51
 */
namespace App\Services;

use App\Models\Banner;
use App\Models\GoodsCategory;

class BannerService
{
    /**
     * 获取指定位置广告
     * @return mixed
     */
    public function getBanner($position){
        return Banner::select('name', 'pic', 'click_url')->where('position', $position)->get();
    }
}
