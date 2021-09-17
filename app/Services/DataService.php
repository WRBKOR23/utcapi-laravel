<?php

namespace App\Services;

use App\BusinessClass\FileUploadHandler;
use App\Depositories\Contracts\AccountDepositoryContract;
use App\Depositories\Contracts\ClassDepositoryContract;
use App\Depositories\Contracts\DataVersionStudentDepositoryContract;
use App\Depositories\Contracts\ModuleClassDepositoryContract;
use App\Depositories\Contracts\ModuleDepositoryContract;
use App\Depositories\Contracts\ParticipateDepositoryContract;
use App\Depositories\Contracts\StudentDepositoryContract;
use App\Helpers\SharedData;
use App\Helpers\SharedFunctions;
use App\Services\Contracts\DataServiceContract;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class DataService implements DataServiceContract
{
    private FileUploadHandler $fileUploadHandle;
    private DataVersionStudentDepositoryContract $dataVersionStudentDepository;
    private ModuleClassDepositoryContract $moduleClassDepository;
    private ParticipateDepositoryContract $participateDepository;
    private StudentDepositoryContract $studentDepository;
    private AccountDepositoryContract $accountDepository;
    private ModuleDepositoryContract $moduleDepository;
    private ClassDepositoryContract $classDepository;

    /**
     * DataService constructor.
     * @param FileUploadHandler $fileUploadHandle
     * @param DataVersionStudentDepositoryContract $dataVersionStudentDepository
     * @param ModuleClassDepositoryContract $moduleClassDepository
     * @param ParticipateDepositoryContract $participateDepository
     * @param StudentDepositoryContract $studentDepository
     * @param AccountDepositoryContract $accountDepository
     * @param ModuleDepositoryContract $moduleDepository
     * @param ClassDepositoryContract $classDepository
     */
    public function __construct (FileUploadHandler $fileUploadHandle, DataVersionStudentDepositoryContract $dataVersionStudentDepository, ModuleClassDepositoryContract $moduleClassDepository, ParticipateDepositoryContract $participateDepository, StudentDepositoryContract $studentDepository, AccountDepositoryContract $accountDepository, ModuleDepositoryContract $moduleDepository, ClassDepositoryContract $classDepository)
    {
        $this->fileUploadHandle             = $fileUploadHandle;
        $this->dataVersionStudentDepository = $dataVersionStudentDepository;
        $this->moduleClassDepository        = $moduleClassDepository;
        $this->participateDepository        = $participateDepository;
        $this->studentDepository            = $studentDepository;
        $this->accountDepository            = $accountDepository;
        $this->moduleDepository             = $moduleDepository;
        $this->classDepository              = $classDepository;
    }

    /**
     * @throws Exception
     */
    public function process1 ($file)
    {
        $data               = $this->_getDataFromFile($file);
        $data['exception2'] = $this->_checkModuleClassException($data['module_class']);

        if ($this->_checkException($data['exception1'], $data['exception2']))
        {
            return response('', 406);
        }
        $this->_pushDataToDatabase($data);

        return response($data['account']['arr']);
    }

    /**
     * @throws Exception
     */
    private function _getDataFromFile ($file): array
    {
        $module_list = Cache::remember('module_list', 10080, function ()
        {
            return $this->moduleDepository->getAll();
        });
        return $this->fileUploadHandle->getData($file, $module_list);
    }

    private function _checkModuleClassException ($module_classes): array
    {
        $exception         = [];
        $module_class_list = $this->moduleClassDepository->getModuleClasses2($module_classes);

        foreach ($module_classes as $module_class)
        {
            if (!in_array($module_class, $module_class_list))
            {
                $exception[] = $module_class;
            }
        }

        return $exception;
    }

    private function _pushDataToDatabase ($data)
    {
        $this->_insertFacultyClasses($data['class']['sql'], $data['class']['arr']);
        $this->_insertStudents($data['student']['sql'], $data['student']['arr']);
        $this->_insertDataVersionStudents($data['data_version']['sql'], $data['data_version']['arr']);
        $this->_updateScheduleVersion($data['data_version']['arr']);
        $this->_insertParticipates($data['participate']['sql'], $data['participate']['arr']);
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
        $this->participateDepository->insertMultiple($part_of_sql, $data);
    }

    private function _insertDataVersionStudents ($part_of_sql, $data)
    {
        $this->dataVersionStudentDepository->insertMultiple($part_of_sql, $data);
    }

    private function _updateScheduleVersion ($id_student_list)
    {
        $this->dataVersionStudentDepository->updateMultiple2($id_student_list, 'Schedule');
    }

    private function _checkException ($exception, $exception2): bool
    {
        $file_name = $this->fileUploadHandle->getOldFileName() . '.txt';
        $message   = '';

        if (!empty($exception))
        {
            $message .= 'Cơ sở dữ liệu hiện tại không có một vài mã học phần trong file excel cùng tên này:' . PHP_EOL;;
            foreach ($exception as $module)
            {
                $message .= $module . PHP_EOL;
            }
        }
        if (!empty($exception2))
        {
            $message .= 'Cơ sở dữ liệu hiện tại không có một vài mã lớp học phần trong file excel cùng tên này:' . PHP_EOL;;
            foreach ($exception2 as $module_class)
            {
                $message .= $module_class . PHP_EOL;
            }
        }
        SharedFunctions::printFileImportException($file_name, $message);

        return $message != '';
    }


    public function process2 ($data)
    {
        $data = $this->_prepareData($data);
        $this->_createAccount($data['create'][1], $data['create'][0]);
        $this->_bindAccountToStudent($data['bind'][1], $data['bind'][0]);

        return response('OK');
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
            'bind'   => [$id_student_list, $part_of_sql_2]
        ];
    }
}
