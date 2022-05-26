<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    /**
     * API URLs.
     * 各种API的url
     */
    private $_url = [];

    /**
     * Get API URLs.
     * 获取API的url的构造方法
     */
    public function __construct()
    {
        $this->_url = config('serverurl');
    }

    /**
     * Show Register Page.
     * 显示注册页面
     */
    public function showRegisterPage()
    {
        return view('auth.register');
    }

    /**
     * Show Login Page.
     * 显示登陆页面
     */
    public function showLoginPage()
    {
        return view('auth.login');
    }

    /**
     * Register function.
     * 注册方法
     * 
     * @param Request $request <input data | 输入数据>
     * 
     * @return mix <page or err msg | 主页或错误信息>
     */
    public function doRegister(Request $request)
    {
        $postData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|max:16|min:8',
        ]);

        $result = $this->guzzlePost('register', $postData);

        if ($result['http_status'] === 201) {
            return response()->redirectTo('/')->cookie('_cyouho', $result['response_contents']['session'], 60, '/', 'cyouho.com');
        } else {
            return back()->with('email', 'User aleardy exitsed or something others error occred');
        }
    }

    /**
     * Login function.
     * 登录方法
     * 
     * @param Request $request <input data | 输入数据>
     * 
     * @return mix <page or err msg | 主页或错误信息>
     */
    public function doLogin(Request $request)
    {
        $postData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|max:16|min:8',
        ]);

        $result = $this->guzzlePost('login', $postData);

        if ($result['http_status'] === 200) {
            return response()->redirectTo('/')->cookie('_cyouho', $result['response_contents']['session'], 60, '/', 'cyouho.com');
        } else if ($result['response_contents']['api_status_code'] === 40401) {
            return back()->with('email', $result['response_contents']['message']);
        } else if ($result['response_contents']['api_status_code'] === 40402) {
            return back()->with('password', $result['response_contents']['message']);
        }
    }

    public function doLogout()
    {
        $cookie = Cookie::forget('_cyouho', '/', 'cyouho.com');
        $userCookie = request()->cookie('_cyouho');

        $postData = [
            'session' => $userCookie,
        ];

        $result = $this->guzzlePost('logout', $postData);

        return response()->redirectTo('/')->withCookie($cookie);
    }

    private function guzzlePost(string $urlName, array $postData = [])
    {
        try {
            $client = new Client();
            $response = $client->request('POST', $this->_url[$urlName], [
                'header' => [
                    'Accept' => 'application/json',
                ],
                'form_params' => $postData,
                'http_errors' => FALSE, // api 会返回自己的错误信息，这些不计入 http 错误
            ]);
            $statusCode = $response->getStatusCode();
            $rsp = $response->getBody()->getContents();
            $response = json_decode($rsp, TRUE);
        } catch (ClientException $e) {
            report($e);
            return back();
        }

        return [
            'http_status' => $statusCode,
            'response_contents' => $response,
        ];
    }
}
