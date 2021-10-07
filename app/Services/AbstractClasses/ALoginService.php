<?php

namespace App\Services\AbstractClasses;

use App\Repositories\Contracts\AccountRepositoryContract;
use App\Exceptions\InvalidAccountException;
use App\Services\Contracts\LoginAppServiceContract;
use App\Services\Contracts\LoginWebServiceContract;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class ALoginService implements LoginWebServiceContract, LoginAppServiceContract
{
    private AccountRepositoryContract $accountDepository;

    /**
     * ALoginService constructor.
     * @param AccountRepositoryContract $accountDepository
     */
    public function __construct (AccountRepositoryContract $accountDepository)
    {
        $this->accountDepository = $accountDepository;
    }

    /**
     * @throws InvalidAccountException
     */
    public function login ($username, $password) : array
    {
        $token = $this->_authenticate($username, $password);
        $data  = $this->_customGetAccountOwnerInfo(JWTAuth::user()->id, JWTAuth::user()->permission);

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

        if (!$token = JWTAuth::attempt($credential))
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
        Session::put('username', $user_name);
        Session::put('id', $id_account);
        Session::put('ttl', time() + 900);
    }
}
