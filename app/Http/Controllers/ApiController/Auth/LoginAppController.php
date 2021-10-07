<?php

namespace App\Http\Controllers\ApiController\Auth;

use App\Exceptions\InvalidFormRequestException;
use App\Http\Controllers\Controller;
use App\Http\FormRequest\LoginForm;
use App\Services\Contracts\LoginAppServiceContract;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoginAppController extends Controller
{
    protected LoginForm $loginForm;
    private LoginAppServiceContract $loginAppService;

    /**
     * LoginController constructor.
     * @param LoginForm $loginForm
     * @param LoginAppServiceContract $loginAppService
     */
    public function __construct (LoginForm $loginForm, LoginAppServiceContract $loginAppService)
    {
        $this->loginForm       = $loginForm;
        $this->loginAppService = $loginAppService;
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     * @throws InvalidFormRequestException
     */
    public function login (Request $request)
    {
        $this->loginForm->validate($request);

        if (($data = $this->loginAppService->login($request->username, $request->password)) == null)
        {
            return response('Unauthorized', 401);
        }

        return response(json_encode($data['data']))
            ->header('Content-Type', 'application/json')
            ->header('Authorization', 'Bearer ' . $data['access_token']);
    }
}
