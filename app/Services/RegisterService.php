<?php


namespace App\Services;


use App\BusinessClass\CrawlQLDTData;
use App\Depositories\Contracts\AccountDepositoryContract;
use App\Depositories\Contracts\ClassDepositoryContract;
use App\Depositories\Contracts\FacultyDepositoryContract;
use App\Depositories\Contracts\StudentDepositoryContract;
use App\Services\Contracts\FacultyClassServiceContract;
use Exception;

class RegisterService implements Contracts\RegisterServiceContract
{
    private CrawlQLDTData $crawl;
    private AccountDepositoryContract $accountDepository;
    private StudentDepositoryContract $studentDepository;
    private ClassDepositoryContract $classDepositoryContract;

    /**
     * RegisterService constructor.
     * @param CrawlQLDTData $crawl
     * @param AccountDepositoryContract $accountDepository
     * @param StudentDepositoryContract $studentDepository
     * @param ClassDepositoryContract $classDepositoryContract
     */
    public function __construct (CrawlQLDTData $crawl, AccountDepositoryContract $accountDepository, StudentDepositoryContract $studentDepository, ClassDepositoryContract $classDepositoryContract)
    {
        $this->crawl                   = $crawl;
        $this->accountDepository       = $accountDepository;
        $this->studentDepository       = $studentDepository;
        $this->classDepositoryContract = $classDepositoryContract;
    }

    /**
     * @throws Exception
     */
    public function register ($data): bool
    {
        if ($this->_checkAccountExist($data['id_student']))
        {
            return false;
        }

        $this->_loginQLDT($data['id_student'], $data['qldt_password']);
        $data = $this->_setupData($data);
        $this->_createData($data);

        return true;
    }

    private function _checkAccountExist ($username): bool
    {
        $account = $this->accountDepository->get($username);

        return !empty($account);
    }

    /**
     * @throws Exception
     */
    private function _loginQLDT ($id_student, $qldt_password)
    {
        $this->crawl->loginQLDT($id_student, md5($qldt_password));
    }

    private function _setupData ($data): array
    {
        $student_info = $this->crawl->getStudentInfo();

        $account['username']      = $data['id_student'];
        $account['password']      = bcrypt($data['password']);
        $account['qldt_password'] = md5($data['qldt_password']);
        $account['permission']    = 0;

        $student['ID_Student']   = $data['id_student'];
        $student['Student_Name'] = $student_info['student_name'];
        $student['DoB_Student']  = $student_info['dob'];
        $student['ID_Class']     = $student_info['academic_year'] . '.' . $data['id_class'];

        $class['ID_Class']      = $student['ID_Class'];
        $class['Academic_Year'] = $student_info['academic_year'];
        $class['Class_Name']    = $student_info['class_name'];
        $class['ID_Faculty']    = $student_info['id_faculty'];

        return [
            'account' => $account,
            'student' => $student,
            'class'   => $class
        ];
    }

    private function _createData (&$data)
    {
        $id_account = $this->accountDepository->insertGetId($data['account']);

        $this->classDepositoryContract->upsert($data['class']);

        $data['student']['ID_Account'] = $id_account;
        $this->studentDepository->insert($data['student']);
    }
}

