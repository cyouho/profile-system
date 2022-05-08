<?php

/*
|--------------------------------------------------------------------------------
| Auth API URL
|--------------------------------------------------------------------------------
|
| Here is where you can register, login, logout web routes for your application. 
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

define('AUTH_API_DOMAIN', 'http://127.0.0.2');
define('AUTH_API_PORT', ':9000');

return [
    'login' => constant('AUTH_API_DOMAIN') . constant('AUTH_API_PORT') . '/api/login',
    'register' => constant('AUTH_API_DOMAIN') . constant('AUTH_API_PORT') . '/api/register',
    'check_login' => constant('AUTH_API_DOMAIN') . constant('AUTH_API_PORT') . '/api/authenticate',
    'logout' => constant('AUTH_API_DOMAIN') . constant('AUTH_API_PORT') . '/api/logout',
];
