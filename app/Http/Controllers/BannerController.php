<?php

namespace App\Http\Controllers;
use App\Services\BannerService;

/**
 * banner广告
 * Class BannerController
 * @package App\Http\Controllers
 */
class BannerController extends Controller
{
    /**
     * 获取指定位置广告
     */
    public function getBanner($position){
        $data = (new BannerService())->getBanner($position);
        return $this->ajaxSuccess($data);
    }

}
