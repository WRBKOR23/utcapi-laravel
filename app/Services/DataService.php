<?php

namespace App\Services;

use App\BusinessClass\FileUploadHandle;
use App\Depositories\Contracts\AccountDepositoryContract;
use App\Depositories\Contracts\ClassDepositoryContract;
use App\Depositories\Contracts\DataVersionStudentDepositoryContract;
use App\Depositories\Contracts\ParticipateDepositoryContract;
use App\Depositories\Contracts\StudentDepositoryContract;
use App\Helpers\SharedFunctions;
use App\Services\Contracts\DataServiceContract;
use Exception;

class DataService implements DataServiceContract
{
    private FileUploadHandle $fileUploadHandle;
    private DataVersionStudentDepositoryContract $dataVersionStudentDepository;
    private ParticipateDepositoryContract $participateDepository;
    private StudentDepositoryContract $studentDepository;
    private AccountDepositoryContract $accountDepository;
    private ClassDepositoryContract $classDepository;

    /**
     * DataService constructor.
     * @param FileUploadHandle $fileUploadHandle
     * @param DataVersionStudentDepositoryContract $dataVersionStudentDepository
     * @param ParticipateDepositoryContract $participateDepository
     * @param StudentDepositoryContract $studentDepository
     * @param AccountDepositoryContract $accountDepository
     * @param ClassDepositoryContract $classDepository
     */
    public function __construct (FileUploadHandle $fileUploadHandle, DataVersionStudentDepositoryContract $dataVersionStudentDepository, ParticipateDepositoryContract $participateDepository, StudentDepositoryContract $studentDepository, AccountDepositoryContract $accountDepository, ClassDepositoryContract $classDepository)
    {
        $this->fileUploadHandle             = $fileUploadHandle;
        $this->dataVersionStudentDepository = $dataVersionStudentDepository;
        $this->participateDepository        = $participateDepository;
        $this->studentDepository            = $studentDepository;
        $this->accountDepository            = $accountDepository;
        $this->classDepository              = $classDepository;
    }

    /**
     * @throws Exception
     */
    public function process1 ($file): array
    {
        $data = $this->_getDataFromFile($file);
        $this->_insertFacultyClasses($data['class']['sql'], $data['class']['arr']);
        $this->_insertStudents($data['student']['sql'], $data['student']['arr']);
        $this->_insertDataVersionStudents($data['data_version']['sql'], $data['data_version']['arr']);
        $this->_updateScheduleVersion($data['data_version']['arr']);
        $fk_exception = $this->_insertParticipates($data['participate']['sql'], $data['participate']['arr']);
        $exception    = $data['exception_json'];

        $arr = $this->_checkException($fk_exception, $exception);

        return [$data['account']['arr'], $arr];
    }

    /**
     * @throws Exception
     */
    private function _getDataFromFile ($file): array
    {
        return $this->fileUploadHandle->getData($file);
    }

    private function _insertFacultyClasses ($part_of_sql, $data)
    {
        $this->classDepository->insertMultiple($part_of_sql, $data);
    }

    private function _insertStudents ($part_of_sql, $data)
    {
        $this->studentDepository->insertMultiple($part_of_sql, $data);
    }

    private function _insertParticipates ($part_of_sql, $data)
    {
        return $this->participateDepository->insertMultiple($part_of_sql, $data);
    }

    private function _insertDataVersionStudents ($part_of_sql, $data)
    {
        $this->dataVersionStudentDepository->insertMultiple($part_of_sql, $data);
    }

    private function _updateScheduleVersion ($id_student_list)
    {
        $this->dataVersionStudentDepository->updateMultiple2($id_student_list, 'Schedule');
    }

    private function _checkException ($fk_exception, $exception): array
    {
        $arr  = [];
        if (!empty($exception))
        {
            $file_name = '1-' . $this->fileUploadHandle->getOldFileName() . '.txt';
            $title     = 'File excel cùng tên hiện tại có chứa lớp học ko có mã lớp học phần đi kèm:';
            SharedFunctions::printFileImportException($file_name, $exception, $title);

            $arr[]        = $file_name;
        }
        if (!$fk_exception)
        {
            $file_name = '2-' . $this->fileUploadHandle->getOldFileName() . '.txt';
            $title     = 'Cơ sở dữ liệu hiện tại không có một vài mã lớp học phần trong file excel cùng tên này';
            SharedFunctions::printFileImportException($file_name, [], $title);

            $arr[]        = $file_name;
        }

        return $arr;
    }



    public function process2 ($data)
    {
        $data = $this->_prepareData($data);
        $this->_createAccount($data['create'][1], $data['create'][0]);
        $this->_bindAccountToStudent($data['bind'][1], $data['bind'][0]);
    }

    private function _createAccount ($part_of_sql, $data)
    {
        $this->accountDepository->insertMultiple($part_of_sql, $data);
    }

    private function _bindAccountToStudent ($part_of_sql, $data)
    {
        $this->studentDepository->updateMultiple($part_of_sql, $data);
    }

    private function _prepareData ($student_list): array
    {
        $id_student_list = [];
        $part_of_sql_1   = '';
        $part_of_sql_2   = '';
        for ($i = 0; $i < count($student_list); $i += 2)
        {
            $student_list[$i + 1] = password_hash($student_list[$i + 1], PASSWORD_DEFAULT);
            $part_of_sql_1        .= '(?,null,?,null,0),';

            $id_student_list[] = $student_list[$i];
            $part_of_sql_2     .= '?,';
        }
        $part_of_sql_1 = rtrim($part_of_sql_1, ',');
        $part_of_sql_2 = rtrim($part_of_sql_2, ',');

        return [
            'create' => [$student_list, $part_of_sql_1],
            'bind' => [$id_student_list, $part_of_sql_2]
        ];
    }
}
