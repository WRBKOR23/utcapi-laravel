<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidFormRequestException;
use App\Http\FormRequest\ChangePasswordForm;
use App\Http\FormRequest\UpdateQLDTPasswordForm;
use App\Services\Contracts\AccountServiceContract;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    private UpdateQLDTPasswordForm $form1;
    private ChangePasswordForm $form2;
    private AccountServiceContract $accountService;

    /**
     * @param UpdateQLDTPasswordForm $form1
     * @param ChangePasswordForm     $form2
     * @param AccountServiceContract $accountService
     */
    public function __construct (UpdateQLDTPasswordForm $form1, ChangePasswordForm $form2,
                                 AccountServiceContract $accountService)
    {
        $this->form1          = $form1;
        $this->form2          = $form2;
        $this->accountService = $accountService;
    }

    /**
     * @throws InvalidFormRequestException
     */
    public function updateQLDTPassword (Request $request)
    {
        $this->form1->validate($request);
        $this->accountService->updateQLDTPassword($request->only('id_account', 'id_student',
                                                                 'qldt_password'));
    }

    /**
     * @throws InvalidFormRequestException
     */
    public function changePassword (Request $request)
    {
        $this->form2->validate($request);
        $this->accountService->changePassword($request->only('id_account', 'username',
                                                             'password', 'new_password'));
    }
}
