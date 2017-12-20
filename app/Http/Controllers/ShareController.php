<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\UrlHelper;

class ShareController extends Controller
{
    //
    public function getShare(Request $request)
    {
        // 获取当前用户邀请码.
        $code = $request->user()->invite_code;

        // 拼接邀请链接.
        $data = parse_url($request->url())['host'];
        $longUrl = 'http://'.$data.'/pytao/share/'.$code;

        // 短链接.
        $shortUrl = (new UrlHelper())->shortUrl($longUrl);

        // 响应邀请链接.
        $url = [
            'longUrl' => $longUrl,
            'shortUrl' => $shortUrl
        ];

        return $this->ajaxSuccess($url);
    }
}
