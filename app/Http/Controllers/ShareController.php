<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShareController extends Controller
{
    //
    public function getShare(Request $request)
    {
        // 获取当前用户邀请码.
        $code = $request->user()->invite_code;

        // 返回邀请链接.
        $data = parse_url($request->url())['host'];
        $url = 'http://'.$data.'/pytao/share/'.$code;

        return $this->ajaxSuccess($url);
    }
}
