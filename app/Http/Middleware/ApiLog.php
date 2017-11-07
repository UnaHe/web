<?php

namespace App\Http\Middleware;

use App\Helpers\EsHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ApiLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        $startTime = LARAVEL_START;
        $endTime = microtime(true);
        $spendTime = bcsub($endTime, $startTime, 3);

        (new EsHelper())->client()->index($params = [
            'index' => 'apilog',
            'type' => 'apilog',
            'body' => [
                'request_uri' => $request->getPathInfo(),
                'request_method' => $request->getMethod(),
                'request_ip' => $request->getClientIp(),
                'request_get' => $request->getQueryString(),
                'request_post' => $request->getContent(),
                'request_header' => $request->headers->__toString(),

                'response_status' => $response->getStatusCode(),
                'response_header' => $response->headers->__toString(),
                'response_content' => $response->getContent(),

                'request_time' => date('Y-m-d H:i:s', $startTime),
                'response_time' => date('Y-m-d H:i:s', $endTime),
                'spend_time' => $spendTime,
            ]
        ]);
    }
}
