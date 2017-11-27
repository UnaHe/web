<?php

namespace App\Http\Controllers;

use App\Helpers\UtilsHelper;
use App\Models\WechatDomain;
use App\Services\WechatPageService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WechatPageController extends Controller
{
    /**
     * 微信单页
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function page(Request $request, $id){
        $code = $request->get('c');
        if(!cache("redirect_limit_code.".$code)){
            return $this->redirect($id);
        }

        $wechatPage = (new WechatPageService())->getPage($id);
        if(!$wechatPage){
            throw  new NotFoundHttpException();
        }

        $data = [
            'pageInfo' => $wechatPage,
        ];

        $pageContent = view('wechat_page', $data);

        return view('wechat_page_wrap', ['content' => base64_encode($pageContent)]);
    }

    /**
     * 中转域名跳转
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function redirect($id){
        $wechatPage = (new WechatPageService())->getPage($id);
        if(!$wechatPage){
            throw  new NotFoundHttpException();
        }

        preg_match('/([0-9A-Za-z]+)/', $wechatPage['tao_code'], $matchs);
        $taoCode = $matchs[1];
        $pic = urlencode($wechatPage['pic']);

        $url = "https://pty02.kuaizhan.com/?code={$taoCode}&pic=$pic";
        return redirect($url);


        $redirectDomain = config('domains.redirect_domain');
        $domains = WechatDomain::get();
        if($domains){
            $domains = $domains->pluck("domain")->toArray();
        }
        if($domains && !in_array($redirectDomain, $domains)){
            $domain = array_random($domains);
            $url = URL::action('WechatPageController@page', ['id' => $id], false);
            $domain = str_replace("*", UtilsHelper::randStr(5), $domain);
            $code = microtime(true).".".uniqid();
            cache(["redirect_limit_code.".$code => 1], (new Carbon())->addSecond(3));
            $redirectUrl = $domain.$url."?c=".$code;
            return redirect($redirectUrl);
        }else{
            return $this->page($id);
        }
    }
}
