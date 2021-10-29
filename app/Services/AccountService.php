<?php

namespace App\Services;

use App\BusinessClasses\CrawlQLDTData;
use App\Repositories\Contracts\AccountRepositoryContract;
use App\Exceptions\InvalidAccountException;
use Exception;

class AccountService implements Contracts\AccountServiceContract
{
    private CrawlQLDTData $crawl;
    private AccountRepositoryContract $accountRepository;

    /**
     * @param CrawlQLDTData             $crawl
     * @param AccountRepositoryContract $accountRepository
     */
    public function __construct (CrawlQLDTData $crawl, AccountRepositoryContract $accountRepository)
    {
        $this->crawl             = $crawl;
        $this->accountRepository = $accountRepository;
    }

    /**
     * @throws Exception
     */
    public function updateQLDTPassword ($username, $qldt_password)
    {
        $this->crawl->loginQLDT($username, md5($qldt_password));
        $this->accountRepository->updateQLDTPassword($username, md5($qldt_password));
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
        $this->accountRepository->updatePassword($username, bcrypt($password));
    }
}
