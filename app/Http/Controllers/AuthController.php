<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

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

        $result = $this->guzzlePost($postData);
    }

    public function doLogin(Request $request)
    {
        $postData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|max:16|min:8',
        ]);

        $result = $this->guzzlePost($postData);
    }

    private function guzzlePost(array $postData = [])
    {
        try {
            $client = new Client();
            $response = $client->request('POST', $this->_url['register'], [
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
    }
}
