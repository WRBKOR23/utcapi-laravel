<?php

namespace App\Services;

use App\Repositories\Contracts\AccountRepositoryContract;
use App\Repositories\Contracts\StudentRepositoryContract;
use App\Repositories\Contracts\TeacherRepositoryContract;
use App\Exceptions\InvalidAccountException;
use App\Services\AbstractClasses\ALoginService;

class LoginAppService extends ALoginService
{
    private StudentRepositoryContract $studentRepository;
    private TeacherRepositoryContract $teacherRepository;

    /**
     * LoginAppService constructor.
     * @param AccountRepositoryContract $accountRepository
     * @param StudentRepositoryContract $studentRepository
     * @param TeacherRepositoryContract $teacherRepository
     */
    public function __construct (AccountRepositoryContract $accountRepository,
                                 StudentRepositoryContract $studentRepository,
                                 TeacherRepositoryContract $teacherRepository)
    {
        parent::__construct($accountRepository);
        $this->studentRepository = $studentRepository;
        $this->teacherRepository = $teacherRepository;
    }

    /**
     * @throws InvalidAccountException
     */
    protected function _customGetAccountOwnerInfo ($id_account, $permission)
    {
        switch ($permission)
        {
            case 0:
                $data       = $this->studentRepository->get($id_account);
                $data->name = $data->student_name;
                unset($data->student_name);
                break;

            case 1:
                $data       = $this->teacherRepository->get($id_account);
                $data->name = $data->teacher_name;
                unset($data->teacher_name);
                break;

            default:
                throw new InvalidAccountException();

        }

        return $data;
    }
}
