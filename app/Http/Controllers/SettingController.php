<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Utils as ControllerUtils;

class SettingController extends Controller
{
    private $_url = [];

    public function __construct()
    {
        $this->_url = config('serverurl');
    }

    public function resetUserName(Request $request)
    {
        $postData = $request->validate([
            'newUserName' => 'required',
            'userId' => 'required|numeric',
        ]);

        $newUserName = $postData['newUserName'];
        $userId = $postData['userId'];

        $a = ControllerUtils::guzzlePut(
            $this->_url['user_reset_name'] . $userId,
            [
                'user_name' => $newUserName,
                'user_session' => request()->cookie('_cyouho'),
            ]
        );

        return back();
    }
}