<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * Utils for Controllers.
 * 控制器的工具类
 */
class Utils extends Controller
{
    /**
     * Guzzle for Get Methed.
     * guzzle的get方法
     * 
     * @param string $url <url for api | api的get方法url>
     * @return array <http_status, response_contents>
     */
    public static function guzzleGet(string $url)
    {
        try {
            $client = new Client();
            $response = $client->request('GET', $url, [
                'header' => [
                    'Accept' => 'application/json',
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

    public static function guzzlePost()
    {
    }


    /**
     * Guzzle for Put Methed.
     * guzzle的put方法
     * 
     * @param string $url <url for api | api的put方法url>
     * @param array $putData <put data>
     * @return array <http_status, response_contents>
     */
    public static function guzzlePut(string $url, array $putData)
    {
        try {
            $client = new Client();
            $response = $client->request('PUT', $url, [
                'header' => [
                    'Accept' => 'application/json',
                ],
                'form_params' => $putData,
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
