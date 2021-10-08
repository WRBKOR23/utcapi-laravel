<?php

namespace App\Http\Controllers\WebController\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutController extends Controller
{
    public function logout (Request $request)
    {
        Session::forget('user_name');
        Session::forget('id_account');
        Session::forget('ttl');

        auth()->logout();

        return response();
    }
}

