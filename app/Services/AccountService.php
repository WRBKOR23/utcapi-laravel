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
     * @param $input *
     *
     * @throws Exception
     */
    public function updateQLDTPassword ($input)
    {
        $this->crawl->loginQLDT($input['id_student'], md5($input['qldt_password']));
        $this->accountRepository->updateQLDTPassword($input['id_account'],
                                                     md5($input['qldt_password']));
    }

    /**
     * @param $input *
     *
     * @throws InvalidAccountException
     */
    public function changePassword ($input)
    {
        $this->_verifyAccount($input['username'], $input['password']);
        $this->_updatePassword($input['id_account'], $input['new_password']);
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

    private function _updatePassword ($id_account, $password)
    {
        $this->accountRepository->updatePassword($id_account, bcrypt($password));
    }
}
