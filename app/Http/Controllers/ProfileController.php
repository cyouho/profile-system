<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Utils as ControllerUtils;

/**
 * Profile controller.
 * 个人主页控制器
 */
class ProfileController extends Controller
{
    /**
     * API Urls.
     * API的url
     */
    private $_user_account_api_url = [];

    /**
     * Construct function for get API Urls.
     * 获取API的Url的构造方法
     */
    public function __construct()
    {
        $this->_user_account_api_url = config('serverurl.user_account_data');
    }

    /**
     * Get profile page datas by API.
     * 通过API获取profile页面数据
     */
    public function getProfiledata($userId)
    {
        $data = ControllerUtils::guzzleGet($this->_user_account_api_url['get_user_account_data'] . $userId);

        return $data;
    }
}
