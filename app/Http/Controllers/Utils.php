<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Utils extends Controller
{
    public static function guzzleGet(string $url, array $postData)
    {
        try {
            $client = new Client();
            $response = $client->request('GET', $url, [
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
