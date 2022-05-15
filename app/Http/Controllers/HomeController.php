<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function profile()
    {
        return view('profile.profile_layer', ['page_data' => [
            'page_title' => '个人中心',
        ]]);
    }

    public function setting()
    {
        return view('setting.setting_layer', ['page_data' => [
            'page_title' => '设置',
        ]]);
    }

    public function home()
    {
        return view('home.home_layer', ['page_data' => [
            'page_title' => '应用中心',
        ]]);
    }
}
