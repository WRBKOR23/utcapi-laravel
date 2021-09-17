<?php


namespace App\Http\Controllers\ApiController\Auth;


use App\BusinessClass\CrawlQLDTData;
use App\Exceptions\InvalidFormRequestException;
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

    public function process1 (Request $request)
    {
        return $this->registerService->process1($request->id_student, $request->qldt_password);
    }

    public function process2 (Request $request)
    {
        return $this->registerService->process2($request->all());
    }
}
