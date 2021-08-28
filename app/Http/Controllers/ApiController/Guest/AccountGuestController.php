<?php


namespace App\Http\Controllers\ApiController\Guest;


use App\Http\Controllers\Controller;
use App\Services\Contracts\Guest\AccountGuestServiceContract;
use Illuminate\Http\Request;

class AccountGuestController extends Controller
{
    private AccountGuestServiceContract $accountGuestService;

    /**
     * AccountGuestController constructor.
     * @param AccountGuestServiceContract $accountGuestService
     */
    public function __construct (AccountGuestServiceContract $accountGuestService)
    {
        $this->accountGuestService = $accountGuestService;
    }

    public function updatePassword (Request $request)
    {
        return $this->accountGuestService->updatePassword($request->id_student, $request->password);
    }

    public function updateDeviceToken (Request $request)
    {
        return $this->accountGuestService->updateDeviceToken($request->id_student, $request->device_token);
    }
}
