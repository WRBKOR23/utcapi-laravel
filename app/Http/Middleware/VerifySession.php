<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VerifySession
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle (Request $request, Closure $next)
    {

//        if (session('ttl') === null
//            || time() > session('ttl'))
//        {
//            Session::forget('username');
//            Session::forget('id');
//            Session::forget('ttl');
//
//            return redirect('/login');
//        }
//        Session::put('ttl', time() + 900);

        return $next($request);
    }
}
