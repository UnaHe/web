<?php

namespace App\Http\Controllers;
use App\Services\BannerService;
use Illuminate\Http\Request;
use App\Services\TaobaoService;

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
    public function getBanner(Request $request, $position){
        $data = (new BannerService())->getBanner($position);
        foreach ($data as $k=>$v) {
            if (!empty($v['click_url'])) {
                $userId = $request->user()->id;
                $pid = (new TaobaoService())->getPid($userId);
                $data[$k]['click_url'] = str_replace('@userId@', $userId, $data[$k]['click_url']);
                $data[$k]['click_url'] = str_replace('@pid@', $pid, $data[$k]['click_url']);
            }
        }
        return $this->ajaxSuccess($data);
    }

}
