<?php

namespace App\Services;

use App\Depositories\Contracts\AccountDepositoryContract;
use App\Depositories\Contracts\StudentDepositoryContract;
use App\Depositories\Contracts\TeacherDepositoryContract;
use App\Exceptions\InvalidAccountException;
use App\Services\AbstractClasses\ALoginService;

class LoginAppService extends ALoginService
{
    private StudentDepositoryContract $studentDepository;
    private TeacherDepositoryContract $teacherDepository;

    /**
     * LoginAppService constructor.
     * @param AccountDepositoryContract $accountDepository
     * @param StudentDepositoryContract $studentDepository
     * @param TeacherDepositoryContract $teacherDepository
     */
    public function __construct (AccountDepositoryContract $accountDepository,
                                 StudentDepositoryContract $studentDepository,
                                 TeacherDepositoryContract $teacherDepository)
    {
        parent::__construct($accountDepository);
        $this->studentDepository = $studentDepository;
        $this->teacherDepository = $teacherDepository;
    }

    public function login ($username, $password): array
    {
        return parent::login($username, $password);
    }

    /**
     * @throws InvalidAccountException
     */
    protected function _customGetAccountOwnerInfo ($id_account, $permission)
    {
        switch ($permission)
        {
            case 0:
                $data       = $this->studentDepository->get($id_account);
                $data->Name = $data->Student_Name;
                unset($data->Student_Name);
                break;

            case 1:
                $data       = $this->teacherDepository->get($id_account);
                $data->Name = $data->Name_Teacher;
                unset($data->Name_Teacher);
                break;

            default:
                throw new InvalidAccountException();

        }

        return $data;
    }
}
