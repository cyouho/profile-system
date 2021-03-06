<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cookie;

/**
 * Auth Status Check Middleware.
 * 登录状态检查中间件
 */
class AuthStatus
{
    /**
     * Handle an incoming request.
     * 判断用户是否登录方法
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $cookie = request()->cookie('_cyouho');

        if (is_null($cookie)) {
            redirect('/login')->send();
        }

        $url = config('serverurl');

        try {
            $client = new Client();
            $response = $client->request('POST', $url['check_login'], [
                'header' => [
                    'Accept' => 'application/json',
                ],
                'form_params' => [
                    'session' => $cookie,
                ],
                'http_errors' => FALSE, // api 会返回自己的错误信息，这些不计入 http 错误
            ]);
            $statusCode = $response->getStatusCode();
            $rsp = $response->getBody()->getContents();

            if ($rsp === '[]') {
                $cookie = Cookie::forget('_cyouho');
                return response()->redirectTo('/')->cookie($cookie);
            }

            $response = json_decode($rsp, TRUE);
        } catch (ClientException $e) {
            report($e);
        }

        // 全局使用的参数，用户ID，用户名，是否登录
        $globalData = [
            'user_id' => $response['user_id'],
            'user_name' => $response['user_name'],
            'is_login' => TRUE,
        ];

        $request->merge($globalData); // 将 $globalData 传入控制器中

        view()->share('global_data', $globalData);
        return $next($request);
    }
}
