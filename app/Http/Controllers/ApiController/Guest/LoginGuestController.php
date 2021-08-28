<?php

namespace App\Http\Controllers\ApiController\Guest;

use App\Http\Controllers\Controller;
use App\Services\Contracts\Guest\LoginGuestServiceContract;
use Illuminate\Http\Request;

class LoginGuestController extends Controller
{
    private LoginGuestServiceContract $loginGuestService;

    /**
     * LoginController constructor.
     * @param LoginGuestServiceContract $loginGuestService
     */
    public function __construct (LoginGuestServiceContract $loginGuestService)
    {
        $this->loginGuestService = $loginGuestService;
    }

    public function login(Request $request)
    {
        return $this->loginGuestService->login($request->username, $request->password);
    }
}
