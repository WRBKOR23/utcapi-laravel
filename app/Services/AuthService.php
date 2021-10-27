<?php

namespace App\Services;

use App\Exceptions\InvalidAccountException;
use App\Repositories\Contracts\AccountRepositoryContract;
use App\Repositories\Contracts\DepartmentRepositoryContract;
use App\Repositories\Contracts\FacultyRepositoryContract;
use App\Repositories\Contracts\OtherDepartmentRepositoryContract;
use App\Repositories\Contracts\StudentRepositoryContract;
use App\Repositories\Contracts\TeacherRepositoryContract;

class AuthService implements Contracts\AuthServiceContract
{
    private TeacherRepositoryContract $teacherDepository;
    private StudentRepositoryContract $studentRepository;
    private AccountRepositoryContract $accountRepository;

    /**
     * @param TeacherRepositoryContract $teacherDepository
     * @param StudentRepositoryContract $studentRepository
     * @param AccountRepositoryContract $accountRepository
     */
    public function __construct (TeacherRepositoryContract         $teacherDepository,
                                 StudentRepositoryContract         $studentRepository,
                                 AccountRepositoryContract         $accountRepository)
    {
        $this->teacherDepository         = $teacherDepository;
        $this->studentRepository         = $studentRepository;
        $this->accountRepository         = $accountRepository;
    }

    /**
     * @throws InvalidAccountException
     */
    public function login ($username, $password) : array
    {
        $token = $this->_authenticate($username, $password);
        $data  = $this->_getUserInfo(auth()->user()->id);

        return [
            'data'  => $data,
            'token' => $token,
        ];
    }


    /**
     * @throws InvalidAccountException
     */
    private function _authenticate ($username, $password)
    {
        $credential = [
            'username' => $username,
            'password' => $password
        ];

        if (!$token = auth()->attempt($credential))
        {
            throw new InvalidAccountException();
        }

        return $token;
    }

    /**
     * @throws InvalidAccountException
     */
    protected function _getUserInfo ($id_account)
    {
        $permissions = $this->_getAccountPermissions($id_account);
        switch ($this->_verifyAccountUser($permissions))
        {
            case 'student':
                $data       = $this->studentRepository->get($id_account);
                $data->name = $data->student_name;
                unset($data->student_name);
                break;

            case 'teacher':
                $data       = $this->teacherDepository->get($id_account);
                $data->name = 'Gv ' . $data->teacher_name;
                unset($data->teacher_name);
                break;

            default:
                throw new InvalidAccountException();
        }

        return $data;
    }

    private function _getAccountPermissions ($id_account)
    {
        return $this->accountRepository->getPermissions($id_account);
    }

    private function _verifyAccountUser ($permissions) : string
    {
        if (in_array(11, $permissions))
        {
            return 'student';
        }

        return 'teacher';
    }

    public function logout ()
    {
        auth()->logout();
    }
}