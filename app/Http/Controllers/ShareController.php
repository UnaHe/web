<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use App\Helpers\UrlHelper;
use App\Models\shareTitle;
use App\Services\TransferService;

/**
 * 分享链接
 * Class ShareController
 * @package App\Http\Controllers
 */
class ShareController extends Controller
{
    /**
     * 朋友淘分享链接
     * @param Request $request
     * @return static
     * @throws \Exception
     */
    public function getShare(Request $request)
    {
        $appName = $request->input('from');

        // 分享标题.
        $title = shareTitle::where('app_name', $appName)->pluck('title')->first();

        // 获取当前用户推荐码.
        $code = (new UserService())->getReferralCode($request->user());

        // 拼接邀请链接.
        $longUrl = 'http://'.config('domains.pytao_domains').'/?u='.$code.'&t='.time().'&title='.$title;

        // 短链接.
        $shortUrl = (new UrlHelper())->shortUrl($longUrl);

        // 响应邀请链接.
        $url = [
            'longUrl' => $longUrl,
            'shortUrl' => $shortUrl
        ];

        return $this->ajaxSuccess($url);
    }

    /**
     * 获取推荐码
     */
    public function getReferralCode(Request $request){
        $code = (new UserService())->getReferralCode($request->user());
        if(!$code){
            return $this->ajaxError("推荐码未设置");
        }
        return $this->ajaxSuccess([
            'referral_code' => $code
        ]);
    }

    /**
     * 获取活动生成
     * @throws \Exception
     */
    public function getActivity(Request $request) {
        $pid = $request->input('pid');

        // 活动链接.
        $activityUrl = 'https://mos.m.taobao.com/activity_newer?from=tool&sight=pytk&pid=@pid@';

        // 拼接PID.
        $url = str_replace('@pid@', $pid, $activityUrl);

        // 短链接.
        $shortUrl = (new UrlHelper())->shortUrl($url);

        // 淘口令.
        $taoCode = (new TransferService())->transferTaoCode('拉新人拿高佣', $url);

        $data = [
            'longUrl' => $url,
            'shortUrl' => $shortUrl,
            'taoCode' => $taoCode
        ];

        return $this->ajaxSuccess($data);
    }

}
