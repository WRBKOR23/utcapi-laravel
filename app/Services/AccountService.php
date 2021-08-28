<?php

namespace App\Services;

use App\Depositories\Contracts\AccountDepositoryContract;
use App\Depositories\Contracts\StudentDepositoryContract;
use App\Exceptions\InvalidAccountException;
use App\Services\Contracts\AccountServiceContract;

class AccountService implements AccountServiceContract
{
    private AccountDepositoryContract $accountDepository;

    /**
     * AccountService constructor.
     * @param AccountDepositoryContract $accountDepository
     */
    public function __construct (AccountDepositoryContract $accountDepository)
    {
        $this->accountDepository = $accountDepository;
    }

    public function updateQLDTPassword ($username, $qldt_password)
    {
        $this->accountDepository->updateQLDTPassword($username, md5($qldt_password));
    }

    /**
     * @throws InvalidAccountException
     */
    public function changePassword ($username, $password, $new_password)
    {
        $this->_verifyAccount($username, $password);
        $this->_updatePassword($username, $new_password);
    }

    /**
     * @throws InvalidAccountException
     */
    private function _verifyAccount ($username, $password)
    {
        $credential = [
            'username' => $username,
            'password' => $password
        ];

        if (!auth()->attempt($credential))
        {
            throw new InvalidAccountException();
        }
    }

    private function _updatePassword ($username, $password)
    {
        $this->accountDepository->updatePassword($username, bcrypt($password));
    }
}
