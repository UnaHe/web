<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use App\Helpers\UrlHelper;
use App\Models\shareTitle;

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
}
