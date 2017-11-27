<?php

namespace App\Http\Controllers;

use App\Helpers\UtilsHelper;
use App\Models\SysConfig;
use App\Models\WechatDomain;
use App\Services\SysConfigService;
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
    public function page(Request $request, $id, $checkCode=true){
        //检查跳转限制
        if($checkCode){
            $code = $request->get('c');
            if(!cache("redirect_limit_code.".$code)){
                return $this->redirect($id, $request);
            }
        }

        $wechatPage = (new WechatPageService())->getPage($id);
        if(!$wechatPage){
            throw  new NotFoundHttpException();
        }

        $data = [
            'pageInfo' => $wechatPage,
        ];

        $pageContent = view('wechat_page', $data);
        if(!$checkCode){
            return $pageContent;
        }

        return view('wechat_page_wrap', ['content' => base64_encode($pageContent)]);
    }

    /**
     * 不检查验证方式
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function page2(Request $request, $id){
        return $this->page($request, $id, false);
    }

    /**
     * 中转域名跳转
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function redirect($id, Request $request){
        $wechatShowType = $request->get('wechat_show_type');
        if(!$wechatShowType){
            $wechatShowType = SysConfig::where('key', 'wechat_show_type')->pluck("value")->first();
        }

        switch ($wechatShowType){
            //域名方式
            case 1:{
                return $this->typePage($id);
                break;
            }
            //快站方式
            case 2:{
                return $this->typeKuaizhan($id);
                break;
            }
            //百度翻译方式
            case 3:{
                return $this->typeFanyi($id);
                break;
            }
        }

    }

    /**
     * 域名方式
     * @param $id
     */
    public function typePage($id, $encode=1){
        $redirectDomain = config('domains.redirect_domain');
        $domains = WechatDomain::where("type", 1)->get();
        if($domains){
            $domains = $domains->pluck("domain")->toArray();
        }
        if($domains && !in_array($redirectDomain, $domains)){
            $domain = array_random($domains);
            if($encode){
                $url = URL::action('WechatPageController@page', ['id' => $id], false);
            }else{
                $url = URL::action('WechatPageController@page2', ['id' => $id], false);
            }
            $domain = str_replace("*", UtilsHelper::randStr(5), $domain);
            $code = microtime(true).".".uniqid();
            cache(["redirect_limit_code.".$code => 1], (new Carbon())->addSecond(5));
            $redirectUrl = $domain.$url."?c=".$code;
            return redirect($redirectUrl);
        }else{
            return $this->page($id, $encode);
        }
    }

    /**
     * 快站方式
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function typeKuaizhan($id){
        $wechatPage = (new WechatPageService())->getPage($id);
        if(!$wechatPage){
            throw  new NotFoundHttpException();
        }

        preg_match('/([0-9A-Za-z]+)/', $wechatPage['tao_code'], $matchs);
        $taoCode = $matchs[1];
        $pic = urlencode($wechatPage['pic']);

        $domains = WechatDomain::where("type", 2)->get();
        $domains = $domains->pluck("domain")->toArray();
        $domain = array_random($domains);

        $url = $domain."/?code={$taoCode}&pic=$pic";
        return redirect($url);
    }


    /**
     * 百度翻译方式
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function typeFanyi($id){
        $redirectUrl = urlencode($this->typePage($id, 0)->getTargetUrl());
        $url = "http://fanyi.baidu.com/transpage?query={$redirectUrl}&source=url&ie=utf8&from=en&to=zh&render=1";
        return redirect($url);
    }

}
