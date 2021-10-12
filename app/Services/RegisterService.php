<?php


namespace App\Services;


use App\BusinessClasses\CrawlQLDTData;
use App\Repositories\Contracts\AccountRepositoryContract;
use App\Repositories\Contracts\ClassRepositoryContract;
use App\Repositories\Contracts\DataVersionStudentRepositoryContract;
use App\Repositories\Contracts\FacultyRepositoryContract;
use App\Repositories\Contracts\StudentRepositoryContract;
use App\Helpers\SharedData;
use App\Services\Contracts\FacultyClassServiceContract;
use Exception;
use Illuminate\Support\Facades\Cache;

class RegisterService implements Contracts\RegisterServiceContract
{
    private CrawlQLDTData $crawl;
    private ClassRepositoryContract $classRepositoryContract;
    private AccountRepositoryContract $accountRepository;
    private StudentRepositoryContract $studentRepository;
    private DataVersionStudentRepositoryContract $dataVersionStudentRepository;

    /**
     * @param CrawlQLDTData $crawl
     * @param ClassRepositoryContract $classRepositoryContract
     * @param AccountRepositoryContract $accountRepository
     * @param StudentRepositoryContract $studentRepository
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
    public function process1 ($id_student, $qldt_password)
    {
        $this->_loginQLDT($id_student, $qldt_password);
        if ($this->_checkAccountExist($id_student))
        {
            return response('Account available', 406);
        }
        else
        {
            return response('', 200);
        }
    }


    private function _checkAccountExist ($username) : bool
    {
        $account = $this->accountRepository->get($username);
        return !empty($account);
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
        $student_info       = $this->crawl->getStudentInfo();
        $academic_year_list = $this->_getAcademicYears();

        $account['username']      = $data['id_student'];
        $account['password']      = bcrypt($data['password']);
        $account['qldt_password'] = md5($data['qldt_password']);
        $account['permission']    = 0;

        $student['id']           = $data['id_student'];
        $student['student_name'] = $student_info['student_name'];
        $student['birth']        = $student_info['birth'];
        $student['id_class']     = $student_info['academic_year'] . '.' . $data['id_class'];

        $class['id']               = $student['id_class'];
        $class['id_academic_year'] = $academic_year_list[$student_info['academic_year']];
        $class['class_name']       = $this->_getInfoClass($class['id'], $data['id_faculty'])['class_name'];
        $class['id_faculty']       = $data['id_faculty'];

        $data_version['id_student'] = $data['id_student'];

        return [
            'data_version' => $data_version,
            'account'      => $account,
            'student'      => $student,
            'class'        => $class
        ];
    }

    private function _getAcademicYears ()
    {
        return Cache::get('academic_years') != null ?
            Cache::get('academic_years') : Cache::get('academic_years_backup');
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
            $class_info               = SharedData::$faculty_class_and_major_info[substr($class, 0,
                                                                                         strlen($class) - 1)];
            $name_academic_year       = substr_replace($academic_year, 'hóa ', 1, 0);
            $class_info['class_name'] = $class_info['class_name'] . ' ' . $num . ' - ' . $name_academic_year;
        }
        else
        {
            $class_info               = SharedData::$faculty_class_and_major_info[$class];
            $name_academic_year       = substr_replace($academic_year, 'hóa ', 1, 0);
            $class_info['class_name'] = $class_info['class_name'] . ' - ' . $name_academic_year;
        }

        if ($class_info['id_faculty'] != $id_faculty)
        {
            throw new Exception('faculty register');
        }
        $class_info['id_class'] = $id_class;

        return $class_info;
    }

    private function _createData (&$data)
    {
        $id_account = $this->accountRepository->insertGetId($data['account']);
        $this->classRepositoryContract->insert($data['class']);
        $data['student']['id_account'] = $id_account;
        $this->studentRepository->insert($data['student']);
        $this->dataVersionStudentRepository->insert($data['data_version']);
    }
}

