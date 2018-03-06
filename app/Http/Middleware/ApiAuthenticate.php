<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use GuzzleHttp\Client;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\Models\User;

class ApiAuthenticate
{
    /**
     * The authentication factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);

        return $next($request);
    }

    /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param Request $request
     * @param  array $guards
     * @return void
     *
     * @throws AuthenticationException
     */
    protected function authenticate(Request $request, array $guards)
    {
        try{
            $response = (new Client())->post(config('app.usercenter_host')."/api/checkAuth", [
                'headers' => [
                    'authorization' => $request->header('authorization')
                ]
            ])->getBody()->getContents();

            if(!$response){
                Log::error("认证服务器错误");
                throw new \Exception("认证服务器错误");
            }
            $result = json_decode($response, true);
            if($result['code'] == 300){
                throw new \Exception("认证失败");
            }

            $user = User::find($result['data']['id']);
            if($user){
                if($user['expiry_time'] && Carbon::now()->diffInSeconds(new Carbon($user['expiry_time']), false)<=0){
                    throw new AuthenticationException('账号已过期.', $guards);
                }

                // 将用户信息加入请求对象.
                $request->setUserResolver(function() use($user){
                    return $user;
                });
                return;
            }
        }catch (\Exception $e){
        }

        throw new AuthenticationException('Unauthenticated.', $guards);
    }
}
