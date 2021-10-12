<?php

namespace App\Services;

use App\Repositories\Contracts\AccountRepositoryContract;
use App\Repositories\Contracts\DepartmentRepositoryContract;
use App\Repositories\Contracts\FacultyRepositoryContract;
use App\Repositories\Contracts\OtherDepartmentRepositoryContract;
use App\Repositories\Contracts\TeacherRepositoryContract;
use App\Exceptions\InvalidAccountException;
use App\Services\AbstractClasses\ALoginService;
use Illuminate\Support\Facades\Storage;

class LoginWebService extends ALoginService
{
    private OtherDepartmentRepositoryContract $otherDepartmentRepository;
    private DepartmentRepositoryContract $departmentRepository;
    private TeacherRepositoryContract $teacherRepository;
    private FacultyRepositoryContract $facultyRepository;

    /**
     * LoginService constructor.
     * @param OtherDepartmentRepositoryContract $otherDepartmentRepository
     * @param DepartmentRepositoryContract $departmentRepository
     * @param TeacherRepositoryContract $teacherRepository
     * @param FacultyRepositoryContract $facultyRepository
     * @param AccountRepositoryContract $accountRepository
     */
    public function __construct (OtherDepartmentRepositoryContract $otherDepartmentRepository,
                                 DepartmentRepositoryContract      $departmentRepository,
                                 TeacherRepositoryContract         $teacherRepository,
                                 FacultyRepositoryContract         $facultyRepository,
                                 AccountRepositoryContract         $accountRepository)
    {
        parent::__construct($accountRepository);
        $this->otherDepartmentRepository = $otherDepartmentRepository;
        $this->departmentRepository      = $departmentRepository;
        $this->facultyRepository         = $facultyRepository;
        $this->teacherRepository         = $teacherRepository;
    }

    /**
     * @throws InvalidAccountException
     */
    protected function _customGetAccountOwnerInfo ($id_account, $permission)
    {
        switch ($permission)
        {
            case 1:
                $data       = $this->teacherRepository->get($id_account);
                $data->name = 'Gv.' . $data->teacher_name;
                break;

            case 2:
                $data       = $this->departmentRepository->get($id_account);
                $data->name = 'Bộ môn ' . $data->department_name;
                break;
            case 3:
                $data       = $this->facultyRepository->get($id_account);
                $data->name = 'Khoa ' . $data->faculty_name;
                break;

            case 4:
                $data       = $this->otherDepartmentRepository->get($id_account);
                $data->name = $data->other_department_name;
                break;

            default:
                throw new InvalidAccountException();

        }
        $this->_setSession($data->id_account, $data->name);
    }
}
