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
    private OtherDepartmentRepositoryContract $otherDepartmentDepository;
    private DepartmentRepositoryContract $departmentDepository;
    private TeacherRepositoryContract $teacherDepository;
    private FacultyRepositoryContract $facultyDepository;

    /**
     * LoginService constructor.
     * @param OtherDepartmentRepositoryContract $otherDepartmentDepository
     * @param DepartmentRepositoryContract $departmentDepository
     * @param TeacherRepositoryContract $teacherDepository
     * @param FacultyRepositoryContract $facultyDepository
     * @param AccountRepositoryContract $accountDepository
     */
    public function __construct (OtherDepartmentRepositoryContract $otherDepartmentDepository,
                                 DepartmentRepositoryContract      $departmentDepository,
                                 TeacherRepositoryContract         $teacherDepository,
                                 FacultyRepositoryContract         $facultyDepository,
                                 AccountRepositoryContract         $accountDepository)
    {
        parent::__construct($accountDepository);
        $this->otherDepartmentDepository = $otherDepartmentDepository;
        $this->departmentDepository      = $departmentDepository;
        $this->facultyDepository         = $facultyDepository;
        $this->teacherDepository         = $teacherDepository;
    }

    /**
     * @throws InvalidAccountException
     */
    protected function _customGetAccountOwnerInfo ($id_account, $permission)
    {
        switch ($permission)
        {
            case 1:
                $data       = $this->teacherDepository->get($id_account);
                $data->name = 'Gv.' . $data->teacher_name;
                break;

            case 2:
                $data       = $this->departmentDepository->get($id_account);
                $data->name = 'Bộ môn ' . $data->department_name;
                break;
            case 3:
                $data       = $this->facultyDepository->get($id_account);
                $data->name = 'Khoa ' . $data->faculty_name;
                break;

            case 4:
                $data       = $this->otherDepartmentDepository->get($id_account);
                $data->name = $data->other_department_name;
                break;

            default:
                throw new InvalidAccountException();

        }
        $this->_setSession($data->id_account, $data->name);
    }
}
