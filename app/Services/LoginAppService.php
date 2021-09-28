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

    /**
     * @throws InvalidAccountException
     */
    protected function _customGetAccountOwnerInfo ($id_account, $permission)
    {
        switch ($permission)
        {
            case 0:
                $data       = $this->studentDepository->get($id_account);
                $data->name = $data->student_name;
                unset($data->student_name);
                break;

            case 1:
                $data       = $this->teacherDepository->get($id_account);
                $data->name = $data->teacher_name;
                unset($data->teacher_name);
                break;

            default:
                throw new InvalidAccountException();

        }

        return $data;
    }
}
