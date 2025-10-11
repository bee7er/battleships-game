<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Set a cookie to a given value
     * @param $cookieName
     * @param $value
     */
    public static function setCookie($cookieName, $value)
    {
        $_COOKIE[$cookieName] = $value;
    }

    /**
     * Retrieve a cookie value providing a default
     * @param $cookieName
     * @param $default
     * @return mixed
     */
    public static function getCookie($cookieName, $default)
    {
        $value = isset($_COOKIE[$cookieName]) ? $_COOKIE[$cookieName]: $default;
        return $value;
    }

}
