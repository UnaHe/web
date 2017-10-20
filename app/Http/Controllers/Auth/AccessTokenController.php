<?php

namespace App\Http\Controllers\Auth;

use App\Traits\AjaxResponse;
use Psr\Http\Message\ServerRequestInterface;
use \Laravel\Passport\Http\Controllers\AccessTokenController as PassportAccessToken;
use Zend\Diactoros\Response as Psr7Response;

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
}
