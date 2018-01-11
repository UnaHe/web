<?php

namespace App\Http\Controllers\Auth;

use App\Traits\AjaxResponse;
use Carbon\Carbon;
use Psr\Http\Message\ServerRequestInterface;
use \Laravel\Passport\Http\Controllers\AccessTokenController as PassportAccessToken;
use Zend\Diactoros\Request;
use Zend\Diactoros\Response as Psr7Response;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use \Firebase\JWT\JWT;

/**
 * 重写passport授权登录过程
 * Class AccessTokenController
 * @package App\Http\Controllers
 */
class AccessTokenController extends PassportAccessToken
{
    use AjaxResponse;

    public function issueToken(ServerRequestInterface $request)
    {
        $response =  $this->withErrorHandling(function () use ($request) {
            return $this->convertResponse(
                $this->server->respondToAccessTokenRequest($request, new Psr7Response)
            );
        });
        $content = json_decode($response->getContent(), true);
        if(array_key_exists('error', $content)){
            $error = $content['error'];
            $errorMsg = $content['message'];

            switch ($error){
                case 'invalid_credentials':{
                    $errorMsg = '用户名或密码错误';
                    break;
                }
                case 'invalid_client':
                case 'invalid_scope':
                case 'unsupported_grant_type':{
                    $errorMsg = '客户端认证失败';
                    break;
                }
            }
            return $this->ajaxError($errorMsg);
        }

        return $this->ajaxSuccess($content);
    }

    /**
     * 朋友淘WAP自动登录接口.
     * @param $code.
     */
    public function Login($code, $redirect = [])
    {
        // 获取用户信息JWT编码.
        $user = User::where('invite_code', $code)->first();

        if (!$user) {
            return $this->ajaxError("邀请码错误");
        }

        if($user['expiry_time'] && Carbon::now()->diffInSeconds(new Carbon($user['expiry_time']), false)<=0){
            return $this->ajaxError("账号已过期");
        }

        $key = config('app.key');
        $nbf = time()+1296000;
        $token = array(
            "userid" => $user->id,
            "exp" => $nbf
        );
        $jwt = JWT::encode($token, $key);

        return $this->ajaxSuccess($jwt);
    }
}
