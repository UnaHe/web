<?php

namespace App\Http\Controllers;

use App\Services\CaptchaService;
use App\Services\UserService;
use App\Services\WechatPageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WechatPageController extends Controller
{
    public function page($id, Request $request){
        $wechatPage = (new WechatPageService())->getPage($id);
        if(!$wechatPage){
            throw  new NotFoundHttpException();
        }

        $data = [
            'pageInfo' => $wechatPage,
        ];
        return view('wechat_page', $data);
    }
}
