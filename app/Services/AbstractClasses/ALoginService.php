<?php

namespace App\Services\AbstractClasses;

use App\Depositories\Contracts\AccountDepositoryContract;
use App\Exceptions\InvalidAccountException;
use App\Services\Contracts\LoginAppServiceContract;
use App\Services\Contracts\LoginWebServiceContract;
use Illuminate\Support\Facades\Session;

abstract class ALoginService implements LoginWebServiceContract, LoginAppServiceContract
{
    private AccountDepositoryContract $accountDepository;

    /**
     * ALoginService constructor.
     * @param AccountDepositoryContract $accountDepository
     */
    public function __construct (AccountDepositoryContract $accountDepository)
    {
        $this->accountDepository = $accountDepository;
    }

    /**
     * @throws InvalidAccountException
     */
    public function login ($username, $password): array
    {
        $token = $this->_authenticate($username, $password);
        $data  = $this->_customGetAccountOwnerInfo(auth()->user()->id, auth()->user()->permission);

        return [
            'access_token' => $token,
            'data'         => $data
        ];
    }

    /**
     * @throws InvalidAccountException
     */
    private function _authenticate ($username, $password)
    {
        $credential = [
            'username' => $username,
            'password' => $password
        ];

        if (!$token = auth()->attempt($credential))
        {
            throw new InvalidAccountException();
        }

        return $token;
    }

    protected function _customGetAccountOwnerInfo ($id_account, $permission)
    {
        return null;
    }

    protected function _setSession ($id_account, $user_name)
    {
        Session::put('user_name', $user_name);
        Session::put('id_account', $id_account);
        Session::put('ttl', time() + 900);
    }
}
