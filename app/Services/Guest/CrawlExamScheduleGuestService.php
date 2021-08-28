<?php


namespace App\Services\Guest;


use App\BusinessClass\CrawlQLDTData;
use App\Depositories\Contracts\AccountDepositoryContract;
use App\Depositories\Contracts\ExamScheduleGuestDepositoryContract;
use App\Depositories\Contracts\GuestInfoDepositoryContract;
use App\Depositories\Contracts\ModuleScoreGuestDepositoryContract;
use App\Services\AbstractClasses\ACrawlService;

class CrawlExamScheduleGuestService extends ACrawlService
{
    private GuestInfoDepositoryContract $guestInfoDepository;
    private ModuleScoreGuestDepositoryContract $moduleScoreDepository;
    private ExamScheduleGuestDepositoryContract $examScheduleDepository;

    /**
     * CrawlExamScheduleService constructor.
     * @param CrawlQLDTData $crawl
     * @param GuestInfoDepositoryContract $guestInfoDepository
     * @param ModuleScoreGuestDepositoryContract $moduleScoreDepository
     * @param ExamScheduleGuestDepositoryContract $examScheduleDepository
     */
    public function __construct (CrawlQLDTData $crawl,
                                 GuestInfoDepositoryContract $guestInfoDepository,
                                 ModuleScoreGuestDepositoryContract $moduleScoreDepository,
                                 ExamScheduleGuestDepositoryContract $examScheduleDepository)
    {
        parent::__construct($crawl);
        $this->guestInfoDepository    = $guestInfoDepository;
        $this->moduleScoreDepository  = $moduleScoreDepository;
        $this->examScheduleDepository = $examScheduleDepository;
    }

    public function crawlAll ($id_student): bool
    {
        if (!parent::crawl($id_student))
        {
            return false;
        }
        $school_year_list = $this->moduleScoreDepository->getALLSchoolYear($id_student);
        $data             = $this->crawl->getStudentExamSchedule($school_year_list);
        $this->_insertMultiple($data);
        $this->_updateDataVersion($id_student);

        return true;
    }

    public function crawl ($id_student): bool
    {
        if (!parent::crawl($id_student))
        {
            return false;
        }
        $school_year_list = [$this->moduleScoreDepository->getLatestSchoolYear($id_student)];
        $data             = $this->crawl->getStudentExamSchedule($school_year_list);
        $this->_upsert($data);
        $this->_updateDataVersion($id_student);

        return true;
    }

    protected function _getQLDTPassword ($id_student): string
    {
        return $this->guestInfoDepository->getPassword($id_student);
    }

    protected function _updateDataVersion ($id_student)
    {
        $this->guestInfoDepository->updateDataVersion($id_student, 'Exam_Schedule_Data_Version');
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
