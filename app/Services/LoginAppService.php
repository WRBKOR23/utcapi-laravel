<?php

namespace App\Services;

use App\Repositories\Contracts\AccountRepositoryContract;
use App\Repositories\Contracts\StudentRepositoryContract;
use App\Repositories\Contracts\TeacherRepositoryContract;
use App\Exceptions\InvalidAccountException;
use App\Services\AbstractClasses\ALoginService;

class LoginAppService extends ALoginService
{
    private StudentRepositoryContract $studentDepository;
    private TeacherRepositoryContract $teacherDepository;

    /**
     * LoginAppService constructor.
     * @param AccountRepositoryContract $accountDepository
     * @param StudentRepositoryContract $studentDepository
     * @param TeacherRepositoryContract $teacherDepository
     */
    public function __construct (AccountRepositoryContract $accountDepository,
                                 StudentRepositoryContract $studentDepository,
                                 TeacherRepositoryContract $teacherDepository)
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
