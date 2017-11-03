<?php

namespace App\Http\Controllers;

use App\Helpers\ErrorHelper;
use App\Helpers\TaobaoHelper;
use App\Services\TaobaoService;
use Illuminate\Http\Request;


/**
 * 淘宝相关
 * Class TaobaoController
 * @package App\Http\Controllers
 */
class TaobaoController extends Controller
{
    /**
     * 重定向到淘宝授权登录地址
     */
    public function auth(){
        return redirect('https://oauth.taobao.com/authorize?response_type=token&client_id='.config("taobao.appkey").'&state=pyt&view=wap');
    }

    /**
     * 保存淘宝授权信息
     * @param Request $request
     */
    public function saveAuthToken(Request $request){
        $tokens = $request->post('tokens');
        $cookie = $request->post('cookie');
        $userId = $request->user()->id;

        $tokens = json_decode($tokens, true);
        if(!$tokens){
            return $this->ajaxError("参数错误");
        }
        if(!(array_key_exists('access_token', $tokens)
        && array_key_exists('token_type', $tokens)
        && array_key_exists('expires_in', $tokens)
        && array_key_exists('refresh_token', $tokens)
        && array_key_exists('re_expires_in', $tokens)
        && array_key_exists('taobao_user_id', $tokens)
        && array_key_exists('taobao_user_nick', $tokens)
        )){
            return $this->ajaxError("参数错误");
        }

        try{
            (new TaobaoService())->saveAuthToken($userId, $tokens, $cookie);
        }catch (\Exception $e){
            $message = "绑定淘宝账号失败";
            $code = $e->getCode();
            if($e->getCode() == 300 || $e->getCode() == 201){
                $message = $e->getMessage();
            }
            $code = $code ?: 300;
            return $this->ajaxError($message, $code);
        }

        return $this->ajaxSuccess();
    }

    /**
     * 保存pid
     * @param Request $request
     * @return static
     */
    public function savePid(Request $request){
        $pid = $request->post('pid');
        $userId = $request->user()->id;
        if(!$pid){
            return $this->ajaxError("参数错误");
        }
        if(!(new TaobaoHelper())->isPid($pid)){
            return $this->ajaxError("PID格式错误");
        }

        try{
            if(!(new TaobaoService())->savePid($userId, $pid)){
                throw new \Exception("绑定PID失败");
            }
        }catch (\Exception $e){
            $errorCode = $e->getCode() ?: 300;
            $errMsg = ($errorCode == ErrorHelper::ERROR_TAOBAO_INVALID_PID || $errorCode == ErrorHelper::ERROR_TAOBAO_INVALID_SESSION) ? $e->getMessage() : "绑定PID失败";

            return $this->ajaxError($errMsg, $errorCode);
        }

        return $this->ajaxSuccess();
    }

    /**
     * 查询淘宝授权状态
     * @param Request $request
     */
    public function authInfo(Request $request){
        $data = (new TaobaoService())->authInfo($request->user()->id);
        return $this->ajaxSuccess($data);
    }

}
