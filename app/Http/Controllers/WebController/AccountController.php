<?php


namespace App\Http\Controllers\WebController;


use App\Exceptions\InvalidFormRequestException;
use App\Http\Controllers\Controller;
use App\Http\RequestForm\ChangePasswordForm;
use App\Services\Contracts\AccountServiceContract;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    private ChangePasswordForm $form;
    private AccountServiceContract $accountService;

    /**
     * AccountController constructor.
     * @param ChangePasswordForm $form
     * @param AccountServiceContract $accountService
     */
    public function __construct (ChangePasswordForm $form, AccountServiceContract $accountService)
    {
        $this->form           = $form;
        $this->accountService = $accountService;
    }

    /**
     * @throws InvalidFormRequestException
     */
    public function changePassword (Request $request)
    {
        $this->form->validate($request);
        $this->accountService->changePassword($request->id_student, $request->password, $request->new_password);
    }
}
