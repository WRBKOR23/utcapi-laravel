<?php

namespace App\Services;

use App\BusinessClasses\CrawlQLDTData;
use App\Repositories\Contracts\AccountRepositoryContract;
use App\Exceptions\InvalidAccountException;
use App\Services\Contracts\AccountServiceContract;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class AccountService implements AccountServiceContract
{
    private CrawlQLDTData $crawl;
    private AccountRepositoryContract $accountDepository;

    /**
     * AccountService constructor.
     * @param CrawlQLDTData $crawl
     * @param AccountRepositoryContract $accountDepository
     */
    public function __construct (CrawlQLDTData $crawl, AccountRepositoryContract $accountDepository)
    {
        $this->crawl             = $crawl;
        $this->accountDepository = $accountDepository;
    }

    /**
     * @throws Exception
     */
    public function updateQLDTPassword ($username, $qldt_password)
    {
        $this->crawl->loginQLDT($username, md5($qldt_password));
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

        if (!JWTAuth::attempt($credential))
        {
            throw new InvalidAccountException();
        }
    }

    private function _updatePassword ($username, $password)
    {
        $this->accountDepository->updatePassword($username, bcrypt($password));
    }
}
