<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    private $_url = [];

    public function __construct()
    {
        $this->_url = config('serverurl');
    }

    public function showRegisterPage()
    {
        return view('auth.register');
    }

    public function showLoginPage()
    {
        return view('auth.login');
    }

    public function doRegister(Request $request)
    {
        $postData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|max:16|min:8',
        ]);

        $result = $this->guzzlePost('register', $postData);

        if ($result['http_status'] === 201) {
            return response()->redirectTo('/')->cookie('_cyouho', $result['response_contents']['session'], 60);
        } else {
            return back()->with('email', 'User aleardy exitsed or something others error occred');
        }
    }

    public function doLogin(Request $request)
    {
        $postData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|max:16|min:8',
        ]);

        $result = $this->guzzlePost('login', $postData);

        if ($result['http_status'] === 200) {
            return response()->redirectTo('/')->cookie('_cyouho', $result['response_contents']['session'], 60);
        } else if ($result['response_contents']['api_status_code'] === 40401) {
            return back()->with('email', $result['response_contents']['message']);
        } else if ($result['response_contents']['api_status_code'] === 40402) {
            return back()->with('password', $result['response_contents']['message']);
        }
    }

    public function doLogout()
    {
        $cookie = Cookie::forget('_cyouho');
        $userCookie = request()->cookie('_cyouho');

        $result = $this->guzzlePost('logout');

        $cookie = Cookie::forget('_cyouho');
        return response()->redirectTo('/')->cookie($cookie);
    }

    private function guzzlePost(string $urlName, array $postData = [])
    {
        try {
            $client = new Client();
            $response = $client->request('POST', $this->_url[$urlName], [
                'header' => [
                    'Accept' => 'application/json',
                ],
                'form_params' => [
                    'email' => $postData['email'],
                    'password' => $postData['password'],
                ],
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
