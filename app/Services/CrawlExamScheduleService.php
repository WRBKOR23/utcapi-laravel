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
    public function __construct (CrawlQLDTData $crawl,
                                 AccountDepositoryContract $accountDepository,
                                 ModuleScoreDepositoryContract $moduleScoreDepository,
                                 ExamScheduleDepositoryContract $examScheduleDepository,
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
        $school_year_list = $this->moduleScoreDepository->getALLSchoolYear($id_student);
        $data             = $this->crawl->getStudentExamSchedule($school_year_list);
        $this->_insertMultiple($data);
        $this->_updateDataVersion($id_student);
    }

    public function crawl ($id_student)
    {
        parent::crawl($id_student);
        $school_year_list = [$this->moduleScoreDepository->getLatestSchoolYear($id_student)];
        $data             = $this->crawl->getStudentExamSchedule($school_year_list);
        $this->_upsert($data);
        $this->_updateDataVersion($id_student);
    }

    protected function _getQLDTPassword ($id_student): string
    {
        return $this->accountDepository->getQLDTPassword($id_student);
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
