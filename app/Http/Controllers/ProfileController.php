<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Utils as ControllerUtils;

class ProfileController extends Controller
{
    private $_user_account_api_url = [];

    public function __construct()
    {
        $this->_user_account_api_url = config('serverurl.user_account_data');
    }

    public function getProfiledata($userId)
    {
        $data = ControllerUtils::guzzleGet($this->_user_account_api_url['get_user_account_data'] . $userId);

        return $data;
    }
}
