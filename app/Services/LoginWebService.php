<?php

namespace App\Services;

use App\Depositories\Contracts\AccountDepositoryContract;
use App\Depositories\Contracts\DepartmentDepositoryContract;
use App\Depositories\Contracts\FacultyDepositoryContract;
use App\Depositories\Contracts\OtherDepartmentDepositoryContract;
use App\Depositories\Contracts\TeacherDepositoryContract;
use App\Exceptions\InvalidAccountException;
use App\Services\AbstractClasses\ALoginService;
use Illuminate\Support\Facades\Storage;

class LoginWebService extends ALoginService
{
    private OtherDepartmentDepositoryContract $otherDepartmentDepository;
    private DepartmentDepositoryContract $departmentDepository;
    private TeacherDepositoryContract $teacherDepository;
    private FacultyDepositoryContract $facultyDepository;

    /**
     * LoginService constructor.
     * @param OtherDepartmentDepositoryContract $otherDepartmentDepository
     * @param DepartmentDepositoryContract $departmentDepository
     * @param TeacherDepositoryContract $teacherDepository
     * @param FacultyDepositoryContract $facultyDepository
     * @param AccountDepositoryContract $accountDepository
     */
    public function __construct (OtherDepartmentDepositoryContract $otherDepartmentDepository,
                                 DepartmentDepositoryContract $departmentDepository,
                                 TeacherDepositoryContract $teacherDepository,
                                 FacultyDepositoryContract $facultyDepository,
                                 AccountDepositoryContract $accountDepository)
    {
        parent::__construct($accountDepository);
        $this->otherDepartmentDepository = $otherDepartmentDepository;
        $this->departmentDepository      = $departmentDepository;
        $this->facultyDepository         = $facultyDepository;
        $this->teacherDepository         = $teacherDepository;
    }

    public
    function login ($username, $password): array
    {
        return parent::login($username, $password);
    }

    /**
     * @throws InvalidAccountException
     */
    protected
    function _customGetAccountOwnerInfo ($id_account, $permission)
    {
        switch ($permission)
        {
            case 1:
                $data       = $this->teacherDepository->get($id_account);
                $data->Name = 'Gv.' . $data->Name_Teacher;
                break;

            case 2:
                $data       = $this->departmentDepository->get($id_account);
                $data->Name = 'Bộ môn ' . $data->Department_Name;
                break;
            case 3:
                $data       = $this->facultyDepository->get($id_account);
                $data->Name = 'Khoa ' . $data->Faculty_Name;
                break;

            case 4:
                $data       = $this->otherDepartmentDepository->get($id_account);
                $data->Name = $data->Other_Department_Name;
                break;

            default:
                throw new InvalidAccountException();

        }
        $this->_setSession($data->ID_Account, $data->Name);
    }
}
