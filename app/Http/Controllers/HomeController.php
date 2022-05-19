<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;

class HomeController extends Controller
{
    public function profile(Request $request)
    {
        $profileData = new ProfileController();

        $userId = $request->input('user_id');
        $data = $profileData->getProfiledata($userId);

        return view('profile.profile_layer', ['page_data' => [
            'page_title' => '个人中心',
            'profile_data' => $data['http_status'] === 200 ? $data['response_contents'][0] : null,
        ]]);
    }

    public function setting(Request $request)
    {
        $userId = $request->input('user_id');

        return view('setting.setting_layer', ['page_data' => [
            'page_title' => '设置',
            'setting_data' => [
                'user_id' => $userId,
            ],
        ]]);
    }

    public function home()
    {
        return view('home.home_layer', ['page_data' => [
            'page_title' => '应用中心',
        ]]);
    }
}
