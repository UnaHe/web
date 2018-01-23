<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;
use \Firebase\JWT\JWT;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;

class PytaoAuthenticate
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
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function authenticate($request, $guards)
    {
        // 获取Cookie用户信息.
        $key = config('app.key');
        $jwt = Cookie::get('token')?:$request->header('token');
        $jwt = $jwt ?: $request->input('token');
        if (!$jwt){
            $userid = 56;
        }else{
            $userid = JWT::decode($jwt, $key, array('HS256'))->userid;
        }
        $user = User::find($userid);
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

        throw new AuthenticationException('Unauthenticated.', $guards);
    }
}
