<?php

namespace App\Services;

use App\BusinessClasses\CrawlQLDTData;
use App\Repositories\Contracts\AccountRepositoryContract;
use App\Repositories\Contracts\ClassRepositoryContract;
use App\Repositories\Contracts\DataVersionStudentRepositoryContract;
use App\Repositories\Contracts\StudentRepositoryContract;
use App\Helpers\SharedData;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class RegisterService implements Contracts\RegisterServiceContract
{
    private CrawlQLDTData $crawl;
    private ClassRepositoryContract $classRepositoryContract;
    private AccountRepositoryContract $accountRepository;
    private StudentRepositoryContract $studentRepository;
    private DataVersionStudentRepositoryContract $dataVersionStudentRepository;

    /**
     * @param CrawlQLDTData                        $crawl
     * @param ClassRepositoryContract              $classRepositoryContract
     * @param AccountRepositoryContract            $accountRepository
     * @param StudentRepositoryContract            $studentRepository
     * @param DataVersionStudentRepositoryContract $dataVersionStudentRepository
     */
    public function __construct (CrawlQLDTData                        $crawl,
                                 ClassRepositoryContract              $classRepositoryContract,
                                 AccountRepositoryContract            $accountRepository,
                                 StudentRepositoryContract            $studentRepository,
                                 DataVersionStudentRepositoryContract $dataVersionStudentRepository)
    {
        $this->crawl                        = $crawl;
        $this->classRepositoryContract      = $classRepositoryContract;
        $this->accountRepository            = $accountRepository;
        $this->studentRepository            = $studentRepository;
        $this->dataVersionStudentRepository = $dataVersionStudentRepository;
    }

    /**
     * @throws Exception
     */
    public function process1 ($id_student, $qldt_password) : bool
    {
        $this->_loginQLDT($id_student, $qldt_password);
        return $this->_checkAccountExist($id_student);
    }


    private function _checkAccountExist ($username) : bool
    {
        $account = $this->accountRepository->get($username);
        return empty($account);
    }

    /**
     * @throws Exception
     */
    private function _loginQLDT ($id_student, $qldt_password)
    {
        $this->crawl->loginQLDT($id_student, md5($qldt_password));
    }

    /**
     * @throws Exception
     */
    public function process2 ($data)
    {
        $this->_loginQLDT($data['id_student'], $data['qldt_password']);
        $data = $this->_setupData($data);
        $this->_createData($data);

        return response('', 201);
    }

    /**
     * @throws Exception
     */
    private function _setupData ($data) : array
    {
        $student_info   = $this->crawl->getStudentInfo();
        $academic_years = $this->_getAcademicYears();

        $account['username']      = $data['id_student'];
        $account['password']      = bcrypt($data['password']);
        $account['qldt_password'] = md5($data['qldt_password']);


        $student['id']           = $data['id_student'];
        $student['student_name'] = $student_info['student_name'];
        $student['birth']        = $student_info['birth'];
        $student['id_class']     = $student_info['academic_year'] . '.' . $data['id_class'];

        $class['id']               = $student['id_class'];
        $class['id_academic_year'] = $academic_years[$student_info['academic_year']];
        $class['class_name']       = $this->_getInfoClass($class['id'],
                                                          $data['id_faculty'])['class_name'];
        $class['id_faculty']       = $data['id_faculty'];
        $class['id_training_type'] = $this->_getIDTrainingType($student_info['academic_year']);

        $data_version_student['id_student'] = $data['id_student'];

        return [
            'class'                => $class,
            'student'              => $student,
            'account'              => $account,
            'data_version_student' => $data_version_student,
        ];
    }

    private function _getAcademicYears ()
    {
        return Cache::get('academic_years') != null ?
            Cache::get('academic_years') : Cache::get('academic_years_backup');
    }

    private function _getIDTrainingType ($academic_year) : string
    {
        return strpos($academic_year, 'LTK') !== false ? '3' : '1';
    }

    /**
     * @throws Exception
     */
    private function _getInfoClass ($id_class, $id_faculty)
    {
        $id_class      = preg_replace('/\s+/', '', $id_class);
        $arr           = explode('.', $id_class);
        $academic_year = $arr[0];

        unset($arr[0]);
        $class = '';
        foreach ($arr as $a)
        {
            $class .= $a . '.';
        }
        $class = rtrim($class, '.');

        $num = substr($class, strlen($class) - 1, 1);
        if (is_numeric($num))
        {
            $class_info = SharedData::$faculty_class_and_major_info[substr($class, 0,
                                                                           strlen($class) - 1)];

            $academic_year_name       = str_replace('K', ' Khóa ', $academic_year);
            $academic_year_name       = str_replace('LT', 'Liên thông', $academic_year_name);
            $class_info['class_name'] = $class_info['class_name'] . ' ' . $num . ' - ' .
                                        $academic_year_name;
        }
        else
        {
            $class_info = SharedData::$faculty_class_and_major_info[$class];

            $academic_year_name       = str_replace('K', ' Khóa ', $academic_year);
            $academic_year_name       = str_replace('LT', 'Liên thông', $academic_year_name);
            $class_info['class_name'] = $class_info['class_name'] . ' - ' . $academic_year_name;
        }

        if ($class_info['id_faculty'] != $id_faculty)
        {
            throw new Exception('invalid id_faculty register');
        }
        $class_info['id_class'] = $id_class;

        return $class_info;
    }

    private function _createData ($data)
    {
        DB::transaction(function () use ($data)
        {
            $this->_createOrUpdateClass($data['class']);
            $id_account = $this->_createAccount($data['account']);
            $this->_createAccountsRoles($id_account);
            $this->_createStudent($data['student'], $id_account);
            $this->_createDataVersionStudent($data['data_version_student']);
        }, 2);
    }

    private function _createOrUpdateClass ($class)
    {
        $this->classRepositoryContract->upsert($class);
    }

    private function _createAccount ($account)
    {
        return $this->accountRepository->insertGetId($account);
    }

    private function _createAccountsRoles ($id_account)
    {
        $this->accountRepository->insertPivotMultiple($id_account, ['11']);
    }

    private function _createStudent ($student, $id_account)
    {
        $student['id_account'] = $id_account;
        $this->studentRepository->insert($student);
    }

    private function _createDataVersionStudent ($data_version_student)
    {
        $this->dataVersionStudentRepository->insert($data_version_student);
    }
}

