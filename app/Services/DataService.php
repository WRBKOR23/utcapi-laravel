<?php

namespace App\Services;

use App\BusinessClasses\FileUploadHandler;
use App\Repositories\Contracts\AccountRepositoryContract;
use App\Repositories\Contracts\ClassRepositoryContract;
use App\Repositories\Contracts\DataVersionStudentRepositoryContract;
use App\Repositories\Contracts\ModuleClassRepositoryContract;
use App\Repositories\Contracts\ModuleRepositoryContract;
use App\Repositories\Contracts\ParticipateRepositoryContract;
use App\Repositories\Contracts\StudentRepositoryContract;
use App\Helpers\SharedData;
use App\Helpers\SharedFunctions;
use App\Services\Contracts\DataServiceContract;
use Exception;
use Illuminate\Support\Facades\Cache;

class DataService implements DataServiceContract
{
    private FileUploadHandler $fileUploadHandle;
    private DataVersionStudentRepositoryContract $dataVersionStudentRepository;
    private ModuleClassRepositoryContract $moduleClassRepository;
    private ParticipateRepositoryContract $participateRepository;
    private StudentRepositoryContract $studentRepository;
    private AccountRepositoryContract $accountRepository;
    private ModuleRepositoryContract $moduleRepository;
    private ClassRepositoryContract $classRepository;

    /**
     * DataService constructor.
     * @param FileUploadHandler $fileUploadHandle
     * @param DataVersionStudentRepositoryContract $dataVersionStudentRepository
     * @param ModuleClassRepositoryContract $moduleClassRepository
     * @param ParticipateRepositoryContract $participateRepository
     * @param StudentRepositoryContract $studentRepository
     * @param AccountRepositoryContract $accountRepository
     * @param ModuleRepositoryContract $moduleRepository
     * @param ClassRepositoryContract $classRepository
     */
    public function __construct (FileUploadHandler                    $fileUploadHandle,
                                 DataVersionStudentRepositoryContract $dataVersionStudentRepository,
                                 ModuleClassRepositoryContract        $moduleClassRepository,
                                 ParticipateRepositoryContract        $participateRepository,
                                 StudentRepositoryContract            $studentRepository,
                                 AccountRepositoryContract            $accountRepository,
                                 ModuleRepositoryContract             $moduleRepository,
                                 ClassRepositoryContract              $classRepository)
    {
        $this->fileUploadHandle             = $fileUploadHandle;
        $this->dataVersionStudentRepository = $dataVersionStudentRepository;
        $this->moduleClassRepository        = $moduleClassRepository;
        $this->participateRepository        = $participateRepository;
        $this->studentRepository            = $studentRepository;
        $this->accountRepository            = $accountRepository;
        $this->moduleRepository             = $moduleRepository;
        $this->classRepository              = $classRepository;
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

        return response($data['account']);
    }

    /**
     * @throws Exception
     */
    private function _getDataFromFile ($file) : array
    {
        $module_list = Cache::remember('module_list', 10080, function ()
        {
            return $this->moduleRepository->getAll();
        });

        return $this->fileUploadHandle->getData($file, $module_list);
    }

    private function _checkModuleClassException ($module_classes) : array
    {
        $exception         = [];
        $module_class_list = $this->moduleClassRepository->getModuleClasses2($module_classes);

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
        $this->_insertFacultyClasses($data['class']);
        $this->_insertStudents($data['student']);
        $this->_upsertDataVersionStudents($data['data_version_student']);
        $this->_insertParticipates($data['participate']);
    }

    private function _insertFacultyClasses ($data)
    {
        $this->classRepository->insertMultiple($data);
    }

    private function _insertStudents ($data)
    {
        $this->studentRepository->insertMultiple($data);
    }

    private function _insertParticipates ($data)
    {
        $this->participateRepository->insertMultiple($data);
    }

    private function _upsertDataVersionStudents ($data)
    {
        $this->dataVersionStudentRepository->upsertMultiple($data);
    }

    private function _checkException ($exception, $exception2) : bool
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
        $id_student_list = $this->_prepareData($data);
        $this->_createAccount($data);
        $this->_bindAccountToStudent($id_student_list);

        return response('OK');
    }

    private function _createAccount ($data)
    {
        $this->accountRepository->insertMultiple($data);
    }

    private function _bindAccountToStudent ($data)
    {
        $this->studentRepository->updateMultiple($data);
    }

    private function _prepareData (&$student_list) : array
    {
        $id_student_list = [];
        foreach ($student_list as &$student)
        {
            $student['password'] = bcrypt($student['password']);
            $id_student_list[]   = $student['username'];
        }

        return $id_student_list;
    }
}
