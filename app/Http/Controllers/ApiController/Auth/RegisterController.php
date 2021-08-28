<?php


namespace App\Http\Controllers\ApiController\Auth;


use App\BusinessClass\CrawlQLDTData;
use App\Http\Controllers\Controller;
use App\Http\RequestForm\RegisterForm;
use App\Services\Contracts\RegisterServiceContract;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    private RegisterForm $form;
    private RegisterServiceContract $registerService;

    /**
     * RegisterController constructor.
     * @param RegisterForm $form
     * @param RegisterServiceContract $registerService
     */
    public function __construct (RegisterForm $form, RegisterServiceContract $registerService)
    {
        $this->form            = $form;
        $this->registerService = $registerService;
    }

    public function register(Request $request)
    {
        $this->form->validate($request);

        if (!$this->registerService->register($request->all()))
        {
            return response('Account available', 406);
        }

        return response('', 201);
    }
}
