<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CaptchaController extends Controller
{
    public function refresh()
    {
        $code = strtoupper(substr(md5(mt_rand()), 0, 5));
        Session::put('captcha_code', $code);

        return response()->json(['captcha' => $code]);
    }
}