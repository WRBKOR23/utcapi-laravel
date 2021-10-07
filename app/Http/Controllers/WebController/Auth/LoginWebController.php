<?php

namespace App\Http\Controllers\WebController\Auth;

use App\Http\Controllers\Controller;
use App\Http\FormRequest\LoginForm;
use App\Services\Contracts\LoginWebServiceContract;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class LoginWebController extends Controller
{
    protected LoginForm $loginForm;
    private LoginWebServiceContract $loginWebService;

    /**
     * LoginController constructor.
     * @param LoginForm $loginForm
     * @param LoginWebServiceContract $loginWebService
     */
    public function __construct (LoginForm $loginForm, LoginWebServiceContract $loginWebService)
    {
        $this->loginForm       = $loginForm;
        $this->loginWebService = $loginWebService;
    }

    public function showLoginScreen ()
    {
        if (session('username') !== null
            && session('id_account') !== null
            && session('ttl') !== null)
        {
            return redirect('home');
        }

        return view('login');
    }

    /**
     * @param Request $request
     * @return Application|Redirector|RedirectResponse
     */
    public function login (Request $request)
    {
        try
        {
            $this->loginForm->validate($request);
            $data = $this->loginWebService->login($request->username, $request->password);

            return view('welcome')->with('access_token', $data['access_token']);
        }
        catch (Exception $e)
        {
            return redirect('/login?status=failed');
        }
    }
}
