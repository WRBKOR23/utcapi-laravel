<?php


namespace App\Services;


use App\BusinessClass\CrawlQLDTData;
use App\Depositories\Contracts\AccountDepositoryContract;
use App\Depositories\Contracts\DataVersionStudentDepositoryContract;
use App\Depositories\Contracts\ExamScheduleDepositoryContract;
use App\Depositories\Contracts\ModuleScoreDepositoryContract;
use App\Services\AbstractClasses\ACrawlService;

class CrawlExamScheduleService extends ACrawlService
{
    private AccountDepositoryContract $accountDepository;
    private ModuleScoreDepositoryContract $moduleScoreDepository;
    private ExamScheduleDepositoryContract $examScheduleDepository;
    private DataVersionStudentDepositoryContract $dataVersionStudentDepository;

    /**
     * CrawlExamScheduleService constructor.
     * @param CrawlQLDTData $crawl
     * @param AccountDepositoryContract $accountDepository
     * @param ModuleScoreDepositoryContract $moduleScoreDepository
     * @param ExamScheduleDepositoryContract $examScheduleDepository
     * @param DataVersionStudentDepositoryContract $dataVersionStudentDepository
     */
    public function __construct (CrawlQLDTData                        $crawl,
                                 AccountDepositoryContract            $accountDepository,
                                 ModuleScoreDepositoryContract        $moduleScoreDepository,
                                 ExamScheduleDepositoryContract       $examScheduleDepository,
                                 DataVersionStudentDepositoryContract $dataVersionStudentDepository)
    {
        parent::__construct($crawl);
        $this->accountDepository            = $accountDepository;
        $this->moduleScoreDepository        = $moduleScoreDepository;
        $this->examScheduleDepository       = $examScheduleDepository;
        $this->dataVersionStudentDepository = $dataVersionStudentDepository;
    }

    public function crawlAll ($id_student)
    {
        parent::crawl($id_student);
        $data = $this->crawl->getStudentExamSchedule(true);
        $this->_insertMultiple($data);
        $this->_updateDataVersion($id_student);
    }

    public function crawl ($id_student)
    {
        parent::crawl($id_student);
        $data = $this->crawl->getStudentExamSchedule(false);
        $this->_verifyData($data);
        $this->_verifyOldData($data, $id_student);
        $this->_upsert($data);
        $this->_updateDataVersion($id_student);
    }

    protected function _getQLDTPassword ($id_student) : string
    {
        return $this->accountDepository->getQLDTPassword($id_student);
    }

    private function _verifyData (&$data)
    {
        if (count($data) == 2)
        {
            array_shift($data);
        }
    }

    private function _verifyOldData ($data, $id_student)
    {
        $latest_school_year = $this->_getLatestSchoolYear($id_student);
        foreach ($data as $school_year => $module)
        {
            if ($latest_school_year != null)
            {
                if ($school_year < $latest_school_year)
                {
                    $this->_deleteWrongExamSchedules($id_student, $latest_school_year);
                    return;
                }

                if (empty($module) && $school_year == $latest_school_year)
                {
                    $this->_deleteWrongExamSchedules($id_student, $latest_school_year);
                    return;
                }
            }
        }
    }

    private function _getLatestSchoolYear ($id_student)
    {
        return $this->examScheduleDepository->getLatestSchoolYear($id_student);
    }

    private function _deleteWrongExamSchedules ($id_student, $school_year)
    {
        $this->examScheduleDepository->delete($id_student, $school_year);
    }

    protected function _updateDataVersion ($id_student)
    {
        $this->dataVersionStudentDepository->updateDataVersion($id_student, 'exam_schedule');
    }

    protected function _customInsertMultiple ($data)
    {
        $this->examScheduleDepository->insertMultiple($data);
    }

    protected function _customUpsert ($data)
    {
        $this->examScheduleDepository->upsert($data);
    }
}
