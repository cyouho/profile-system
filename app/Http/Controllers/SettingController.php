<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Utils as ControllerUtils;

/**
 * Setting controller.
 * 设置控制器
 */
class SettingController extends Controller
{
    /**
     * API Urls.
     * API的URL
     */
    private $_url = [];

    /**
     * construct function.
     * 控制器构造方法
     */
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
